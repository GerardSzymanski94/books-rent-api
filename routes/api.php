<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ClientController;

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

Route::name('books.')->prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::get('/search/{query}', [BookController::class, 'search']);
    Route::post('/rent', [BookController::class, 'rent']);
    Route::get('/return/{book_id}', [BookController::class, 'return']);
});

Route::name('clients.')->prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index']);
    Route::get('/{client}', [ClientController::class, 'show']);
    Route::post('/', [ClientController::class, 'store']);
    Route::put('/{client}', [ClientController::class, 'update']);
    Route::delete('/{client}', [ClientController::class, 'destroy']);
});

