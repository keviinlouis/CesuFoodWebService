<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:31
 */

Route::post('login', 'ClienteController@login');

Route::group(['middleware' => 'jwt:cliente'], function(){

});
