<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\userController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
  

});
////////////user////////////
Route::controller(userController::class)->group(function () {
    Route::get('profile', 'index')->middleware('auth:api');
    Route::post('updateprofile', 'update')->middleware('auth:api');});

/////////////////////////////////////////////////////////
Route::controller(BookController::class)->group(function () {
Route::post('addbook', 'store')->middleware('is_admin');
Route::get('books', 'index');
Route::get('book/{book}', 'show');
Route::delete('book/{book}/delete', 'destroy')->middleware('is_admin');});


/////////////////Author///////////////////////
Route::controller(AuthorController::class)->group(function () {
    Route::get('authors', 'index');
    Route::get('author/{author}', 'show');
    Route::post('author-create', 'store')->middleware('is_admin');
    Route::put('author/{author}/update', 'update')->middleware('is_admin');
    Route::delete('author/{author}/delete', 'destroy')->middleware('is_admin');});
