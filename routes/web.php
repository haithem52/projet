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



Route::get('/user/login','ClassroomController@showLogin')->name('showLogin');
Route::post('/user/login','ClassroomController@handleLogin')->name('handleLogin');





Route::middleware(['access'])->group(function () {

Route::get('/', function () {
    return view('welcome');
});
Route::post('/add', 'ClassroomController@handleAddClassroom')->name('handleAddClassroom');
Route::get('/delete/{id}', 'ClassroomController@handleDeleteClassroom')->name('handleDeleteClassroom');
Route::get('/list', 'ClassroomController@listClassroom')->name('listClassroom');
Route::get('/show/{id}', 'ClassroomController@showClassroom')->name('showClassroom');
Route::post('/update/{identif}', 'ClassroomController@handleUpdateClassroom')->name('handleUpdateClassroom');
Route::get('/user/register','ClassroomController@showRegister')->name('showRegister');
Route::post('/user/register','ClassroomController@handleRegister')->name('handleRegister');
	Route::get('/user/logout','ClassroomController@handleLogout')->name('handleLogout');

Route::get('/user/showStudent{id}','ClassroomController@showStudent')->name('showStudent');
Route::get('/remove/{id}', 'ClassroomController@handleDeleteStudent')->name('handleDeleteStudent');

});