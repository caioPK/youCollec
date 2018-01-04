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

Route::get('/comecando', 'feedsController@enviarXML');
Route::post('/comecando', 'feedsController@upload');


Route::get('/gerenciar', 'feedsController@carregarCanais');
Route::post('/gerenciar', 'feedsController@criando');

Route::get('alimentarFeed', 'feedsController@alimentandoFeed')->name('alimentar');


