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

Route::get('/home','TodoListController@show');
Route::get('delete/{id}','TodoListController@destroy');

Route::get('todo/create','TodoListController@create');
Route::post('submit','TodoListController@store');

Route::get('todo/edit/{id}','TodoListController@edit');
Route::post('update/{id}','TodoListController@update')->name('todo.update');

Route::get('/home','TodoListController@list');
Route::get('/data','TodoListController@listView')->name('todo.list');

Route::get('complete/{id}','TodoListController@complete');