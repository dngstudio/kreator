<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes accessible only to admins
    Route::middleware('isAdmin')->group(function () {
        Route::get('/all-accounts', [ProfileController::class, 'allaccounts'])->name('all-accounts');
        Route::get('/users/create', [ProfileController::class, 'create'])->name('users.create');
        Route::post('/users', [ProfileController::class, 'store'])->name('users.store');
        Route::get('/profile/{id}/edit', [ProfileController::class, 'editUser'])->name('profile.editUser');
        Route::patch('/profile/{id?}', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::get('/subscribe/{creator}', [SubscriptionController::class, 'showSubscribePage'])->name('subscribe.page');
    Route::post('/subscribe/{creator}', [SubscriptionController::class, 'subscribe'])->name('subscribe');

    Route::get('/unsubscribe/{creator}', [SubscriptionController::class, 'showUnsubscribePage'])->name('unsubscribe.page');
    Route::post('/unsubscribe/{creator}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');

    // Route to view all creators
    Route::get('/creators', [ProfileController::class, 'allCreators'])->name('creators.index');

});

Route::resource('posts', PostController::class)->except(['show']);

// Public route to view posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Route to view individual posts
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Routes to view creator's posts, accessible to subscribers
Route::middleware(['auth', 'subscribed:creator_id'])->group(function () {
    Route::get('/posts/{creator}', [PostController::class, 'index']);
});

Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])
    ->middleware('auth')
    ->name('profile.show');


require __DIR__.'/auth.php';

