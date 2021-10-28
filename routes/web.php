<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\EditProfile\EditController;
use App\Http\Controllers\AdminController;

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

    Route::get('/admin/index', [AdminController::class, 'viewAllStudents'])->name('admin.viewall');
   
});

