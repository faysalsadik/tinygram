<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
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

Route::get('/',[PostController::class,'index'])->middleware('auth')->name('home');

Route::resource('/post', PostController::class)->names([
    'create' => 'post.create',
    'store' => 'post.store',
    'index' => 'post.index',
    'show' => 'post.show',
    'edit' => 'post.edit',
    'update' => 'post.update',
    'destroy' => 'post.destroy',
])->middleware('auth');
Route::resource("/comment", CommentController::class)->names([
    'create' => 'comment.create',
    'store' => 'comment.store',
    'index' => 'comment.index',
    'show' => 'comment.show',
    'edit' => 'comment.edit',
    'update' => 'comment.update',
    'destroy' => 'comment.destroy',
])->middleware('auth');
Route::prefix('like')->group(function () {
    Route::get('/{post_id}',[LikeController::class,'like'])->name('post.like');
    Route::post('/{post_id}',[LikeController::class,'unlike'])->name('post.unlike');
})->middleware('auth');
Route::get("/@{username}",[PublicProfileController::class,'show'])->name('user.profile');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';