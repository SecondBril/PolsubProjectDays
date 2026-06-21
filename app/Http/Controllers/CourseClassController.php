<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use App\Models\Course;
use App\Models\Semester;
use App\Models\User;
use App\Http\Requests\CourseClassRequest;
use Illuminate\Support\Facades\DB;

class CourseClassController extends Controller
{
    public function index()
    {
        $classes = CourseClass::with(['course.program', 'semester', 'lecturer'])->latest()->paginate(15);
        return view('course-classes.index', compact('classes'));
    }

    public function create()
    {
        $courses = Course::with('program')->get();
        $semesters = Semester::active()->get(); // Hanya semester aktif
        $lecturers = User::role('dosen')->get(); // Filter hanya dosen
        return view('course-classes.create', compact('courses', 'semesters', 'lecturers'));
    }

    public function show(CourseClass $course_class)
    {
        // Ini adalah halaman "Showcase Kelas". Menampilkan semua proyek PBL dari kelas ini!
        $course_class->load([
            'course.program',
            'semester',
            'lecturer',
            'projects' => function($q) {
                $q->published()->with(['teamLead', 'tags', 'media'])->latest();
            }
        ]);
        return view('course-classes.show', compact('course_class'));
    }

    public function store(CourseClassRequest $request)
    {
        return DB::transaction(function () use ($request) {

            // Buat record kelas tanpa mengunci satu kolom lecturer_id tunggal
            $courseClass = CourseClass::create([
                'course_id' => $request->course_id,
                'semester_id' => $request->semester_id,
                'class_code' => $request->class_code,
            ]);

            // Hubungkan array ID dosen pengampu (lecturer_ids) ke tabel pivot
            if ($request->has('lecturer_ids')) {
                $courseClass->lecturers()->sync($request->lecturer_ids);
            }

            return redirect()->route('admin.course-classes.index')->with('success', 'Kelas dan tim dosen pengampu pengampu berhasil dibuat.');
        });
    }

    public function update(CourseClassRequest $request, CourseClass $courseClass)
    {
        return DB::transaction(function () use ($request, $courseClass) {
            $courseClass->update([
                'course_id' => $request->course_id,
                'semester_id' => $request->semester_id,
                'class_code' => $request->class_code,
            ]);

            if ($request->has('lecturer_ids')) {
                $courseClass->lecturers()->sync($request->lecturer_ids);
            }

            return redirect()->route('admin.course-classes.index')->with('success', 'Data kelas dan tim dosen berhasil diperbarui.');
        });
    }

    public function edit(CourseClass $course_class)
    {
        $courses = Course::with('program')->get();
        $semesters = Semester::all();
        $lecturers = User::role('dosen')->get();
        return view('course-classes.edit', compact('course_class', 'courses', 'semesters', 'lecturers'));
    }

    public function destroy(CourseClass $course_class)
    {
        $course_class->delete();
        return redirect()->route('course-classes.index')->with('success', 'Kelas dihapus.');
    }
}
