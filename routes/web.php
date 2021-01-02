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
Route::get('/custor-register', 'RegisterController@register')->name('custom-register');
Route::post('/custor-register-create', 'RegisterController@registerCreate')->name('custom-register-create');
Route::resource('/question', 'QuestionController');


Route::get('admin/dashboard', 'AdminDashboardController@index')->name('index');
