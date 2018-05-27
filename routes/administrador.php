<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:31
 */

Route::post('login', 'AdministradorController@login');

Route::group(['middleware' => 'jwt:admin'], function(){
    Route::get('me', 'AdministradorController@me');

    Route::apiResource('produto', 'ProdutoController');
    Route::apiResource('categoria', 'CategoriaController');
});
