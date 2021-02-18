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

Route::get('/home',                     'HomeController@index')->name('home');
Route::get('/custor-register',          'RegisterController@register')->name('custom-register');
Route::post('/custor-register-create',  'RegisterController@registerCreate')->name('custom-register-create');
// Route::resource('/question',            'QuestionController');

Route::resource('notice', 'NoticeController');


Route::get('generate-pdf', 'PDFController@generatePDF')->name('pdf');


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard',             'AdminDashboardController@index')->name('index');
    Route::resource('profile',          'AdminProfileController');
    Route::get('permission',            'AdminPermissionController@index')->name('permission.index');
    Route::post('permission/update',    'AdminPermissionController@update')->name('permission.update');
    Route::resource('question',         'AdminQuestionController');
    Route::resource('subject',          'AdminSubjectController');
    Route::resource('users',            'AdminUserController');
    Route::resource('moderators',       'ModeratorController');
    Route::resource('pending-users',    'PendingUserController');
    Route::resource('institutes',       'AdminInstituteController');
    Route::resource('board',            'AdminBoardController');
    Route::resource('department',       'AdminDepartmentController');
    Route::resource('notice',           'NoticeController');
    Route::get('districts',             'AdminAjaxController@districts')->name('districts');
    Route::get('upazilas',              'AdminAjaxController@upazilas')->name('upazilas');
    Route::get('unions',                'AdminAjaxController@unions')->name('unions');
});

Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']], function () {
    Route::get('dashboard',             'AuthorDashboardController@index')->name('index');
    Route::resource('profile',          'AuthorProfileController');
    Route::resource('question',         'AuthorQuestionController');
    Route::resource('notice',           'NoticeController');
});

Route::group(['as' => 'moderator.', 'prefix' => 'moderator', 'namespace' => 'Moderator', 'middleware' => ['auth', 'moderator']], function () {
    Route::get('dashboard',             'ModeratorDashboardController@index')->name('index');
    Route::resource('profile',          'ModeratorProfileController');
    Route::resource('subject',          'ModeratorSubjectController');
    Route::resource('question',         'ModeratorQuestionController');
    Route::resource('institutes',       'InstituteController');
    Route::resource('notice',           'NoticeController');
});
