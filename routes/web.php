<?php

use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FrontController;

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
//Route::get('/', [FrontController::class, 'index'])->name('index');

Route::get('/', [BooksController::class, 'index'])->name('index');
Route::view('/cart', 'index/cart', [
	'subTotal' => '240',
	'artist' => 'Name',
	'title' => 'Title',
	'quantity' => '1',
])->name('cart');
Route::view('/about', 'index/about')->name('about');
Route::view('/contact', 'index/contact')->name('contact');


// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Users (Auth in controller)
Route::get('/dashboard/users', [UsersController::class, 'list'])->name('users');
Route::get('/dashboard/user/{user}', [UsersController::class, 'display'])->name('users.display');
Route::get('/dashboard/user/edit/{user}', [UsersController::class, 'edit'])->name('users.edit');
Route::patch('/dashboard/user/{user}', [UsersController::class, 'update'])->name('users.update');
Route::post('/dashboard/user/delete/{user}', [UsersController::class, 'delete'])->name('users.delete');

// Books (Auth in controller)
Route::get('/dashboard/books', [BooksController::class, 'list'])->name('books');
Route::get('/dashboard/book/create', [BooksController::class, 'create'])->middleware('auth')->name('books.create');
Route::post('/dashboard/books', [BooksController::class, 'store'])->name('books.store');
Route::get('/dashboard/book/edit/{id}', [BooksController::class, 'edit'])->name('books.edit');
Route::patch('/dashboard/book/{book}', [BooksController::class, 'update'])->name('books.update');
Route::get('/dashboard/book/{id}', [BooksController::class, 'display'])->name('books.display');
Route::get('/dashboard/book/archive/{book}', [BooksController::class, 'archive'])->name('books.archive');
Route::post('/dashboard/book/delete/{id}', [BooksController::class, 'delete'])->name('books.delete');
Route::post('/dashboard/books/archived/delete', [BooksController::class, 'deleteAll'])->name('books.deleteAll');
Route::get('/dashboard/book/restore/{id}', [BooksController::class, 'restore'])->name('books.restore');
Route::get('/dashboard/books/archived', [BooksController::class, 'archived'])->name('books.archived');

// Media
Route::get('/dashboard/media', [MediaController::class, 'list'])->name('media');
Route::post('/dashboard/media', [MediaController::class, 'store'])->name('media.store');
Route::get('/dashboard/media/create', [MediaController::class, 'create'])->name('media.create');
Route::get('/dashboard/media/rebuild', [MediaController::class, 'rebuildAll'])->name('media.rebuildAll');
Route::get('/dashboard/media/{medium}', [MediaController::class, 'display'])->name('media.display');
Route::get('/dashboard/media/{medium}/break/{book}', [MediaController::class, 'breakLink'])->name('media.break');
Route::post('/dashboard/media/delete/{id}', [MediaController::class, 'delete'])->name('media.delete');
Route::get('/dashboard/media/rebuild/{medium}', [MediaController::class, 'rebuild'])->name('media.rebuild');



require __DIR__.'/auth.php';
