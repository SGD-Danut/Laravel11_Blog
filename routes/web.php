<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\OnlyAdminHasAccess;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Rute scrise in mod standard:
// Route::get('/admin', [UserController::class, 'showHome'])->middleware(['auth', OnlyAdminHasAccess::class])->name('admin.home');
// Route::get('/admin/users', [UserController::class, 'showUsers'])->middleware(['auth', OnlyAdminHasAccess::class])->name('admin.users');
// Route::get('/admin/new-user-form', [UserController::class, 'newUserForm'])->middleware(['auth', OnlyAdminHasAccess::class])->name('new-user-form');
// Route::post('/admin/create-new-user', [UserController::class, 'createNewUser'])->middleware(['auth', OnlyAdminHasAccess::class])->name('create-new-user');

// Rute grupate dupa prefix, middleware si controller:
Route::prefix('admin')->controller(UserController::class)->middleware(['auth', OnlyAdminHasAccess::class])->group(function() {
    Route::get('/', 'showHome')->name('admin.home');
    Route::get('/users', 'showUsers')->name('admin.users');
    Route::get('/new-user-form', 'newUserForm')->name('new-user-form');
    Route::post('/create-new-user', 'createNewUser')->name('create-new-user');
});