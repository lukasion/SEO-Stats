<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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
// Auth::routes();
Route::post('user/login', [LoginController::class, 'login']);
Route::get('user/logout', [LoginController::class, 'logout']);

Route::get('/{params?}', function () {
    return view('welcome');
})->where('params', '(.*)')->name('vue-panel');