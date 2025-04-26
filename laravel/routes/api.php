<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\AuthController;

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

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Authors - Client can only view, Manager/Admin can do full CRUD
    Route::middleware('role:Manager,Admin')->group(function () {
        Route::apiResource('/authors', AuthorController::class)->except(['index', 'show']);
    });
    Route::middleware('role:Client,Manager,Admin')->group(function () {
        Route::get('/authors', [AuthorController::class, 'index']);
        Route::get('/authors/{author}', [AuthorController::class, 'show']);
    });

    // Books - same rules as authors
    Route::middleware('role:Manager,Admin')->group(function () {
        Route::apiResource('/books', BookController::class)->except(['index', 'show']);
    });
    Route::middleware('role:Client,Manager,Admin')->group(function () {
        Route::get('/books', [BookController::class, 'index']);
        Route::get('/books/{book}', [BookController::class, 'show']);
    });

    // Readers - only Manager/Admin
    Route::middleware('role:Manager,Admin')->group(function () {
        Route::apiResource('/readers', ReaderController::class);
    });

    // Issues - Client can only create/view own, Manager/Admin full CRUD
    Route::middleware('role:Manager,Admin')->group(function () {
        Route::apiResource('/issues', IssueController::class);
    });
    Route::middleware('role:Client')->group(function () {
        Route::get('/issues', [IssueController::class, 'index']);
        Route::post('/issues', [IssueController::class, 'store']);
    });

    // Returns - same as issues
    Route::middleware('role:Manager,Admin')->group(function () {
        Route::apiResource('/returns', ReturnController::class);
    });
    Route::middleware('role:Client')->group(function () {
        Route::get('/returns', [ReturnController::class, 'index']);
        Route::post('/returns', [ReturnController::class, 'store']);
    });
});
