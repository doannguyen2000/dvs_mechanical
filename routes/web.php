<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\UserController as UserUserController;
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

Route::middleware(['auth', 'online'])->group(function () {
    Route::get('main', function () {
        return view('layouts.main-app');
    })->name('main');

    Route::get('profile', [UserUserController::class, 'showProfile'])->name('users.profile');

    Route::prefix('admin')->group(function () {

        Route::prefix('users')->group(function () {
            Route::get('',  [UserController::class, 'index'])->name('admin.users.list');
            Route::get('{id}',  [UserController::class, 'show'])->name('admin.users.show');
            Route::post('', [UserController::class, 'store'])->name('admin.users.store');
            Route::post('delete', [UserController::class, 'destroy'])->name('admin.users.destroy');
            Route::post('update-status-user', [UserController::class, 'updateStatusUser'])->name('admin.users.updateStatusUser');
            Route::post('{id}', [UserController::class, 'update'])->name('admin.users.update');
            Route::post('update-role-user/{id}', [UserController::class, 'updateRoleUser'])->name('admin.users.updateRoleUser');
        });

        Route::prefix('products')->group(function () {
            Route::get('',  [ProductController::class, 'index'])->name('admin.products.list');
            Route::get('{id}',  [ProductController::class, 'show'])->name('admin.products.show');
            Route::post('', [ProductController::class, 'store'])->name('admin.products.store');
            Route::post('delete', [ProductController::class, 'destroy'])->name('admin.products.destroy');
            Route::post('{id}', [ProductController::class, 'update'])->name('admin.products.update');
            Route::post('update-product-category/{id}', [ProductController::class, 'updateProductCategory'])->name('admin.products.updateProductCategory');
        });

        Route::prefix('roles')->group(function () {
            Route::get('',  [RoleController::class, 'index'])->name('admin.roles.list');
            Route::get('{id}',  [RoleController::class, 'show'])->name('admin.roles.show');
            Route::post('', [RoleController::class, 'store'])->name('admin.roles.store');
            Route::post('delete', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
            Route::post('{id}', [RoleController::class, 'update'])->name('admin.roles.update');
            Route::post('update-role-permission/{id}', [RoleController::class, 'updateRolePermission'])->name('admin.roles.updateRolePermission');
        });

        Route::prefix('permissions')->group(function () {
            Route::get('',  [PermissionController::class, 'index'])->name('admin.permissions.list');
            Route::get('{id}',  [PermissionController::class, 'show'])->name('admin.permissions.show');
            Route::post('', [PermissionController::class, 'store'])->name('admin.permissions.store');
            Route::post('delete', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');
            Route::post('{id}', [PermissionController::class, 'update'])->name('admin.permissions.update');
        });

        Route::prefix('categories')->group(function () {
            Route::get('',  [CategoryController::class, 'index'])->name('admin.categories.list');
            Route::post('', [CategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('{id}',  [CategoryController::class, 'show'])->name('admin.categories.show');
            Route::post('delete', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
            Route::post('{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        });
    });
});
