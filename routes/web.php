<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home',[HomeController::class,'store']);
Route::delete('/home/{id}',[HomeController::class,'destroy'])->name('destroy');
Route::get('/home/{id}',[HomeController::class,'edit']);
Route::put('/home/{id}',[HomeController::class,'update']);
