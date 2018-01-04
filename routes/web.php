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

Route::get('/comecando', 'feedsController@gerenciarXML');
Route::post('/comecando', 'feedsController@upload');

Route::post('/criando', 'feedsController@criando');
Route::get('/criando', 'feedsController@carregarCanais');

Route::get('/gerenciar', 'feedsController@gerenciarXML');



