<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\EditProfile\EditController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\CourseCategory\CourseCategoryController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\Creator\CreatorController;
use App\Http\Controllers\AgoraIntegrations\InstructorSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Student\CoursesCatalogController;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group(['middleware' => 'prevent-back-history'],function() {
    Route::get('/signup', [AuthController::class, 'signUp'])->name('signup');
    Route::post('/create-user', [AuthController::class, 'signupProcess'])->name('user.create');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/user-login', [AuthController::class, 'loginProcess'])->name('user.loginin');
    Route::get('/dashboard', [AuthController::class, 'dashboardView'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/edit', [EditController::class, 'edituser'])->name('edituser');
    Route::post('/update',[EditController::class, 'profileUpdate'])->name('profileUpdate');

    Route::get('/manage-courses', [CourseController::class, 'index'])->name('manage-courses');
    Route::post('/add-course', [CourseController::class, 'saveCourse'])->name('add-course');
    Route::post('/view-course', [CourseController::class, 'viewCourse'])->name('view-course');
    Route::post('/edit-course', [CourseController::class, 'editCourse'])->name('edit-course');
    Route::post('/update-course', [CourseController::class, 'updateCourse'])->name('update-course');
    Route::post('/delete-course', [CourseController::class, 'deleteCourse'])->name('delete-course');
    Route::post('/load-courses', [CourseController::class, 'loadCourse'])->name('load-courses');

    Route::get('/manage-course-categories', [CourseCategoryController::class, 'index'])->name('manage-course-categories');
    Route::post('/add-course-category', [CourseCategoryController::class, 'saveCourseCategory'])->name('add-course-category');
    Route::post('/view-course-category', [CourseCategoryController::class, 'viewCourseCategory'])->name('view-course-category');
    Route::post('/edit-course-category', [CourseCategoryController::class, 'editCourseCategory'])->name('edit-course-category');
    Route::post('/update-course-category', [CourseCategoryController::class, 'updateCourseCategory'])->name('update-course-category');
    Route::post('/delete-course-category', [CourseCategoryController::class, 'deleteCourseCategory'])->name('delete-course-category');

    Route::get('/manage-instructors', [InstructorController::class, 'index'])->name('manage-instructors');
    Route::post('/add-instructor', [InstructorController::class, 'saveInstructor'])->name('add-instructor');
    Route::post('/view-instructor', [InstructorController::class, 'viewInstructor'])->name('view-instructor');
    Route::post('/edit-instructor', [InstructorController::class, 'editInstructor'])->name('edit-instructor');
    Route::post('/update-instructor', [InstructorController::class, 'updateInstructor'])->name('update-instructor');
    Route::post('/delete-instructor', [InstructorController::class, 'deleteInstructor'])->name('delete-instructor');

    Route::get('/manage-creators', [CreatorController::class, 'index'])->name('manage-creators');
    Route::post('/add-creator', [CreatorController::class, 'saveCreator'])->name('add-creator');
    Route::post('/view-creator', [CreatorController::class, 'viewCreator'])->name('view-creator');
    Route::post('/edit-creator', [CreatorController::class, 'editCreator'])->name('edit-creator');
    Route::post('/update-creator', [CreatorController::class, 'updateCreator'])->name('update-creator');
    Route::post('/delete-creator', [CreatorController::class, 'deleteCreator'])->name('delete-creator');
    Route::put('/update',[EditController::class, 'profileUpdate'])->name('profileUpdate');


    Route::get('/students', [AdminController::class, 'viewAllStudents'])->name('admin.viewall');
    Route::get('/students/{student}', [AdminController::class, 'showStudent'])->name('admin.showstudent');
    Route::get('/students/edit/{student}', [AdminController::class, 'editStudent'])->name('admin.editstudent');
    Route::put('/students/update/{students}', [AdminController::class, 'updateStudent'])->name('admin.updatestudent');
    Route::post('/students/delete', [AdminController::class, 'destroyStudent'])->name('admin.deletestudent');
    
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::get('change-password', [EditController::class, 'showChangePasswordForm'])->name('change.password.get');
    Route::put('change-password', [EditController::class, 'submitChangePasswordForm'])->name('change.password.post');

    Route::post('profile-upload', [EditController::class, 'uploadImage'])->name('change.avatar.post');
    Route::post('add-sub-topic', [CourseController::class, 'saveSubTopic'])->name('add-sub-topic');


    Route::get('instructor-session-view', [InstructorSessionController::class, 'index'])->name('instructor-session-view');
    Route::get('host-session', [InstructorSessionController::class, 'hostSession'])->name('host-session');
    
    Route::get('student-courses', [CoursesCatalogController::class, 'viewAllCourses'])->name('student.courses.get');
    // Route::get('show-course', function () {
    //     return view('Student.showCourse');
    // });
    Route::get('show-course', [CoursesCatalogController::class, 'showCourse'])->name('student.course.show');
    
});

