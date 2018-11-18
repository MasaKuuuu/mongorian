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

//Route::get('/', function () {
//    return view('welcome');
//});

// トップページの表示
Route::get('/','IndexController@index');

// データの受け取り
Route::post('/getData','GetDataController@get');

// CSVデータの登録
Route::post('/postCSV','UploadController@postCSV');