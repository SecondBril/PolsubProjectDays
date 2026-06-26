<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Program;
use App\Http\Requests\CourseRequest;
use App\Models\Semester;
use App\Models\CourseClass;
use App\Models\User;


class CourseController extends Controller
{

    public function academicIndex()
    {
        $courses = Course::with('program')->latest()->get();
        $semesters = Semester::orderBy('year', 'desc')->orderBy('term', 'desc')->get();
        $classes = CourseClass::with(['course.program', 'semester', 'lecturers'])->latest()->get();
        $programs = Program::where('is_active', true)->get();

        // AMBIL DATA DOSEN DARI DATABASE BREEZE/SPATIE
        $lecturers = User::role('dosen')->orderBy('name')->get();

        // WAJIB SERTAKAN 'lecturers' DI DALAM COMPACT
        return view('admin.academic.index', compact('courses', 'semesters', 'classes', 'programs', 'lecturers'));
    }

    public function index()
    {
        $courses = Course::with('program')->latest()->paginate(15);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $programs = Program::where('is_active', true)->get();
        return view('courses.create', compact('programs'));
    }

    public function store(CourseRequest $request)
    {
        Course::create($request->validated());
        return redirect()->route('admin.academic.index')->with('success', 'Mata Kuliah ditambahkan.');
    }

    public function show(Course $course)
    {
        // Menampilkan riwayat kelas mata kuliah ini dari semester ke semester
        $course->load(['program', 'classes' => function($q) {
            $q->with(['semester', 'lecturer', 'projects' => fn($q) => $q->published()])
              ->orderBy('year', 'desc'); // Asumsi ada relasi year atau diurutkan via semester
        }]);
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $programs = Program::where('is_active', true)->get();
        return view('courses.edit', compact('course', 'programs'));
    }

    public function update(CourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        return redirect()->route('admin.academic.index')->with('success', 'Mata Kuliah diperbarui.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Mata Kuliah dihapus.');
    }
}
