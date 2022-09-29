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

Route::get('/403', function () {
    return view('Errors.accessDenied');
});
Route::get('/404', function () {
    return view('Errors.404');
});

Route::group(['middleware' => 'prevent-back-history'],function() {
    
Route::get('/', function () {
    return view('homepage');
})->name('home');
    Route::get('/signup', [AuthController::class, 'signUp'])->name('signup');
    Route::post('/read-notifications', [AuthController::class, 'readNotifications'])->name('read-notifications');
    Route::post('/create-user', [AuthController::class, 'signupProcess'])->name('user.create');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/user-login', [AuthController::class, 'loginProcess'])->name('user.login');
    Route::get('/dashboard', [AuthController::class, 'dashboardView'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/user-contact', [AuthController::class, 'contactUs'])->name('user.contact');
    Route::get('/get-notifications', [AuthController::class, 'getNotifications'])->name('get-notifications');

    Route::get('/edit', [EditController::class, 'edituser'])->name('edituser');
    Route::post('/update',[EditController::class, 'profileUpdate'])->name('profileUpdate');

    Route::get('/manage-courses', [CourseController::class, 'index'])->name('manage-courses');
    Route::post('/save-course', [CourseController::class, 'saveCourse'])->name('save-course');
    Route::get('/add-course', [CourseController::class, 'addCourse'])->name('add-course');
    Route::get('/create-subtopic', [CourseController::class, 'createSubtopic'])->name('create-subtopic');
    Route::get('/create-assignment', [CourseController::class, 'createAssignment'])->name('create-assignment');
    Route::get('/view-assignments', [CourseController::class, 'viewAssignments'])->name('view-assignments');
    Route::get('/edit-assignment', [CourseController::class, 'editAssignment'])->name('edit-assignment');
    Route::post('/update-assignment', [CourseController::class, 'updateAssignment'])->name('update-assignment');
    Route::get('/delete-assignment', [CourseController::class, 'deleteAssignment'])->name('delete-assignment');
    Route::get('/create-cohortbatch', [CourseController::class, 'createCohortBatch'])->name('create-cohortbatch');
    Route::get('/save-cohortbatch', [CourseController::class, 'saveCohortBatch'])->name('save-cohortbatch');
    Route::get('/delete-cohort', [CourseController::class, 'deleteCohortbatch'])->name('delete-cohortbatch');
    Route::get('/edit-cohort', [CourseController::class, 'editCohortbatch'])->name('edit-cohortbatch');
    Route::post('/publish-course', [CourseController::class, 'publishCourse'])->name('publish-course');


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
    Route::get('/add-creator', [CreatorController::class, 'addCreator'])->name('add-creator');
    Route::post('/save-creator', [CreatorController::class, 'saveCreator'])->name('save-creator');
    Route::get('/view-creator', [CreatorController::class, 'viewCreator'])->name('view-creator');
    Route::get('/edit-creator', [CreatorController::class, 'editCreator'])->name('edit-creator');
    Route::post('/update-creator', [CreatorController::class, 'updateCreator'])->name('update-creator');
    Route::post('/delete-creator', [CreatorController::class, 'deleteCreator'])->name('delete-creator');
    Route::put('/update',[EditController::class, 'profileUpdate'])->name('profileUpdate');


    Route::get('/students', [AdminController::class, 'viewAllStudents'])->name('admin.viewall');
    Route::get('/attendance-tracker-view', [AdminController::class, 'attendanceTrackerView'])->name('attendance.tracker.view');
    Route::get('/get-attendance-data', [AdminController::class, 'getAttendanceData'])->name('get.attendance.data');
    Route::post('/get-attendance-table', [AdminController::class, 'getAttendanceTable'])->name('get.attendance.table');
    Route::post('/get-attendance-batches', [AdminController::class, 'getAttendanceBatches'])->name('get.attendance.batches');
    Route::post('/get-attendance-sessions', [AdminController::class, 'getAttendanceSessions'])->name('get.attendance.sessions');
	Route::get('/manage-reviews', [AdminController::class, 'getUserReviews'])->name('admin.manager_reviews');
	Route::get('/manager-reviews-filter', [AdminController::class, 'getUserReviewsFilter'])->name('admin.manager_reviews_filter');
	Route::post('/publish-review', [AdminController::class, 'publishReview'])->name('publish-review');
	
    Route::get('/students/{student}', [AdminController::class, 'showStudent'])->name('admin.showstudent');
    Route::get('/students/edit/{student}', [AdminController::class, 'editStudent'])->name('admin.editstudent');
    Route::put('/students/update/{students}', [AdminController::class, 'updateStudent'])->name('admin.updatestudent');
    Route::post('/students/delete', [AdminController::class, 'destroyStudent'])->name('admin.deletestudent');
    Route::get('/admin-settings', [AdminController::class, 'adminSettings'])->name('admin-settings');
    Route::post('/change-filter-status', [AdminController::class, 'changeFilterStatus'])->name('change-filter-status');
    Route::post('/save-threshold', [AdminController::class, 'saveThreshold'])->name('save-threshold');
    Route::get('/view-student', [AdminController::class, 'viewStudent'])->name('view-student');
    Route::get('/edit-student', [AdminController::class, 'editStudent'])->name('edit-student');
    Route::post('/reactivate-student', [AdminController::class, 'reactivateStudent'])->name('reactivate-student');
    Route::post('/update-student', [AdminController::class, 'updateStudent'])->name('update-student');
    Route::get('/course-search', [AdminController::class, 'courseSearch'])->name('course-search');
    Route::get('/manage-admin', [AdminController::class, 'viewAllAdmin'])->name('manage-admin');
    Route::get('/view-admin', [AdminController::class, 'viewAdmin'])->name('view-admin');
    Route::get('/add-admin', [AdminController::class, 'addAdmin'])->name('add-admin');
    Route::post('/save-admin', [AdminController::class, 'saveAdmin'])->name('save-admin');
    Route::post('/update-admin', [AdminController::class, 'updateAdmin'])->name('update-admin');
    Route::get('/edit-admin', [AdminController::class, 'editAdmin'])->name('edit-admin');
    Route::post('/delete-admin', [AdminController::class, 'deleteAdmin'])->name('delete-admin');

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
    Route::get('edit-subtopics/{topic}', [CourseController::class, 'editSubTopics'])->name('edit-subtopics');
    Route::get('delete-subtopics/{topic}', [CourseController::class, 'deleteSubTopics'])->name('delete-subtopics');
    Route::get('view_cohortbatches', [CourseController::class, 'viewCohortbatches'])->name('view_cohortbatches');
    Route::post('update_cohortbatches', [CourseController::class, 'updateCohortbatches'])->name('update_cohortbatches');
    Route::post('add-assignment', [CourseController::class, 'addAssignment'])->name('add-assignment');

    Route::get('view-sub-topic/{topic}', [CourseController::class, 'viewSubTopic'])->name('view-sub-topic');
  
    Route::post('save-assignment', [CourseController::class, 'saveAssignment'])->name('save-assignment');

    Route::get('generate-token/{session}', [RtmTokenGeneratorController::class, 'buildToken'])->name('generate-token');
    Route::get('generate-token-1-on-1/{topic}/{user}', [RtmTokenGeneratorController::class, 'buildToken1v1'])->name('generate-token-1-on-1');
    Route::post('start-screen-share', [RtmTokenGeneratorController::class, 'startScreenshare'])->name('start-screen-share');
    Route::post('get-session-push-record', [RtmTokenGeneratorController::class, 'getSessionLiveRecord'])->name('get-session-push-record');
    Route::get('generate-token-student', [RtmTokenGeneratorController::class, 'buildTokenStudent'])->name('generate-token-student');
    Route::get('session-view/{session}', [RtmTokenGeneratorController::class, 'index'])->name('session-view');
    Route::get('sessions-view', [RtmTokenGeneratorController::class, 'viewSessions'])->name('sessions-view');
    Route::get('schedule-session', [RtmTokenGeneratorController::class, 'scheduleSession'])->name('schedule-session');
    Route::post('get-course-attributes', [RtmTokenGeneratorController::class, 'showCourseAttributes'])->name('get-course-attributes');
    Route::post('save-session-details', [RtmTokenGeneratorController::class, 'saveSessionDetails'])->name('save-session-details');
    Route::post('delete-session', [RtmTokenGeneratorController::class, 'deleteSession'])->name('delete-session');
    Route::post('push-live-record', [RtmTokenGeneratorController::class, 'pushLiveRecord'])->name('push-live-record');
    Route::post('push-session-live-record', [RtmTokenGeneratorController::class, 'pushSessionLiveRecord'])->name('push-session-live-record');
    Route::post('stop-presenting', [RtmTokenGeneratorController::class, 'stopPresenting'])->name('stop-presenting');
    Route::post('show-hide-content', [RtmTokenGeneratorController::class, 'showHideContent'])->name('show-hide-content');
    Route::post('stop-content-presenting', [RtmTokenGeneratorController::class, 'stopContentPresenting'])->name('stop-content-presenting');
    Route::post('get-push-record', [RtmTokenGeneratorController::class, 'getLiveRecord'])->name('get-push-record');
    Route::post('push-feedbacks', [RtmTokenGeneratorController::class, 'pushFeedbacks'])->name('push-feedbacks');
    Route::post('student-exit', [RtmTokenGeneratorController::class, 'studentExit'])->name('student-exit');
    Route::post('get-attendance-list', [RtmTokenGeneratorController::class, 'getAttendanceList'])->name('get-attendance-list');
    Route::post('get-session-attendance-list', [RtmTokenGeneratorController::class, 'getSessionAttendanceList'])->name('get-session-attendance-list');
    Route::post('submit-feedback', [RtmTokenGeneratorController::class, 'submitSessionFeedback'])->name('submit-feedback');
    Route::post('save-session-chat', [RtmTokenGeneratorController::class, 'saveSessionChat'])->name('save-session-chat');
    Route::post('save-single-session-chat', [RtmTokenGeneratorController::class, 'saveSingleSessionChat'])->name('save-single-session-chat');
    Route::post('get-session-chat', [RtmTokenGeneratorController::class, 'getSessionChat'])->name('get-session-chat');
    Route::post('get-single-session-chat', [RtmTokenGeneratorController::class, 'getSingleSessionChat'])->name('get-single-session-chat');
    Route::post('get-session-chart', [RtmTokenGeneratorController::class, 'getSessionChart'])->name('get-session-chart');
    Route::get('1-on-1/{student}/{topic}', [RtmTokenGeneratorController::class, 'createRecommendationSession'])->name('1-on-1');
    
    Route::get('/student-courses', [CoursesCatalogController::class, 'viewAllCourses'])->name('student.courses.get');
   
    Route::get('/show-course/{course}', [CoursesCatalogController::class, 'showCourse'])->name('student.course.show');
    Route::post('/question', [CoursesCatalogController::class, 'haveAnyQuestion'])->name('question');
    Route::get('/enroll-course', [CoursesCatalogController::class, 'enrollCourse'])->name('student.course.enroll');
    Route::get('/register-course', [CoursesCatalogController::class, 'registerCourse'])->name('student.course.register');
    Route::post('userLogin', [CoursesCatalogController::class, 'loginModalProcess'])->name('user.login.post');
    Route::post('/register-course-batch', [CoursesCatalogController::class, 'registerCourseProcess'])->name('student.course.register.post');
    Route::get('/enrolled-course/{course}', [EnrolledCourseController::class, 'afterEnrollView'])->name('student.course.enrolled');
    Route::get('/assignments/{assignment}', [EnrolledCourseController::class, 'showassignment'])->name('student.course.assignment');
    Route::get('/download-assignments/{assignment}', [EnrolledCourseController::class, 'downloadAssignmentDocument'])->name('download.assignment');
    Route::post('/start-assignment', [EnrolledCourseController::class, 'startAssignment'])->name('start.assignment.post');
    Route::post('/submit-assignment', [EnrolledCourseController::class, 'submitAssignment'])->name('submit.assignment');
    Route::post('/review-course', [EnrolledCourseController::class, 'courseReviewProcess'])->name('student.course.review.post');
    Route::post('/reply-to-student', [EnrolledCourseController::class, 'replyToStudent'])->name('reply.to.student');
    Route::post('/ask-question', [EnrolledCourseController::class, 'askQuestion'])->name('ask.question');
    Route::get('/study-materials', [EnrolledCourseController::class, 'studyMaterials'])->name('study.materials');
    Route::get('/instructor-chat', [EnrolledCourseController::class, 'instructorChatView'])->name('instructor-chat');
    Route::post('/get-general-chat', [EnrolledCourseController::class, 'getGeneralChat'])->name('get-general-chat');
    Route::post('/save-general-chat', [EnrolledCourseController::class, 'saveGeneralChat'])->name('save-general-chat');
    Route::post('/get-individual-student-chart', [EnrolledCourseController::class, 'getIndividualStudentChart'])->name('get-individual-student-chart');
    Route::post('/get-instructor-assignment-modal', [EnrolledCourseController::class, 'getAssignmentModal'])->name('get-instructor-assignment-modal');
    Route::post('/complete-assignment', [EnrolledCourseController::class, 'completeAssignment'])->name('complete-assignment');
    Route::post('/recommendation-search', [EnrolledCourseController::class, 'recommendationSearch'])->name('recommendation-search');

    Route::post('/filter-course', [CoursesCatalogController::class, 'filterCourse'])->name('filter-course');
    Route::post('/course-drop-down', [CoursesCatalogController::class, 'courseDropDown'])->name('course-drop-down');
    Route::get('/my-courses', [MyCoursesController::class, 'showMyCourses'])->name('my-courses');
    Route::get('/assigned-courses', [AssignedCoursesController::class, 'viewAssignedCourses'])->name('assigned-courses');
    Route::get('/student-list/{course}', [AssignedCoursesController::class, 'viewStudentList'])->name('student-list');
    Route::get('/view-course-content/{course}', [AssignedCoursesController::class, 'ViewCourseContent'])->name('view-course-content');
    Route::get('/download/{topic}', [AssignedCoursesController::class, 'downloadStudyMaterial'])->name('download-study-material');
    Route::get('/choose-cohort', [AssignedCoursesController::class, 'chooseCohort'])->name('choose.cohort');
    Route::get('/thinklitway', function () {
        return view('thinklitway');
    })->name('thinklitway');

    Route::get('/aboutus', function () {
        return view('aboutus');
    })->name('aboutus');
Route::get('/terms', function () {
        return view('terms');
    })->name('terms');

    Route::get('/privacy', function () {
        return view('privacy');
    })->name('privacy');
    Route::get('/view-again/{session}', [RtmTokenGeneratorController::class, 'viewVideoAgain'])->name('view.again');
});
Route::get('/certificate/{course}', [EnrolledCourseController::class, 'generateCertificate'])->name('generate-certificate');
