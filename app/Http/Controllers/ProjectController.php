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
        $query = Project::with(['program', 'category' => function ($q) {
                $q->where('is_active', true);
            },
        'courseClass.course', 'teamMembers']);

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
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('team_name', 'like', '%' . $request->search . '%');
            });
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
                'team_lead_id' => $teamLeadId,
                'team_name' => $request->team_name,
            ]);

            // --- LOGIKA TEAM MEMBERS (ROBUST) ---
            // Ambil kontribusi khusus ketua jika yang login adalah mahasiswa
            $leaderContribution = $isAdmin ? 'ketua' : $request->input('leader_contribution', 'Project Manager');

            $teamData = [
                $teamLeadId => [
                    'role' => 'ketua',
                    'contribution' => $leaderContribution,
                    'joined_at' => now(),
                ]
            ];

            // Ambil array multidimensi dari request
            $teamMembersInput = $request->input('team_members', []);

            foreach ($teamMembersInput as $member) {
                // Ekstrak ID dan Kontribusi dari sub-array
                $memberId = $member['user_id'] ?? null;
                $contribution = $member['contribution'] ?? '';

                if ($memberId && $memberId != $teamLeadId) {
                    $teamData[$memberId] = [
                        'role' => 'anggota',
                        'contribution' => $contribution,
                        'joined_at' => now(),
                    ];
                }
            }
            $project->teamMembers()->sync($teamData);

            // --- LOGIKA FITUR PROJECT (ROBUST) ---
            $featuresInput = $request->input('features', []);
            foreach ($featuresInput as $index => $feature) {
                if (!empty($feature['name'])) {
                    $project->features()->create([
                        'name'  => $feature['name'],
                        'icon'  => $feature['icon'] ?? 'fa-solid fa-check',
                        'order' => $index,
                    ]);
                }
            }

            // --- LOGIKA TAGS ---
            $project->tags()->sync($request->input('tags', []));

            // --- MEDIA UPLOAD ---
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

        return DB::transaction(function () use ($request, $project, $user) {
            $data = $request->validated();
            $isAdmin = $user->hasAnyRole(['admin', 'dosen']);

            // Jika admin mengubah ketua tim secara manual
            if ($isAdmin && $request->filled('team_lead_id')) {
                $data['team_lead_id'] = $request->team_lead_id;
            }

            $project->update($data);

            // --- UPDATE TAGS ---
            $project->tags()->sync($request->input('tags', []));


            // 1. Hapus semua fitur lama dari database
            $project->features()->delete();

            // --- UPDATE FITUR PROJECT (DELETE & RE-CREATE) ---
            $featuresInput = $request->input('features', []);
            // 2. Buat ulang berdasarkan input form terbaru
            foreach ($featuresInput as $index => $feature) {
                if (!empty($feature['name'])) {
                    $project->features()->create([
                        'name'  => $feature['name'],
                        'icon'  => $feature['icon'] ?? 'fa-solid fa-check',
                        'order' => $index,
                    ]);
                }
            }

           // --- UPDATE ANGGOTA TIM ---
            $finalTeamLeadId = $project->team_lead_id;

            // Ambil kontribusi ketua saat update
            $leaderContribution = $request->input('leader_contribution', 'Project Manager');

            // 1. Pastikan Ketua Tim selalu ada di array sync dengan role 'ketua'
            $teamData = [
                $finalTeamLeadId => [
                    'role' => 'ketua',
                    'contribution' => $leaderContribution,
                    'joined_at' => now(),
                ]
            ];

            // 2. Proses anggota tim lainnya
            $teamMembersInput = $request->input('team_members', []);
            foreach ($teamMembersInput as $member) {
                $memberId = $member['user_id'] ?? null;
                $contribution = $member['contribution'] ?? '';

                if ($memberId && $memberId != $finalTeamLeadId) {
                    $teamData[$memberId] = [
                        'role' => 'anggota',
                        'contribution' => $contribution,
                        'joined_at' => now(),
                    ];
                }
            }

            // 3. Sync otomatis menghapus anggota yang tidak ada di $teamData
            $project->teamMembers()->sync($teamData);

            // --- MEDIA UPDATE ---
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

            return redirect()->route('projects.index', $project)
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
            'program','category' => function ($q) {
                $q->where('is_active', true);
            }, 'courseClass.course', 'courseClass.lecturers',
            'teamMembers', 'tags', 'media', 'features'
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

        $fontAwesomeIcons = [
            // 1. Core Development & Programming
            'fa-solid fa-code', 'fa-solid fa-laptop-code', 'fa-solid fa-terminal', 'fa-solid fa-bug',
            'fa-solid fa-bug-slash', 'fa-solid fa-file-code', 'fa-solid fa-cubes', 'fa-solid fa-cube',
            'fa-solid fa-layer-group', 'fa-solid fa-diagram-project', 'fa-solid fa-gears', 'fa-solid fa-gear',
            'fa-solid fa-wrench', 'fa-solid fa-screwdriver-wrench', 'fa-solid fa-hammer', 'fa-solid fa-compass-drafting',

            // 2. Data, Database & AI/Machine Learning
            'fa-solid fa-database', 'fa-solid fa-server', 'fa-solid fa-table', 'fa-solid fa-chart-line',
            'fa-solid fa-chart-pie', 'fa-solid fa-chart-bar', 'fa-solid fa-chart-column', 'fa-solid fa-brain',
            'fa-solid fa-robot', 'fa-solid fa-eye', 'fa-solid fa-magnifying-glass-chart', 'fa-solid fa-filter',
            'fa-solid fa-calculator', 'fa-solid fa-infinity', 'fa-solid fa-dna',

            // 3. Hardware, IoT, Electronics & Networks
            'fa-solid fa-wifi', 'fa-solid fa-signal', 'fa-solid fa-plug', 'fa-solid fa-bolt',
            'fa-solid fa-tower-cell', 'fa-solid fa-satellite-dish', 'fa-solid fa-display', 'fa-solid fa-mobile-screen-button',
            'fa-solid fa-sim-card', 'fa-solid fa-gamepad', 'fa-solid fa-print', 'fa-solid fa-hard-drive',
            'fa-solid fa-sd-card', 'fa-solid fa-ethernet', 'fa-solid fa-microchip', 'fa-solid fa-battery-full',

            // 4. Cyber Security, Infrastructure & Authentication
            'fa-solid fa-shield-halved', 'fa-solid fa-lock', 'fa-solid fa-lock-open', 'fa-solid fa-key',
            'fa-solid fa-user-shield', 'fa-solid fa-user-lock', 'fa-solid fa-user-check', 'fa-solid fa-fingerprint',
            'fa-solid fa-eye-slash', 'fa-solid fa-ban', 'fa-solid fa-triangle-exclamation', 'fa-solid fa-id-card',
            'fa-solid fa-vault', 'fa-solid fa-circle-check', 'fa-solid fa-clock-history', 'fa-solid fa-key-skeleton',

            // 5. Cloud, Communication, Systems & Storage
            'fa-solid fa-cloud', 'fa-solid fa-cloud-arrow-up', 'fa-solid fa-cloud-arrow-down', 'fa-solid fa-folder',
            'fa-solid fa-folder-open', 'fa-solid fa-file-lines', 'fa-solid fa-file-pdf', 'fa-solid fa-file-excel',
            'fa-solid fa-envelope', 'fa-solid fa-envelope-open', 'fa-solid fa-comment', 'fa-solid fa-comments',
            'fa-solid fa-bell', 'fa-solid fa-bell-slash', 'fa-solid fa-bullhorn', 'fa-solid fa-share-nodes',

            // 6. E-Commerce, Logistics, Business & Finance
            'fa-solid fa-cart-shopping', 'fa-solid fa-bag-shopping', 'fa-solid fa-credit-card', 'fa-solid fa-wallet',
            'fa-solid fa-money-bill-wave', 'fa-solid fa-money-check-dollar', 'fa-solid fa-store', 'fa-solid fa-shop',
            'fa-solid fa-tags', 'fa-solid fa-ticket', 'fa-solid fa-qrcode', 'fa-solid fa-barcode',
            'fa-solid fa-truck', 'fa-solid fa-box', 'fa-solid fa-handshake', 'fa-solid fa-briefcase',

            // 7. Academic, Users, Gamification & Social
            'fa-solid fa-user', 'fa-solid fa-users', 'fa-solid fa-user-group', 'fa-solid fa-user-plus',
            'fa-solid fa-user-graduate', 'fa-solid fa-user-tie', 'fa-solid fa-address-book', 'fa-solid fa-book-open',
            'fa-solid fa-thumbs-up', 'fa-solid fa-star', 'fa-solid fa-heart', 'fa-solid fa-fire',
            'fa-solid fa-trophy', 'fa-solid fa-medal', 'fa-solid fa-crown', 'fa-solid fa-award',

            // 8. GIS, Location, Infrastructure & Public Services
            'fa-solid fa-house', 'fa-solid fa-building', 'fa-solid fa-hospital', 'fa-solid fa-school',
            'fa-solid fa-location-dot', 'fa-solid fa-map', 'fa-solid fa-compass', 'fa-solid fa-route',
            'fa-solid fa-car', 'fa-solid fa-plane', 'fa-solid fa-train', 'fa-solid fa-truck-medical',

            // 9. Agro-Informatics & Environment (Sistem Pertanian/Peternakan/Cuaca)
            'fa-solid fa-leaf', 'fa-solid fa-seedling', 'fa-solid fa-wheat', 'fa-solid fa-tree',
            'fa-solid fa-droplet', 'fa-solid fa-sun', 'fa-solid fa-temperature-half', 'fa-solid fa-wind',
            'fa-solid fa-cow', 'fa-solid fa-cloud-sun-rain', 'fa-solid fa-faucet-drip', 'fa-solid fa-bug-ant'
        ];

        $programs = Program::all();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $courseClasses = CourseClass::with(['course', 'semester'])->get();
        $tags = Tag::all();

        // Alihkan template form berdasarkan role pengguna yang sedang login
        if ($user->hasAnyRole(['admin', 'dosen'])) {
            return view('admin.projects.create', compact('programs', 'categories', 'courseClasses', 'tags', 'fontAwesomeIcons'));
        }

        return view('users.project.create', compact('programs', 'categories', 'courseClasses', 'tags', 'fontAwesomeIcons'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        /** @var User $user */
        $user = Auth::user();

        $fontAwesomeIcons = [
            // 1. Core Development & Programming
            'fa-solid fa-code', 'fa-solid fa-laptop-code', 'fa-solid fa-terminal', 'fa-solid fa-bug',
            'fa-solid fa-bug-slash', 'fa-solid fa-file-code', 'fa-solid fa-cubes', 'fa-solid fa-cube',
            'fa-solid fa-layer-group', 'fa-solid fa-diagram-project', 'fa-solid fa-gears', 'fa-solid fa-gear',
            'fa-solid fa-wrench', 'fa-solid fa-screwdriver-wrench', 'fa-solid fa-hammer', 'fa-solid fa-compass-drafting',

            // 2. Data, Database & AI/Machine Learning
            'fa-solid fa-database', 'fa-solid fa-server', 'fa-solid fa-table', 'fa-solid fa-chart-line',
            'fa-solid fa-chart-pie', 'fa-solid fa-chart-bar', 'fa-solid fa-chart-column', 'fa-solid fa-brain',
            'fa-solid fa-robot', 'fa-solid fa-eye', 'fa-solid fa-magnifying-glass-chart', 'fa-solid fa-filter',
            'fa-solid fa-calculator', 'fa-solid fa-infinity', 'fa-solid fa-dna',

            // 3. Hardware, IoT, Electronics & Networks
            'fa-solid fa-wifi', 'fa-solid fa-signal', 'fa-solid fa-plug', 'fa-solid fa-bolt',
            'fa-solid fa-tower-cell', 'fa-solid fa-satellite-dish', 'fa-solid fa-display', 'fa-solid fa-mobile-screen-button',
            'fa-solid fa-sim-card', 'fa-solid fa-gamepad', 'fa-solid fa-print', 'fa-solid fa-hard-drive',
            'fa-solid fa-sd-card', 'fa-solid fa-ethernet', 'fa-solid fa-microchip', 'fa-solid fa-battery-full',

            // 4. Cyber Security, Infrastructure & Authentication
            'fa-solid fa-shield-halved', 'fa-solid fa-lock', 'fa-solid fa-lock-open', 'fa-solid fa-key',
            'fa-solid fa-user-shield', 'fa-solid fa-user-lock', 'fa-solid fa-user-check', 'fa-solid fa-fingerprint',
            'fa-solid fa-eye-slash', 'fa-solid fa-ban', 'fa-solid fa-triangle-exclamation', 'fa-solid fa-id-card',
            'fa-solid fa-vault', 'fa-solid fa-circle-check', 'fa-solid fa-clock-history', 'fa-solid fa-key-skeleton',

            // 5. Cloud, Communication, Systems & Storage
            'fa-solid fa-cloud', 'fa-solid fa-cloud-arrow-up', 'fa-solid fa-cloud-arrow-down', 'fa-solid fa-folder',
            'fa-solid fa-folder-open', 'fa-solid fa-file-lines', 'fa-solid fa-file-pdf', 'fa-solid fa-file-excel',
            'fa-solid fa-envelope', 'fa-solid fa-envelope-open', 'fa-solid fa-comment', 'fa-solid fa-comments',
            'fa-solid fa-bell', 'fa-solid fa-bell-slash', 'fa-solid fa-bullhorn', 'fa-solid fa-share-nodes',

            // 6. E-Commerce, Logistics, Business & Finance
            'fa-solid fa-cart-shopping', 'fa-solid fa-bag-shopping', 'fa-solid fa-credit-card', 'fa-solid fa-wallet',
            'fa-solid fa-money-bill-wave', 'fa-solid fa-money-check-dollar', 'fa-solid fa-store', 'fa-solid fa-shop',
            'fa-solid fa-tags', 'fa-solid fa-ticket', 'fa-solid fa-qrcode', 'fa-solid fa-barcode',
            'fa-solid fa-truck', 'fa-solid fa-box', 'fa-solid fa-handshake', 'fa-solid fa-briefcase',

            // 7. Academic, Users, Gamification & Social
            'fa-solid fa-user', 'fa-solid fa-users', 'fa-solid fa-user-group', 'fa-solid fa-user-plus',
            'fa-solid fa-user-graduate', 'fa-solid fa-user-tie', 'fa-solid fa-address-book', 'fa-solid fa-book-open',
            'fa-solid fa-thumbs-up', 'fa-solid fa-star', 'fa-solid fa-heart', 'fa-solid fa-fire',
            'fa-solid fa-trophy', 'fa-solid fa-medal', 'fa-solid fa-crown', 'fa-solid fa-award',

            // 8. GIS, Location, Infrastructure & Public Services
            'fa-solid fa-house', 'fa-solid fa-building', 'fa-solid fa-hospital', 'fa-solid fa-school',
            'fa-solid fa-location-dot', 'fa-solid fa-map', 'fa-solid fa-compass', 'fa-solid fa-route',
            'fa-solid fa-car', 'fa-solid fa-plane', 'fa-solid fa-train', 'fa-solid fa-truck-medical',

            // 9. Agro-Informatics & Environment (Sistem Pertanian/Peternakan/Cuaca)
            'fa-solid fa-leaf', 'fa-solid fa-seedling', 'fa-solid fa-wheat', 'fa-solid fa-tree',
            'fa-solid fa-droplet', 'fa-solid fa-sun', 'fa-solid fa-temperature-half', 'fa-solid fa-wind',
            'fa-solid fa-cow', 'fa-solid fa-cloud-sun-rain', 'fa-solid fa-faucet-drip', 'fa-solid fa-bug-ant'
        ];


        $programs = Program::all();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $courseClasses = CourseClass::with(['course', 'semester'])->get();
        $tags = Tag::all();

        // Alihkan template form berdasarkan role pengguna yang sedang login
        if ($user->hasAnyRole(['admin', 'dosen'])) {
            return view('admin.projects.edit', compact('project', 'programs', 'categories', 'courseClasses', 'tags', 'fontAwesomeIcons'));
        }

        return view('users.project.edit', compact('project', 'programs', 'categories', 'courseClasses', 'tags', 'fontAwesomeIcons'));
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
