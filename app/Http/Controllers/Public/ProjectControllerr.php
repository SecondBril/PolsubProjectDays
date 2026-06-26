<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Program;
use App\Models\Category;
use App\Models\Semester;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectControllerr extends Controller
{
    public function index(Request $request)
    {
        // REVISI: Tambahkan eager loading 'features' pada query index halaman publik
        $query = Project::published()
            ->with(['program', 'category', 'courseClass.semester', 'teamMembers', 'features']);

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->input('program_id'));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('semester_id')) {
            $query->whereHas('courseClass', fn($q) => $q->where('semester_id', $request->input('semester_id')));
        }
        if ($request->filled('tag_id')) {
            $query->whereHas('tags', fn($q) => $q->where('tags.id', $request->input('tag_id')));
        }
        if ($request->filled('cohort')) {
            $query->where('cohort', $request->input('cohort'));
        }
        if ($request->filled('demo_status')) {
            $query->where('demo_status', $request->input('demo_status'));
        }

        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'oldest'     => $query->oldest('published_at'),
            'popular'    => $query->orderByDesc('views_count'),
            'title_asc'  => $query->orderBy('title', 'asc'),
            'title_desc' => $query->orderBy('title', 'desc'),
            default      => $query->latest('published_at'),
        };

        $projects = $query->paginate(15)->withQueryString();

        $filterOptions = [
            'programs'   => Program::where('is_active', true)->orderBy('name')->get(),
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'semesters'  => Semester::orderByDesc('year')->orderByDesc('term')->get(),
            'tags'       => Tag::has('projects')->orderBy('name')->get(),
        ];

        return view('project', array_merge(
            ['projects' => $projects],
            $filterOptions
        ));
    }

    /**
     * DETAIL PROJECT (PUBLIC)
     */
    public function show(string $slug)
    {
        $project = Project::published()
            ->where('slug', $slug)
            ->with([
                'program',
                'category',
                'courseClass.semester',
                'courseClass.course',
                'courseClass.lecturers',
                'tags',
                'teamMembers.program',
                'features'
            ])
            ->firstOrFail();

        // Analytics Tracker: Cegah spam refresh
        $viewKey = 'project_view_' . $project->id . '_' . request()->ip();
        if (!Cache::has($viewKey)) {
            $project->increment('views_count');
            Cache::put($viewKey, true, 3600); // 1 jam
        }

        $screenshots = $project->getMedia('screenshots');
        $thumbnail = $project->getFirstMedia('thumbnail');

        return view('project-detail', compact('project', 'screenshots', 'thumbnail'));
    }
}
