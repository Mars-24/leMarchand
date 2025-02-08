<?php

use App\Http\Middleware\Admin;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes(['register' => false, 'login' => false]);

Route::get('/',[\App\Http\Controllers\AdminController::class,'auth'])->name('admin.connexion');
Route::post('/login',[\App\Http\Controllers\AdminController::class,'login'])->name('admin.login');
Route::get('/logout',[\App\Http\Controllers\AdminController::class,'logout'])->name('logout.admin');


Route::group(['prefix' => 'admin', 'middleware' => [Admin::class]], function () {
Route::get('/dashboard',[\App\Http\Controllers\AdminController::class,'dashboard'])->name('admin.dashboard');
Route::get('/profil',[\App\Http\Controllers\AdminController::class,'profil'])->name('admin.profil');

Route::get('/cart/subtotal', function () {
    $subtotal = \Gloudemans\Shoppingcart\Facades\Cart::instance('facture')->subtotal(0, '', '');
    return response()->json(['subtotal' => $subtotal]);
})->name('cart.subtotal');

Route::post('/update-profil', [\App\Http\Controllers\AdminController::class, 'updateProfil'])->name('update.profil');

Route::get('/fournisseurs',[\App\Http\Controllers\FournisseurController::class,'index'])->name('admin.fournisseur');
Route::post('/save/fournisseur',[\App\Http\Controllers\FournisseurController::class,'store'])->name('admin.save.fournisseur');
Route::delete('/delete/fournisseur/{id}',[\App\Http\Controllers\FournisseurController::class,'destroy'])->name('admin.delete.fournisseur');
Route::get('/categories/sous-categorie',[\App\Http\Controllers\CategoryController::class,'subCategory'])->name('admin.categorie.subCategory');
Route::resource('/categories',App\Http\Controllers\CategoryController::class);
Route::get('/depenses/liste',[App\Http\Controllers\DepenseController::class,'liste'])->name('depense.liste');
Route::resource('/depenses',App\Http\Controllers\DepenseController::class);
Route::resource('/fonds',App\Http\Controllers\FondDeCaisseController::class);
Route::resource('/subCategory',App\Http\Controllers\SubCategoryController::class);
Route::get('/clients/fideles',[App\Http\Controllers\ClientController::class,'clientFidele'])->name('client.fideles');
Route::resource('/clients',App\Http\Controllers\ClientController::class);


Route::resource('/admins',App\Http\Controllers\AdminController::class);
Route::get('/client/search',[App\Http\Controllers\ClientController::class,'findClient'])->name('client-info');
Route::get('/facture/deal-invoice-view',[\App\Http\Controllers\OrderController::class,'dealView'])->name('deal-view');
Route::get('/facture/paiement-invoice-view',[\App\Http\Controllers\OrderController::class,'paiementView'])->name('paiement-view');
Route::get('/facture/acompte-invoice-view',[\App\Http\Controllers\OrderController::class,'acompteView'])->name('acompte-view');

Route::get('/produits/search', [\App\Http\Controllers\ProduitController::class, 'search'])->name('produits.search');

Route::resource('/produits',\App\Http\Controllers\ProduitController::class);
Route::resource('/defectueux',\App\Http\Controllers\ProduitDefectueuxController::class);


Route::get('/factures/print/{id}', [\App\Http\Controllers\OrderController::class, 'print'])->name('factures.print');

Route::resource('/factures',\App\Http\Controllers\OrderController::class);
Route::post('/factures/add',[\App\Http\Controllers\OrderController::class,'cartStore'])->name('cart.store');
Route::post('/factures/delete',[\App\Http\Controllers\OrderController::class,'cartDelete'])->name('cart.delete');

Route::post('/factures/update',[\App\Http\Controllers\OrderController::class,'cartUpdate'])->name('cart.update');

});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
