<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\OnlyAdminHasAccess;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Front\FrontEndController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Front\ContactMessageController;
use App\Http\Controllers\MessageController;

// Route::get('/', function () {
//     return view('welcome');
// });

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
// Rutele pentru partea de administrare, de back-end:
Route::prefix('admin')->controller(UserController::class)->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', 'showHome')->name('admin.home');
});

// Rutele pentru partea de administrare, de back-end, pentru utilizatori:
Route::prefix('admin')->controller(UserController::class)->middleware(['auth', 'verified', OnlyAdminHasAccess::class])->group(function() {
    Route::get('/users', 'showUsers')->name('admin.users');
    Route::get('/new-user-form', 'newUserForm')->name('new-user-form');
    Route::post('/create-new-user', 'createNewUser')->name('create-new-user');
    Route::get('/edit-user-form/{userId}', 'editUserForm')->name('edit-user-form');
    Route::put('/update-user/{userId}', 'updateUser')->name('update-user');
    Route::delete('/delete-user/{userId}', 'deleteUser')->name('delete-user');
});

// Rutele pentru partea de administrare, de back-end, pentru administrarea profilului de utilizator:
Route::prefix('admin')->controller(UserProfileController::class)->middleware('auth', 'verified')->group(function() {
    Route::get('/edit-user-profile-form', 'showUserProfileForm')->name('edit-user-profile-form');
    Route::put('/update-user-profile', 'updateUserProfile')->name('update-user-profile');
    Route::put('/update-password', 'updatePassword')->name('update-password');
});

// Rutele pentru partea de administrare, de back-end, pentru categorii:
Route::prefix('admin')->controller(CategoryController::class)->middleware('auth', 'verified')->group(function() {
    Route::get('/categories', 'showCategories')->name('admin.categories');
    Route::get('/new-category-form', 'newCategoryForm')->name('admin.new-category-form');
    Route::post('/create-new-category', 'createNewCategory')->name('admin.create-new-category');
    Route::get('/edit-category-form/{categoryId}', 'editCategoryForm')->name('admin.edit-category-form');
    Route::put('/update-category/{categoryId}', 'updateCategory')->name('admin.update-category');
    Route::delete('/delete-category/{categoryId}', 'deleteCategory')->name('admin.delete-category');
});

// Rutele pentru partea de administrare, de back-end, pentru postări:
Route::prefix('admin')->controller(PostController::class)->middleware('auth', 'verified')->group(function() {
    Route::get('/posts', 'showPosts')->name('admin.posts');
    Route::get('/new-post-form', 'newPostForm')->name('admin.new-post-form');
    Route::post('/create-new-post', 'createNewPost')->name('admin.create-new-post');
    Route::get('/edit-post-form/{postId}', 'editPostForm')->name('admin.edit-post-form');
    Route::put('/update-post/{postId}', 'updatePost')->name('admin.update-post');
    Route::get('/change-categories-form/{postId}', 'showChangeCategoriesForm')->name('admin.change-categories-form');
    Route::put('/change-categories/{postId}', 'changeCategories')->name('admin.change-categories');
    Route::delete('/delete-post/{postId}', 'deletePost')->name('admin.delete-post');
    Route::get('/manage-post-images-form/{postId}', [ImageController::class, 'showPostImagesForm'])->name('admin.manage-post-images-form');
    Route::post('/manage-post-images-upload/{postId}', [ImageController::class, 'uploadPostImages'])->name('admin.manage-post-images-upload');
    Route::put('/manage-post-images-update-image/{imageId}', [ImageController::class, 'updatePostImageFromGallery'])->name('admin.manage-post-images.update-image');
    Route::delete('/manage-post-images-delete/{imageId}', [ImageController::class, 'deleteAllPostImages'])->name('admin.manage-post-images-delete');
    Route::delete('/manage-post-images-delete-image/{imageId}', [ImageController::class, 'deleteSinglePostImage'])->name('admin.manage-post-images-delete-image');
});

// Rutele pentru partea de administrare, de back-end, pentru mesajele de contact:
Route::prefix('admin')->controller(AdminContactMessageController::class)->middleware('auth', 'verified')->group(function() {
    Route::get('/contact-messages', 'showContactMessages')->name('admin.contact-messages');
    Route::delete('/delete-contact-message/{contactMessageId}', 'deleteContactMessage')->name('admin.delete-contact-message');
});

// Rutele pentru partea de client, de front-end, pentru paginilie principale:
Route::get('/', [FrontEndController::class, 'showAllCategories'])->name('front.all-categories');
Route::get('/current-category/{category:slug}', [FrontEndController::class, 'showCurrentCategory'])->name('front.current-category');
Route::get('/all-posts', [FrontEndController::class, 'showAllPosts'])->name('front.all-posts');
Route::get('/current-post/{post:slug}', [FrontEndController::class, 'showCurrentPost'])->name('front.current-post');

// Rutele pentru partea de client, de front-end, pentru formularul de contact:
Route::get('/contact', [ContactMessageController::class, 'newContactMessageForm'])->name('front.contact');
Route::post('/contact/create-new-message', [ContactMessageController::class, 'createNewContactMessage'])->name('front.create-new-contact-message');