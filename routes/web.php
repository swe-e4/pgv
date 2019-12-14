<?php

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
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/login', function(){
    return view('pages.login');
})->name('login');

Route::get('/logout', function(){
    Auth::logout();
})->name('logout');

Route::get('/{any}', 'AppController@index')->where('any', '.*');