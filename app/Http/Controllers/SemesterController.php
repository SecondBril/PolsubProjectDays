<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Http\Requests\SemesterRequest;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::orderBy('year', 'desc')->orderBy('term', 'desc')->get();
        return view('admin.semesters.index', compact('semesters'));
    }

    public function create() { return view('admin.semesters.create'); }

    public function store(SemesterRequest $request)
    {
        Semester::create($request->validated());
        return redirect()->route('admin.academic.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    public function show(Semester $semester)
    {
        // Menampilkan semua kelas dan proyek yang ada di semester ini
        $semester->load(['courseClasses' => function($q) {
            $q->with(['course', 'lecturer', 'projects' => fn($q) => $q->published()]);
        }]);
        return view('admin.semesters.show', compact('semester'));
    }

    public function edit(Semester $semester) { return view('admin.semesters.edit', compact('semester')); }

    public function update(SemesterRequest $request, Semester $semester)
    {
        $semester->update($request->validated());
        return redirect()->route('admin.academic.index')->with('success', 'Semester diperbarui.');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('admin.academic.index')->with('success', 'Semester dihapus.');
    }
}
