<?php

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryMenuController;
use App\Http\Controllers\ViewCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Autentication
Route::controller(AuthController::class)->group(function () {
    Route::get('/login','index') ->name('login');
    Route::post('/login','authenticate') ->name('auth');
    Route::post('/logout','logout') ->name('logout');
});

//Forgot Password
Route::controller(ForgotPasswordController::class)->group(function(){
    Route::get('/forget-password','showForgetPasswordForm') ->name('forget.password.get');
    Route::post('/forget-password','submitForgetPasswordForm') ->name('forget.password.post');
    Route::get('reset-password/{token}','showResetPasswordForm') ->name('reset.password.get');
    Route::post('/reset-password','submitResetPasswordForm') ->name('reset.password.post');
});

//Admin General Page
Route::group(['middleware' => ['auth','level:admin,kasir,manager']], function(){
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/categories', CategoryController::class);
});

//Superuser Page
Route::group(['middleware' => ['auth','level:admin,manager']], function(){
    Route::resource('/user', UserController::class);
});


//Guest Page
Route::resource('/', HomeController::class);
Route::resource('/category', CategoryMenuController::class);
Route::resource('/menu', MenuController::class);
Route::resource('/about', AboutController::class);
Route::resource('/view-category/{id}', ViewCategoryController::class);