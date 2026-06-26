<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProjectControllerr;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

Route::prefix('project')->name('project.')->group(function () {
    Route::get('/', [ProjectControllerr::class, 'index'])->name('index');
    Route::get('/{slug}', [ProjectControllerr::class, 'show'])->name('show');
});

Route::get('/about', function () {
    return view('about');
})->name('about');


/*
|--------------------------------------------------------------------------
| PROFILE ROUTES (Breeze Standard - Accessible by Admin, Dosen, Mahasiswa)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| WORKSPACE MAHASISWA (CRUD Project Milik Sendiri)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa', 'verified'])->group(function () {
    Route::resource('submit-project', ProjectController::class)->names([
        'index'   => 'projects.index',
        'create'  => 'projects.create',
        'store'   => 'projects.store',
        'show'    => 'projects.show',
        'edit'    => 'projects.edit',
        'update'  => 'projects.update',
    ])->parameters([
        'submit-project' => 'project'
    ]);
});

/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATED ROUTES (Mahasiswa, Dosen, Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllRead');
        Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('clearAll');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::get('/api/unread-count', [NotificationController::class, 'unreadCount'])->name('unreadCount');
    });

    // Akademik (Read-Only untuk Umum/Siswa/Dosen)
    Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');
    Route::get('/semesters/{semester}', [SemesterController::class, 'show'])->name('semesters.show');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/course-classes/{course_class}', [CourseClassController::class, 'show'])->name('course-classes.show');

});


/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES (Khusus Role: Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|dosen'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Approval Workflow (Bisa diakses Dosen/Admin tergantung kebijakan permission nanti)
        Route::patch('/projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
        Route::patch('/projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');

        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Project Management (User Workspace)
        Route::resource('projects', ProjectController::class);




        // 1. Rute Indeks Tunggal untuk Halaman Master Akademik Terpadu (Menyatukan 3 Modul)
        Route::get('/academic', [CourseController::class, 'academicIndex'])->name('academic.index');

        // 2. Rute Pemrosesan CRUD (Gunakan 'except' agar rute 'index' bawaannya tidak bentrok)
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        Route::resource('semesters', SemesterController::class)->except(['index', 'show']);
        Route::resource('course-classes', CourseClassController::class)->except(['index', 'show']);

        // Rute Lainnya Tetap Sama
        Route::resource('programs', ProgramController::class)->except(['show']);
        Route::resource('tags', TagController::class)->except(['show']);
        Route::resource('category', CategoryController::class)->except(['show']);


        // User Management, Approval & CRUD
        Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
        Route::patch('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
        Route::resource('users', UserController::class)->except(['show']);
});

require __DIR__.'/auth.php';
