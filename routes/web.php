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


Route::get('/', 'Home2Controller@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home2');
Route::get('/search', 'Home2Controller@search');

Route::get('/user', 'UsersController@index');

Route::resource('/series', 'SeriesController');
Route::get('/series/follow/{get}', 'SeriesController@follow');
Route::get('/series/unfollow/{get}', 'SeriesController@unfollow');
Route::resource('/episodes', 'EpisodeController');
Route::get('/episodes/like/{get}', 'EpisodeController@like');
Route::get('/episodes/dislike/{get}', 'EpisodeController@dislike');
