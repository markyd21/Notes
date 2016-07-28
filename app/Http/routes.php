<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('home', ['as'=>'notes_home', 'uses'=>'NotesController@index']);
Route::get('home_page','NotesController@index');
Route::post('get_friends', 'FriendController@index');
Route::post('share_note', 'NotesController@share');
Route::post('/home', array('uses' => 'NotesController@store'));
Route::post('/home/deleteNote', 'NotesController@remove');
Route::post('/home/restoreNote', 'NotesController@restore');
