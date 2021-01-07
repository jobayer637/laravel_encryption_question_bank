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




Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', 'AdminDashboardController@index')->name('index');
    Route::resource('question', 'AdminQuestionController');
    Route::resource('subject', 'AdminSubjectController');
    Route::resource('users', 'AdminUserController');
    Route::resource('institutes', 'AdminInstituteController');
    Route::resource('board', 'AdminBoardController');
    Route::resource('department', 'AdminDepartmentController');
});

Route::group(['as' => 'author.', 'prefix' => 'author', 'middleware' => ['auth', 'author']], function () {
    Route::get('dashboard', 'AuthorDashboardController@index')->name('index');
    Route::resource('question', 'AuthorQuestionController');
});

Route::group(['as' => 'moderator.', 'prefix' => 'moderator', 'middleware' => ['auth', 'moderator']], function () {
    Route::get('dashboard', 'ModeratorDashboardController@index')->name('index');
});
