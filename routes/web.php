<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes(['register' => false, 'login' => false]);

Route::get('/',[\App\Http\Controllers\AdminController::class,'index'])->name('admin.connexion');
Route::post('/login',[\App\Http\Controllers\AdminController::class,'login'])->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware' => [Admin::class]], function () {
Route::get('/dashboard',[\App\Http\Controllers\AdminController::class,'dashboard'])->name('admin.dashboard');
Route::get('/fournisseurs',[\App\Http\Controllers\FournisseurController::class,'index'])->name('admin.fournisseur');
Route::post('/save/fournisseur',[\App\Http\Controllers\FournisseurController::class,'store'])->name('admin.save.fournisseur');
Route::delete('/delete/fournisseur/{id}',[\App\Http\Controllers\FournisseurController::class,'destroy'])->name('admin.delete.fournisseur');
Route::get('/categories/sous-categorie',[\App\Http\Controllers\CategoryController::class,'subCategory'])->name('admin.categorie.subCategory');
Route::resource('/categories',App\Http\Controllers\CategoryController::class);
Route::resource('/subCategory',App\Http\Controllers\SubCategoryController::class);
Route::resource('/clients',App\Http\Controllers\ClientController::class);
Route::resource('/produits',\App\Http\Controllers\ProduitController::class);




});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
