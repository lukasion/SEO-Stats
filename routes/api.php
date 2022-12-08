<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PhraseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/', [UserController::class, 'index']);
});

Route::group(['prefix' => 'customers', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/', [CustomerController::class, 'list']);
});

Route::group(['prefix' => 'customer', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/{customerID}', [CustomerController::class, 'detail']);

    Route::group(['prefix' => '/{customerID}'], function() {
        Route::post('/phrase', [CustomerController::class, 'phraseAdd']);
        Route::group(['prefix' => '/phrase'], function() {
            Route::delete('/{phraseID}', [PhraseController::class, 'phraseDelete']);
            Route::get('/{phraseID}', [PhraseController::class, 'detail']);
            Route::put('/{phraseID}', [PhraseController::class, 'edit']);
        });
    });
});
