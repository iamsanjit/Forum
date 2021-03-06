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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::post('/threads', 'ThreadsController@store')->name('threads.store');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::delete('/threads/{thread}', 'ThreadsController@destroy');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('replies.store');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.patch');


Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');


Route::get('profiles/{user}', 'ProfilesController@show');
