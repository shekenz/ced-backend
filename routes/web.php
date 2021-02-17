<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostsController;

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

// Main index route
Route::get('/', [PostsController::class, 'baseIndex'])->name('home');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Users (Auth in controller)
Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/user/{user}', [UsersController::class, 'display'])->name('users.display');
Route::get('/user/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::patch('/user/{user}', [UsersController::class, 'update'])->name('users.update');
Route::post('/user/delete/{user}', [UsersController::class, 'delete'])->name('users.delete');

// Posts (Auth in controller)
Route::get('/posts', [PostsController::class, 'index'])->name('posts');
Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
Route::get('/post/create', [PostsController::class, 'create'])->name('posts.create');
Route::get('/post/{id}', [PostsController::class, 'display'])->name('posts.display');
Route::get('/post/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');
Route::patch('/post/{post}', [PostsController::class, 'update'])->name('posts.update');

// Media
Route::get('/media', [MediaController::class, 'index'])->name('media');
Route::post('/media', [MediaController::class, 'store'])->name('media.store');
Route::get('/media/create', [MediaController::class, 'create'])->name('media.create');
Route::get('/media/{medium}', [MediaController::class, 'display'])->name('media.display');

require __DIR__.'/auth.php';
