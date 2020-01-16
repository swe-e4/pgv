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

Route::post('/api/changepassword', 'ChangePasswordController@store');
Route::post('/api/sendmail', 'GroupController@mail');
Route::post('/api/adviser/import', 'AdviserController@import');
Route::post('/api/student/import', 'StudentController@import');
Route::get('/{any}', 'AppController@index')->where('any', '.*');