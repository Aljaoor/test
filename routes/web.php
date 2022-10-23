<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Route;

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
//Auth::routes();




Route::get('/', function () {
    return view('login');
});



Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/assignProducts/{id}', [\App\Http\Controllers\ProductUserController::class, 'assignProducts'])->name('assignProducts');
Route::post('/assign', [\App\Http\Controllers\ProductUserController::class, 'assign'])->name('assign');
Route::get('/home', [\App\Http\Controllers\ProductUserController::class,'index'])->name('home');

Route::controller(\App\Http\Controllers\UserController::class)
    ->prefix('/user')
//    ->middleware(['auth'])
    ->group(function () {
        Route::get('/create', 'create')->name('users.create');
        Route::get('/index', 'index')->name('users.index');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/edit/{id}', 'edit')->name('users.edit');
        Route::post('/update/{id}', 'update')->name('users.update');
        Route::get('/destroy/{id}', 'destroy')->name('users.destroy');
        Route::get('/products/{id}', 'products')->name('users.products');

    });
Route::controller(\App\Http\Controllers\ProductController::class)
    ->prefix('/products')
//    ->middleware(['auth'])
    ->group(function () {
        Route::post('/add', 'add')->name('products.add');
        Route::get('/view', 'show')->name('products.show');
        Route::post('/update', 'update')->name('products.update');
        Route::post('/delete', 'delete')->name('delete');
        Route::post('/assign', 'assign');

    });
