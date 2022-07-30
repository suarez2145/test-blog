<?php

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
})->name('welcome-page');

Route::get('/logout',[\App\Http\Controllers\LogoutController::class, 'perform'])->name('logout');
// retrieves/shows all the blog post  at /blog 
Route::get('/blog', [\App\Http\Controllers\BlogPostController::class, 'index']);
Route::get('/blog/profile', [\App\Http\Controllers\UserDetailsController::class, 'profile'])->name('profile');
Route::get('/blog/cards', [\App\Http\Controllers\BlogPostController::class, 'cards'])->name('cards-view')->middleware('auth'); // get the blog cards view 
Route::get('/blog/cards/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'show'])->name('post-view')->middleware('auth'); // retrieves only 1 post at a time 

// Route::get('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'show']); // retrieves only 1 post at a time 
Route::get('/blog/create/post', [\App\Http\Controllers\BlogPostController::class, 'create'])->name('create-page')->middleware('auth'); //shows create post form
Route::post('/blog/create/post', [\App\Http\Controllers\BlogPostController::class, 'store'])->middleware('auth'); //saves the created post to the databse
Route::post('/blog/{id}/comment-create', [\App\Http\Controllers\BlogPostController::class, 'save'])->name('create-comment')->middleware('auth'); //saves the created post to the databse
Route::get('/blog/{blogPost}/edit', [\App\Http\Controllers\BlogPostController::class, 'edit'])->middleware('auth'); //shows edit post form
Route::put('/blog/{blogPost}/edit', [\App\Http\Controllers\BlogPostController::class, 'update'])->middleware('auth'); //commits edited post to the database 
Route::delete('/blog/cards/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'destroy'])->middleware('auth'); //deletes post from the database