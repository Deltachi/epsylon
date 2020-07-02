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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/task', 'TaskController@index')->name('task.index');
Route::get('/task/{id}', 'TaskController@show')->name('task.show');
Route::delete('/task', 'TaskController@destroy')->name('task.destroy');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/action', 'HomeController@action')->name('user.action');

Route::post('/subject', 'SubjectController@store')->name('subject.store');

//Klausur lösen
Route::get('/klausur','ExamController@index')->name('exam.index');
Route::get('/exam','ExamController@index')->name('exam.index');
Route::post('/exam','ExamController@store')->name('exam.store');
Route::get('/exam/{id}','ExamController@show')->name('exam.show');

//Übersicht des Moduls
Route::get('/exam/edit/{subject}','ExamEditController@index')->name('exam.edit.index');
Route::get('/exam/edit/{subject}/{exam}','ExamEditController@show')->name('exam.edit.show');
Route::post('exam/edit/status','ExamEditController@updateStatus')->name('exam.edit.status.update');

//Exam Editor
Route::get('/new_exam/{subject}','ExamEditController@newExam')->name('exam.new');
Route::get('/edit_exam/{exam}','ExamEditController@editExam')->name('exam.edit');
Route::post('/edit_exam/','ExamEditController@saveExam')->name('exam.save');
Route::delete('/edit_exam/','ExamEditController@destroy')->name('exam.destroy');

//Exam Corrector
Route::get('/exam/correct/{subject}','ExamCorrectorController@index')->name('exam.correct.index');
Route::get('/exam/correct/{subject}/{exam}','ExamCorrectorController@show')->name('exam.correct.show');


/* REST-API für die Task-Frontend-Komponente */
Route::get('/answer/{user_id}/{exam_id}/{task_id}', 'AnswerController@show')->name('answer.show');
Route::post('/answer', 'AnswerController@store')->name('answer.store');
Route::delete('/answer', 'AnswerController@destroy')->name('answer.destroy');
