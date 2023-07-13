<?php

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

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//rutas post
Route::get('/posts', [App\Http\Controllers\PostController::class, 'posts']);
Route::get('/post', [App\Http\Controllers\PostController::class, 'getPosts']);
Route::get('/post/{user_id}', [App\Http\Controllers\PostController::class, 'index']);
Route::get('/posts/{user_id}', [App\Http\Controllers\PostController::class, 'getPostsFromUser']);
Route::post('/post', [App\Http\Controllers\PostController::class, 'create']);
Route::put('/post/{id}', [App\Http\Controllers\PostController::class, 'update']);
Route::delete('/post/{id}', [App\Http\Controllers\PostController::class, 'delete']);
//rutas users
Route::get('/user', [App\Http\Controllers\UserController::class, 'getUsers']);
Route::post('/user', [App\Http\Controllers\UserController::class, 'create']);
Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update']);
Route::delete('/user/{id}', [App\Http\Controllers\UserController::class, 'delete']);




