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
});


Route::get('/', 'App\Http\Controllers\WordController@show')->name('word.show');
Route::post('/enter', 'App\Http\Controllers\WordController@enter')->name('word.enter');
Route::get('/clear', 'App\Http\Controllers\WordController@clear')->name('word.clear');
