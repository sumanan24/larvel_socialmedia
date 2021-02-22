<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'postcontroller@index');
Route::POST('createpost','postcontroller@store');
Route::get('post', 'postcontroller@index');
Route::get('like', 'likecontroller@store');
Route::get('unlike{id}', 'likecontroller@destroy');
Route::get('delete{id}', 'postcontroller@destroy');    


