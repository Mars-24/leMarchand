<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes(['register' => false, 'login' => false]);

Route::get('/',[\App\Http\Controllers\AdminController::class,'index'])->name('admin.connexion');
Route::post('/login',[\App\Http\Controllers\AdminController::class,'login'])->name('admin.login');
Route::get('/dashboard',[\App\Http\Controllers\AdminController::class,'dashboard'])->name('admin.dashboard');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
