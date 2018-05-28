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
    return view('login');
});

Route::post('/login', 'LoginController@login');
Route::get('/home', 'HomeController@index');
Route::get('/inbox', 'HomeController@inbox');
Route::get('/logout', 'LoginController@logout');
Route::get('/settings', 'SettingsController@index');
Route::post('/settings', 'SettingsController@saveSettings');
Route::get('/calendar', 'CalendarController@index');
Route::post('/getSchedules', 'CalendarController@getSchedules');
Route::get('/projects', 'ProjectsController@index');