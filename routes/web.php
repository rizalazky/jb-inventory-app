<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

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





Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // role
    Route::middleware('role_or_permission:lihat role')->prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/create', [RoleController::class, 'create_post'])->name('role.create_post');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/edit/{id}', [RoleController::class, 'edit_post'])->name('role.edit_post');
        Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    });
    // user
    Route::middleware('role_or_permission:lihat user')->prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/create', [UserController::class, 'create_post'])->name('user.create_post');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/edit/{id}', [UserController::class, 'edit_post'])->name('user.edit_post');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    });
    // customers
    Route::middleware('role_or_permission:lihat customer')->prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/create', [CustomerController::class, 'create_post'])->name('customer.create_post');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/edit/{id}', [CustomerController::class, 'edit_post'])->name('customer.edit_post');
        Route::delete('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
    });

    Route::get('/akses',[PermissionController::class,'index'])->name('akses.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
