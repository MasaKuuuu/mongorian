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

// コレクションの全データ取得
Route::get('/getAll','GetDataController@getAll');

// コレクション内のデータ取得
Route::get('/getSelect','GetDataController@getSelect');

// CSVデータの登録
Route::post('/postCSV','UploadController@postCSV');

// データの更新
Route::post('/update','UploadController@postCSV');