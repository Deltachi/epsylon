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

Route::get('/', 'TaskController@index')->name('task.index');
Route::get('/task', 'TaskController@index')->name('task.index');
Route::get('/task/{id}', 'TaskController@show')->name('task.show');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/klausur','ExamController@index')->name('exam.index');
Route::get('/klausur/{id}','ExamController@show')->name('exam.show');


/* REST-API für die Task-Frontend-Komponente */
Route::get('/answer/{user_id}/{exam_id}/{task_id}', 'AnswerController@show')->name('answer.show');
Route::post('/answer', 'AnswerController@store')->name('answer.store');
Route::delete('/answer', 'AnswerController@destroy')->name('answer.destroy');
