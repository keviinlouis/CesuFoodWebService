<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('uploadTmp', 'ArquivoController@uploadTmp')->name('upload.tmp');
Route::delete('removeTmp/{arquivo}', 'ArquivoController@removeTmp')->name('remove.tmp');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::post('moip/webhook', 'MoipController@webhook')->name("moip.webhook");
