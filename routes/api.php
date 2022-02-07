<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\EditProfile\EditController;
use App\Http\Controllers\Student\CoursesCatalogController;
use App\Http\Controllers\Student\EnrolledCourseController;

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

Route::post('/login', [AuthController::class, 'loginProcessApi']);
Route::post('/register', [AuthController::class, 'signupProcessApi']);
Route::get('/get-all-courses', [CoursesCatalogController::class, 'viewAllCoursesApi']);
Route::get('/show-course/{id}', [CoursesCatalogController::class, 'showCourseApi']);
Route::post('/contact-us', [AuthController::class, 'contactUsApi']);


Route::group(['middleware' => ['auth:sanctum']],function() {
    Route::get('/logout', [AuthController::class, 'logoutApi']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'resetPasswordApi']);
    Route::put('/profile-update', [EditController::class, 'profileUpdateApi']);
    Route::post('/upload-avatar', [EditController::class, 'uploadImageApi']);
    Route::post('/choose-cohort', [CoursesCatalogController::class, 'registerCourseApi']);
    Route::post('/register-course', [CoursesCatalogController::class, 'registerCourseProcessApi']);
    Route::post('/add-course-review', [EnrolledCourseController::class, 'courseReviewApi']);
    Route::post('/get-course-progress/{id}', [EnrolledCourseController::class, 'getCourseProgressApi']);
    Route::get('/view-assignments/{courseId}', [EnrolledCourseController::class, 'afterEnrollViewApi']);
    Route::post('/submit-assignment', [EnrolledCourseController::class, 'submitAssignmentApi']);
    Route::get('/get-badges', [EnrolledCourseController::class, 'getBadgesApi']);
    Route::get('/get-notifications', [AuthController::class, 'getNotificationsApi']);
});

