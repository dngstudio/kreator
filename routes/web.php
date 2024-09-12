<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes accessible only to admins
    Route::middleware('isAdmin')->group(function () {
        Route::get('/all-accounts', [ProfileController::class, 'allaccounts'])->name('all-accounts');
        Route::get('/users/create', [ProfileController::class, 'create'])->name('users.create');
        Route::post('/users', [ProfileController::class, 'store'])->name('users.store');

        // Admin can access the edit form of any user by their ID
        Route::get('/profile/{id}/edit', [ProfileController::class, 'editUser'])->name('profile.editUser');
        Route::patch('/profile/{id?}', [ProfileController::class, 'update'])->name('profile.update');
    });
});

Route::middleware(['auth', 'role:admin|creator'])->group(function () {
    Route::resource('posts', PostController::class)->except(['show']);
});



require __DIR__.'/auth.php';
