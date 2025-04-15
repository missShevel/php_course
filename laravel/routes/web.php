<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\CatController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TestController::class, 'test']);

Route::get('cats', [CatController::class, 'getAll']);
Route::get('cats/{id}', [CatController::class, 'getById']);
Route::post('cats', [CatController::class, 'create']);
Route::put('cats/{id}', [CatController::class, 'update']);
Route::delete('cats/{id}', [CatController::class, 'delete']);