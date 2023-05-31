<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('main', function () {
        return view('layouts.main-app');
    })->name('main');

    Route::prefix('admin')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('', function () {
                return view('pages.admin.users.user-list');
            })->name('admin.users.list');
            Route::get('{id}', function ($id) {
                return view('pages.admin.users.user-show');
            })->name('admin.users.show');
        });

        Route::prefix('products')->group(function () {
            Route::get('', function () {
                return view('pages.admin.products.product-list');
            })->name('admin.products.list');
            Route::get('{id}', function ($id) {
                return view('pages.admin.products.product-show');
            })->name('admin.products.show');
            Route::get('new', function () {
                return view('pages.admin.products.product-new');
            })->name('admin.products.new');
        });

        Route::prefix('roles')->group(function () {
            Route::get('', function () {
                return view('pages.admin.roles.role-list');
            })->name('admin.roles.list');
        });
        Route::prefix('categories')->group(function () {
            Route::get('', function () {
                return view('pages.admin.categories.category-list');
            })->name('admin.categories.list');
        });
    });
});
