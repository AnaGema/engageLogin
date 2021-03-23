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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', '\App\Http\Controllers\ProfileController@show')->name('home');
});
Route::get('/edit', '\App\Http\Controllers\ProfileController@edit');
Route::post('/update', '\App\Http\Controllers\ProfileController@update')->name('update');
Route::get('/editUserRole/{id}', '\App\Http\Controllers\ProfileController@editUserRole');
Route::post('/updateUserRole', '\App\Http\Controllers\ProfileController@updateUserRole')->name('updateUserRole');


Route::get('/', function () {
    return redirect('/home');
});

