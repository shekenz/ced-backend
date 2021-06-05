<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SettingsController;

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
Route::get('/', [BooksController::class, 'index'])->middleware('published')->name('index');
/* Route::view('/cart', 'index/cart', [
	'subTotal' => '240',
	'artist' => 'Name',
	'title' => 'Title',
	'quantity' => '1',
])->middleware('published')->name('cart'); */
Route::view('/about', 'index/about')->middleware('published')->name('about');
Route::view('/contact', 'index/contact')->middleware('published')->name('messages');
Route::post('/contact', [MessagesController::class, 'forward'])->middleware('published')->name('messages.forward');

// Cart
Route::get('/cart', [CartController::class, 'viewCart'])->middleware('published')->name('cart');
Route::get('/cart/populate', [CartController::class, 'populateCart'])->middleware('published')->name('cart.populate');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->middleware('published')->name('cart.clear');
Route::get('/cart/add/{book}', [CartController::class, 'add'])->middleware('published')->name('cart.add');
Route::get('/cart/remove/{book}', [CartController::class, 'remove'])->middleware('published')->name('cart.remove');
Route::get('/cart/remove-all/{book}', [CartController::class, 'removeAll'])->middleware('published')->name('cart.removeAll');
Route::get('/cart/shipping', [CartController::class, 'shipping'])->middleware('published')->name('cart.shipping');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->middleware('published')->name('cart.checkout');
Route::get('/cart/confirmed', [CartController::class, 'confirmed'])->middleware('published')->name('cart.confirmed');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Orders
Route::get('/dashboard/orders/', [OrdersController::class, 'list'])->middleware('auth')->name('orders');

// Users
Route::get('/dashboard/users', [UsersController::class, 'list'])->middleware('auth')->name('users');
Route::get('/dashboard/user/{user}', [UsersController::class, 'display'])->middleware('auth')->name('users.display');
Route::get('/dashboard/user/edit/{user}', [UsersController::class, 'edit'])->middleware('auth')->name('users.edit');
Route::patch('/dashboard/user/{user}', [UsersController::class, 'update'])->middleware('auth')->name('users.update');
Route::post('/dashboard/user/delete/{user}', [UsersController::class, 'delete'])->middleware('auth')->name('users.delete');
Route::get('/dashboard/users/invite', [UsersController::class, 'invitation'])->middleware('auth')->name('users.invitation');
Route::post('/dashboard/users/invite', [UsersController::class, 'invite'])->middleware('auth')->name('users.invite');

// Books
Route::get('/dashboard/books', [BooksController::class, 'list'])->middleware('auth')->name('books');
Route::get('/dashboard/book/create', [BooksController::class, 'create'])->middleware('auth')->name('books.create');
Route::post('/dashboard/books', [BooksController::class, 'store'])->middleware('auth')->name('books.store');
Route::get('/dashboard/book/edit/{id}', [BooksController::class, 'edit'])->middleware('auth')->name('books.edit');
Route::patch('/dashboard/book/{book}', [BooksController::class, 'update'])->middleware('auth')->name('books.update');
Route::get('/dashboard/book/{id}', [BooksController::class, 'display'])->middleware('auth')->name('books.display');
Route::get('/dashboard/book/archive/{book}', [BooksController::class, 'archive'])->middleware('auth')->name('books.archive');
Route::post('/dashboard/book/delete/{id}', [BooksController::class, 'delete'])->middleware('auth')->name('books.delete');
Route::post('/dashboard/books/archived/delete', [BooksController::class, 'deleteAll'])->middleware('auth')->name('books.deleteAll');
Route::get('/dashboard/book/restore/{id}', [BooksController::class, 'restore'])->middleware('auth')->name('books.restore');
Route::get('/dashboard/books/archived', [BooksController::class, 'archived'])->middleware('auth')->name('books.archived');

// Media
Route::get('/dashboard/media', [MediaController::class, 'list'])->middleware('auth')->name('media');
Route::post('/dashboard/media', [MediaController::class, 'store'])->middleware('auth')->name('media.store');
Route::get('/dashboard/media/create', [MediaController::class, 'create'])->middleware('auth')->name('media.create');
Route::get('/dashboard/media/refresh', [MediaController::class, 'refreshAll'])->middleware('auth')->name('media.optimize.refreshAll');
Route::get('/dashboard/media/rebuild', [MediaController::class, 'rebuildAll'])->middleware('auth')->name('media.optimize.rebuildAll');
Route::get('/dashboard/media/{medium}', [MediaController::class, 'display'])->middleware('auth')->name('media.display');
Route::patch('/dashboard/media/{medium}', [MediaController::class, 'update'])->middleware('auth')->name('media.update');
Route::get('/dashboard/media/refresh/{medium}', [MediaController::class, 'refresh'])->middleware('auth')->name('media.optimize.refresh');
Route::get('/dashboard/media/rebuild/{medium}', [MediaController::class, 'rebuild'])->middleware('auth')->name('media.optimize.rebuild');
Route::get('/dashboard/media/{medium}/break/{book}', [MediaController::class, 'breakLink'])->middleware('auth')->name('media.break');
Route::post('/dashboard/media/delete/{id}', [MediaController::class, 'delete'])->middleware('auth')->name('media.delete');

// Settings
Route::view('/dashboard/settings', 'settings.main')->middleware('auth')->name('settings');
Route::patch('/dashboard/settings', [SettingsController::class, 'update'])->middleware('auth')->name('settings.update');
Route::get('/dashboard/settings/publish', [SettingsController::class, 'publish'])->middleware('auth')->name('settings.publish');

// Misc/Debug/Log
Route::get('/dashboard/mails/log', [MessagesController::class, 'log'])->middleware('auth')->name('mails.log');
Route::get('/dashboard/phpinfo', function() {
	return view('other.phpinfo');
})->middleware('auth')->name('phpinfo');

require __DIR__.'/auth.php';
