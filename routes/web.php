<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
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
            Route::get('',  [RoleController::class, 'index'])->name('admin.roles.list');
            Route::post('', [RoleController::class, 'store'])->name('admin.roles.store');
            Route::delete('', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
            Route::post('{id}', [RoleController::class, 'update'])->name('admin.roles.update');
        });

        Route::prefix('permissions')->group(function () {
            Route::get('',  [PermissionController::class, 'index'])->name('admin.permissions.list');
            Route::post('', [PermissionController::class, 'store'])->name('admin.permissions.store');
            Route::delete('', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');
            Route::post('{id}', [PermissionController::class, 'update'])->name('admin.permissions.update');
        });

        Route::prefix('categories')->group(function () {
            Route::get('',  [CategoryController::class, 'index'])->name('admin.categories.list');
            Route::post('', [CategoryController::class, 'store'])->name('admin.categories.store');
            Route::delete('', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
            Route::post('{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        });
    });
});
