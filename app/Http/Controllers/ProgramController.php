<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Http\Requests\ProgramRequest;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('name')->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create() { return view('programs.create'); }


    public function show(Program $program)
    {
        // Memuat relasi Courses dan 10 Project terbaru yang sudah published
        $program->load(['courses', 'projects' => function($q) {
            $q->published()->with('teamLead')->latest()->take(10);
        }]);
        return view('programs.show', compact('program'));
    }
    public function edit(Program $program) { return view('programs.edit', compact('program')); }
    public function store(ProgramRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        Program::create($data);
        return redirect()->route('admin.programs.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function update(ProgramRequest $request, Program $program)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        $program->update($data);
        return redirect()->route('admin.programs.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program Studi dihapus.');
    }
}
