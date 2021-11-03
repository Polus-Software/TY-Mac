<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\EditProfile\EditController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Input;
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
});

