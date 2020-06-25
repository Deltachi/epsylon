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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', 'TasksController@index')->name('tasks');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/task/{id}', 'TasksController@show')->name('task.show');
Route::get('/tasks', 'TasksController@index')->name('tasks');

Route::get('/answer/{user_id}/{exam_id}/{task_id}', 'AnswersController@show')->name('task.show');
Route::post('/answer', 'AnswersController@store')->name('task.store');
Route::delete('/answer', 'AnswersController@destroy')->name('task.destroy');
