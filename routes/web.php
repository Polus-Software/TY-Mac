<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\EditProfile\EditController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\CourseCategory\CourseCategoryController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\Creator\CreatorController;
use App\Http\Controllers\AgoraIntegrations\RtmTokenGeneratorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Student\CoursesCatalogController;
use App\Http\Controllers\Student\MyCoursesController;
use App\Http\Controllers\Student\EnrolledCourseController;
use App\Http\Controllers\Instructor\AssignedCoursesController;
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
    return view('homepage');
});
Route::get('/403', function () {
    return view('Errors.accessDenied');
});

Route::group(['middleware' => 'prevent-back-history'],function() {
    Route::get('/signup', [AuthController::class, 'signUp'])->name('signup');
    Route::post('/create-user', [AuthController::class, 'signupProcess'])->name('user.create');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/user-login', [AuthController::class, 'loginProcess'])->name('user.login');
    Route::get('/dashboard', [AuthController::class, 'dashboardView'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/edit', [EditController::class, 'edituser'])->name('edituser');
    Route::post('/update',[EditController::class, 'profileUpdate'])->name('profileUpdate');

    Route::get('/manage-courses', [CourseController::class, 'index'])->name('manage-courses');
    Route::post('/save-course', [CourseController::class, 'saveCourse'])->name('save-course');
    Route::get('/add-course', [CourseController::class, 'addCourse'])->name('add-course');
    Route::get('/create-subtopic', [CourseController::class, 'createSubtopic'])->name('create-subtopic');
    Route::get('/create-assignment', [CourseController::class, 'createAssignment'])->name('create-assignment');
    Route::get('/view-assignment', [CourseController::class, 'viewAssignment'])->name('view-assignment');
    Route::get('/edit-assignment', [CourseController::class, 'editAssignment'])->name('edit-assignment');
    Route::get('/delete-assignment', [CourseController::class, 'deleteAssignment'])->name('delete-assignment');
    Route::get('/create-cohortbatch', [CourseController::class, 'createCohortBatch'])->name('create-cohortbatch');
    Route::post('/save-cohortbatch', [CourseController::class, 'saveCohortBatch'])->name('save-cohortbatch');
    Route::get('/view-cohort', [CourseController::class, 'viewCohort'])->name('view-cohort');
    Route::get('/view-course', [CourseController::class, 'viewCourse'])->name('view-course');
    Route::get('/edit-course', [CourseController::class, 'editCourse'])->name('edit-course');

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
    Route::get('/add-instructor', [InstructorController::class, 'addInstructor'])->name('add-instructor');
    Route::get('/view-instructor', [InstructorController::class, 'viewInstructor'])->name('view-instructor');
    Route::get('/edit-instructor', [InstructorController::class, 'editInstructor'])->name('edit-instructor');
    Route::post('/update-instructor', [InstructorController::class, 'updateInstructor'])->name('update-instructor');
    Route::post('/delete-instructor', [InstructorController::class, 'deleteInstructor'])->name('delete-instructor');
    Route::post('/save-instructor', [InstructorController::class, 'saveInstructor'])->name('save-instructor');

    Route::get('/manage-creators', [CreatorController::class, 'index'])->name('manage-creators');
    Route::get('/add-creator', [CreatorController::class, 'addInstructor'])->name('add-creator');
    Route::post('/save-creator', [CreatorController::class, 'saveCreator'])->name('save-creator');
    Route::get('/view-creator', [CreatorController::class, 'viewCreator'])->name('view-creator');
    Route::get('/edit-creator', [CreatorController::class, 'editCreator'])->name('edit-creator');
    Route::post('/update-creator', [CreatorController::class, 'updateCreator'])->name('update-creator');
    Route::post('/delete-creator', [CreatorController::class, 'deleteCreator'])->name('delete-creator');
    Route::put('/update',[EditController::class, 'profileUpdate'])->name('profileUpdate');


    Route::get('/students', [AdminController::class, 'viewAllStudents'])->name('admin.viewall');
    Route::get('/students/{student}', [AdminController::class, 'showStudent'])->name('admin.showstudent');
    Route::get('/students/edit/{student}', [AdminController::class, 'editStudent'])->name('admin.editstudent');
    Route::put('/students/update/{students}', [AdminController::class, 'updateStudent'])->name('admin.updatestudent');
    Route::post('/students/delete', [AdminController::class, 'destroyStudent'])->name('admin.deletestudent');
    Route::get('/admin-settings', [AdminController::class, 'adminSettings'])->name('admin-settings');
    Route::post('/change-filter-status', [AdminController::class, 'changeFilterStatus'])->name('change-filter-status');
    Route::get('/view-student', [AdminController::class, 'viewStudent'])->name('view-student');
    Route::get('/edit-student', [AdminController::class, 'editStudent'])->name('edit-student');
    Route::post('/update-student', [AdminController::class, 'updateStudent'])->name('update-student');
    

    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::get('change-password', [EditController::class, 'showChangePasswordForm'])->name('change.password.get');
    Route::put('change-password', [EditController::class, 'submitChangePasswordForm'])->name('change.password.post');

    Route::post('profile-upload', [EditController::class, 'uploadImage'])->name('change.avatar.post');
    Route::post('add-sub-topic', [CourseController::class, 'saveSubTopic'])->name('add-sub-topic');
    Route::post('save-batch', [CourseController::class, 'saveBatch'])->name('save-batch');

    Route::get('view-subtopics', [CourseController::class, 'viewSubTopics'])->name('view-subtopics');
    Route::get('view_cohortbatches', [CourseController::class, 'viewCohortbatches'])->name('view_cohortbatches');
    Route::post('add-assignment', [CourseController::class, 'addAssignment'])->name('add-assignment');

    Route::get('view-sub-topic/{topic}', [CourseController::class, 'viewSubTopic'])->name('view-sub-topic');
   // Route::post('add-assignment', [CourseController::class, 'addAssignment'])->name('add-assignment');

    Route::post('save-assignment', [CourseController::class, 'saveAssignment'])->name('save-assignment');

    Route::get('generate-token', [RtmTokenGeneratorController::class, 'buildToken'])->name('generate-token');
    Route::get('generate-token-student', [RtmTokenGeneratorController::class, 'buildTokenStudent'])->name('generate-token-student');
    Route::get('session-view', [RtmTokenGeneratorController::class, 'index'])->name('session-view');
    Route::get('schedule-session', [RtmTokenGeneratorController::class, 'scheduleSession'])->name('schedule-session');
    Route::post('get-course-attributes', [RtmTokenGeneratorController::class, 'showCourseAttributes'])->name('get-course-attributes');
    Route::post('save-session-details', [RtmTokenGeneratorController::class, 'saveSessionDetails'])->name('save-session-details');
    
    Route::get('/student-courses', [CoursesCatalogController::class, 'viewAllCourses'])->name('student.courses.get');
   
    Route::get('/show-course/{course}', [CoursesCatalogController::class, 'showCourse'])->name('student.course.show');
    Route::get('/enroll-course', [CoursesCatalogController::class, 'enrollCourse'])->name('student.course.enroll');
    Route::get('/register-course', [CoursesCatalogController::class, 'registerCourse'])->name('student.course.register');
    Route::post('userLogin', [CoursesCatalogController::class, 'loginModalProcess'])->name('user.login.post');
    Route::post('/register-course-batch', [CoursesCatalogController::class, 'registerCourseProcess'])->name('student.course.register.post');
    Route::get('/enrolled-course', [EnrolledCourseController::class, 'afterEnrollView'])->name('student.course.enrolled');
    Route::get('/assignments/{assignment}', [EnrolledCourseController::class, 'showassignment'])->name('student.course.assignment');
    Route::get('/download-assignments/{assignment}', [EnrolledCourseController::class, 'downloadAssignmentDocument'])->name('download.assignment');
    Route::post('/submit-assignment', [EnrolledCourseController::class, 'submitAssignment'])->name('submit.assignment');
    Route::post('/review-course', [EnrolledCourseController::class, 'courseReviewProcess'])->name('student.course.review.post');

    Route::post('/filter-course', [CoursesCatalogController::class, 'filterCourse'])->name('filter-course');
    Route::get('/my-courses', [MyCoursesController::class, 'showMyCourses'])->name('my-courses');
    Route::get('/assigned-courses', [AssignedCoursesController::class, 'viewAssignedCourses'])->name('assigned-courses');
    Route::get('/student-list/{course}', [AssignedCoursesController::class, 'viewStudentList'])->name('student-list');
    Route::get('/view-course-content/{course}', [AssignedCoursesController::class, 'ViewCourseContent'])->name('view-course-content');
    Route::get('/download/{topic}', [AssignedCoursesController::class, 'downloadStudyMaterial'])->name('download-study-material');

});
