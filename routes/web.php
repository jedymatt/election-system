<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/vote', 'UserVoteController@index')->name('vote');

Route::middleware('auth')->group(function () {
    Route::resource('/student', 'StudentController');
    Route::resource('/admin', 'AdminController');
    Route::resource('/admin/election/position', 'PositionController');
    Route::resource('/election', 'ElectionController');
    Route::resource('/election/{election}/candidates', 'CandidateController');
    Route::resource('/election/{election}/vote', 'UserVoteController');
});

Route::get('/result', 'ResultController@index')->name('result.index');
Route::get('/result/{election}', 'ResultController@show')->name('result.show');

//Route::get('test', 'TestController@index');

