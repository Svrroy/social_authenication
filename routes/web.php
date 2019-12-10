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
Route::get('login/Facebook', 'Auth\LoginController@redirectToProviderFacebook');
Route::get('login/Facebook/callback', 'Auth\LoginController@handleProviderCallbackFacebook');
Route::get('login/google', 'Auth\LoginController@redirectToProviderGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallbackGoogle');
Route::post('/submit','SubmitController@store');
Route::get('/form', function () {
    return view('form');
});