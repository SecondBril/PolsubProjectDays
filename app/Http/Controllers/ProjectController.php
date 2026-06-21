<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Program;
use App\Models\Category;
use App\Models\CourseClass;
use App\Models\Tag;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Services\ProjectViewTracker;
use App\Notifications\ProjectApprovedNotification;
use App\Notifications\ProjectRejectedNotification;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Project::with(['program', 'category', 'courseClass.course', 'teamMembers']);

        /** @var User|null $user */
        $user = Auth::user();

        // Logika Filter Berdasarkan Role
        if ($user instanceof User && $user->hasRole('mahasiswa')) {
            $query->where(function ($q) use ($user) {
                $q->where('team_lead_id', $user->id)
                ->orWhereHas('teamMembers', function ($subQ) use ($user) {
                    $subQ->where('users.id', $user->id);
                });
            });

            $projects = $query->latest()->paginate(12)->withQueryString();
            return view('users.project.index', compact('projects'));
        }

        // Role Admin / Dosen
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('team_name', 'like', '%' . $request->search . '%');
        }

        $projects = $query->latest()->paginate(12)->withQueryString();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        return DB::transaction(function () use ($request) {
            /** @var User $user */
            $user = Auth::user();

            // Jika admin/dosen, ketua diambil dari input form, jika mahasiswa otomatis dirinya sendiri
            $isAdmin = $user->hasAnyRole(['admin', 'dosen']);
            $teamLeadId = $isAdmin ? $request->input('team_lead_id') : Auth::id();

            $project = Project::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title) . '-' . Str::lower(Str::random(5)),
                'description' => $request->description,
                'short_description' => $request->short_description,
                'program_id' => $request->program_id,
                'category_id' => $request->category_id,
                'course_class_id' => $request->course_class_id,
                'cohort' => $request->cohort,
                'demo_url' => $request->demo_url,
                'repository_url' => $request->repository_url,
                'documentation_url' => $request->documentation_url,
                'status' => $isAdmin ? 'published' : 'pending',
                'submitted_at' => now(),
                'team_lead_id' => $teamLeadId, // Menggunakan variabel dinamis
                'team_name' => $request->team_name,
            ]);

            // Set data tim, pastikan ketua masuk dengan role 'ketua'
            $teamData = [$teamLeadId => ['role' => 'ketua']];
            if ($request->has('team_members')) {
                foreach ($request->team_members as $memberId) {
                    // Hindari duplikasi jika ketua tidak sengaja terpilih lagi di anggota
                    if ($memberId != $teamLeadId) {
                        $teamData[$memberId] = ['role' => 'anggota'];
                    }
                }
            }
            $project->teamMembers()->sync($teamData);

            if ($request->has('tags')) {
                $project->tags()->sync($request->tags);
            }

            if ($request->hasFile('thumbnail')) {
                $project->addMediaFromRequest('thumbnail')
                    ->usingFileName($project->slug . '.' . $request->file('thumbnail')->getClientOriginalExtension())
                    ->toMediaCollection('thumbnail');
            }

            if ($request->hasFile('screenshots')) {
                foreach ($request->file('screenshots') as $index => $screenshot) {
                    $project->addMedia($screenshot)
                        ->usingFileName($project->slug . '-screenshot-' . $index . '.' . $screenshot->getClientOriginalExtension())
                        ->toMediaCollection('screenshots');
                }
            }

            if ($isAdmin) {
                return redirect()->route('admin.projects.index')
                                 ->with('success', 'Proyek baru berhasil ditambahkan langsung ke sistem publik.');
            }

            return redirect()->route('projects.index')
                             ->with('success', 'Proyek berhasil disubmit dan sedang menunggu verifikasi Dosen/Admin!');
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user instanceof User && $user->hasRole('mahasiswa') && $project->team_lead_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah proyek ini.');
        }

        return DB::transaction(function () use ($request, $project, $user) {
            $data = $request->validated();

            $isAdmin = $user->hasAnyRole(['admin', 'dosen']);

            // Jika admin, biarkan mengubah team_lead_id secara manual dari request
            if ($isAdmin && $request->filled('team_lead_id')) {
                $data['team_lead_id'] = $request->team_lead_id;
            }

            if ($user instanceof User && $user->hasRole('mahasiswa') && $project->status === 'published') {
                $data['status'] = 'pending';
                $data['submitted_at'] = now();
            }

            $project->update($data);

            if ($request->has('tags')) {
                $project->tags()->sync($request->tags);
            }

            // Sync ulang anggota tim dengan memperhitungkan ketua baru (jika diubah admin)
            $finalTeamLeadId = $project->team_lead_id;
            $teamData = [$finalTeamLeadId => ['role' => 'ketua']];

            if ($request->has('team_members')) {
                foreach ($request->team_members as $memberId) {
                    if ($memberId != $finalTeamLeadId) {
                        $teamData[$memberId] = ['role' => 'anggota'];
                    }
                }
            }
            $project->teamMembers()->sync($teamData);

            if ($request->hasFile('thumbnail')) {
                $project->clearMediaCollection('thumbnail');
                $project->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
            }

            if ($request->hasFile('screenshots')) {
                $project->clearMediaCollection('screenshots');
                foreach ($request->file('screenshots') as $screenshot) {
                    $project->addMedia($screenshot)->toMediaCollection('screenshots');
                }
            }

            if ($isAdmin) {
                return redirect()->route('admin.projects.index')
                                 ->with('success', 'Proyek mahasiswa berhasil diperbarui oleh manajemen.');
            }

            return redirect()->route('projects.show', $project)
                             ->with('success', 'Proyek berhasil diperbarui.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user instanceof User && $user->hasRole('mahasiswa') && $project->team_lead_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah proyek ini.');
        }

        $project->delete();

        // DIBEDAKAN BERDASARKAN ROLE
        if ($user->hasAnyRole(['admin', 'dosen'])) {
            return redirect()->route('admin.projects.index')
                             ->with('success', 'Berkas proyek berhasil dihapus permanen dari sistem.');
        }

        return redirect()->route('projects.index')
                         ->with('success', 'Proyek berhasil dihapus.');
    }

    /**
     * Display the specified resource.
     */

    public function show(Project $project, ProjectViewTracker $tracker, Request $request)
    {
        $project->load([
            'program', 'category', 'courseClass.course', 'courseClass.lecturers',
            'teamMembers', 'tags', 'media'
        ]);

        // Track Analytics
        $tracker->track($project, $request);

        return view('admin.projects.detail', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        $programs = Program::all();
        $categories = Category::all();
        $courseClasses = CourseClass::with(['course', 'semester'])->get();
        $tags = Tag::all();

        // Alihkan template form berdasarkan role pengguna yang sedang login
        if ($user->hasAnyRole(['admin', 'dosen'])) {
            return view('admin.projects.create', compact('programs', 'categories', 'courseClasses', 'tags'));
        }

        return view('users.project.create', compact('programs', 'categories', 'courseClasses', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        /** @var User $user */
        $user = Auth::user();

        // Proteksi barikade: Mahasiswa tidak boleh mengedit proyek kelompok lain
        if ($user->hasRole('mahasiswa') && $project->team_lead_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah proyek ini.');
        }

        $programs = Program::all();
        $categories = Category::all();
        $courseClasses = CourseClass::with(['course', 'semester'])->get();
        $tags = Tag::all();

        // Alihkan template form berdasarkan role pengguna yang sedang login
        if ($user->hasAnyRole(['admin', 'dosen'])) {
            return view('admin.projects.edit', compact('project', 'programs', 'categories', 'courseClasses', 'tags'));
        }

        return view('users.project.edit', compact('project', 'programs', 'categories', 'courseClasses', 'tags'));
    }
    /*
    |--------------------------------------------------------------------------
    | CUSTOM METHODS UNTUK WORKFLOW APPROVAL (ADMIN/DOSEN)
    |--------------------------------------------------------------------------
    */

    public function approve(Project $project)
    {
        $user = Auth::user();

        if (!($user instanceof User) || !$user->hasAnyRole(['admin', 'dosen'])) {
            abort(403, 'Anda tidak memiliki izin untuk menyetujui proyek ini.');
        }

        $project->update([
            'status'         => 'published',
            'published_at'   => now(),
            'reviewer_id'    => $user->id,
            'rejected_reason'=> null,
        ]);

        // KIRIM NOTIFIKASI KE SEMUA ANGGOTA TIM
        $teamMembers = $project->teamMembers; // Eager load semua anggota

        foreach ($teamMembers as $member) {
            $member->notify(new ProjectApprovedNotification($project, $user->name));
        }

        // Juga notif ke team lead (jika tidak ikut sebagai member)
        if ($project->teamLead && !$teamMembers->contains('id', $project->teamLead->id)) {
            $project->teamLead->notify(new ProjectApprovedNotification($project, $user->name));
        }

        return back()->with('success', 'Proyek berhasil disetujui dan tim telah dinotifikasi.');
    }

    public function reject(Request $request, Project $project)
    {
        $user = Auth::user();

        if (!($user instanceof User) || !$user->hasAnyRole(['admin', 'dosen'])) {
            abort(403, 'Anda tidak memiliki izin untuk menolak proyek ini.');
        }

        $request->validate([
            'rejected_reason' => 'required|string|max:1000'
        ]);

        $project->update([
            'status'          => 'rejected',
            'reviewer_id'     => $user->id,
            'rejected_reason' => $request->rejected_reason,
        ]);

        // KIRIM NOTIFIKASI REJECTION KE SEMUA ANGGOTA TIM
        $teamMembers = $project->teamMembers;

        foreach ($teamMembers as $member) {
            $member->notify(new ProjectRejectedNotification(
                $project,
                $request->rejected_reason,
                $user->name
            ));
        }

        if ($project->teamLead && !$teamMembers->contains('id', $project->teamLead->id)) {
            $project->teamLead->notify(new ProjectRejectedNotification(
                $project,
                $request->rejected_reason,
                $user->name
            ));
        }

        return back()->with('success', 'Proyek telah ditolak dan tim telah dinotifikasi.');
    }
}
