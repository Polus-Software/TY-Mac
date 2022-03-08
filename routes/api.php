<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [ApiController::class, 'loginProcessApi']);
Route::post('/register', [ApiController::class, 'signupProcessApi']);
Route::get('/get-all-courses', [ApiController::class, 'viewAllCoursesApi']);
Route::get('/show-course/{id}', [ApiController::class, 'showCourseApi']);
Route::post('/contact-us', [ApiController::class, 'contactUsApi']);

Route::group(['middleware' => ['auth:sanctum']],function() {
    Route::get('/logout', [ApiController::class, 'logoutApi']);
    Route::post('/forgot-password', [ApiController::class, 'resetPasswordApi']);
    Route::put('/profile-update', [ApiController::class, 'profileUpdateApi']);
    Route::post('/upload-avatar', [ApiController::class, 'uploadImageApi']);
    Route::post('/choose-cohort', [ApiController::class, 'registerCourseApi']);
    Route::post('/register-course', [ApiController::class, 'registerCourseProcessApi']);
    Route::post('/add-course-review', [ApiController::class, 'courseReviewApi']);
    Route::post('/get-course-progress/{id}', [ApiController::class, 'getCourseProgressApi']);
    Route::get('/view-assignments/{courseId}', [ApiController::class, 'afterEnrollViewApi']);
    Route::post('/submit-assignment', [ApiController::class, 'submitAssignmentApi']);
    Route::get('/get-badges', [ApiController::class, 'getBadgesApi']);
    Route::get('/get-notifications', [ApiController::class, 'getNotificationsApi']);
    Route::get('/my-courses', [ApiController::class, 'showMyCoursesApi']);
    Route::get('/assigned-courses', [ApiController::class, 'viewAssignedCoursesApi']);
    Route::get('/student-recommendations/{courseId}', [ApiController::class, 'getStudentRecommendationsApi']);
    Route::get('/instructor-recommendations/{courseId}/{batchId}', [ApiController::class, 'instructorRecommendationsApi']);
    Route::get('/instructor-assignments/{courseId}/{batchId}', [ApiController::class, 'getInstructorAssignmentDataApi']);
    Route::put('/review-assignment/{assignment}', [ApiController::class, 'completeAssignmentApi']);
    Route::post('/ask-question', [ApiController::class, 'askQuestionApi']);
    Route::put('/reply-question', [ApiController::class, 'replyToStudentApi']);
    Route::get('/instructor-schedule/{courseId}/{batchId}', [ApiController::class, 'viewInstructorScheduleApi']);
    Route::get('/student-schedule/{courseId}/{batchId}', [ApiController::class, 'viewStudentScheduleApi']);
});

