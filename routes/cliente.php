<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:31
 */

Route::post('login', 'ClienteController@login');
Route::post('cadastro', 'ClienteController@store');

Route::group(['middleware' => 'jwt:cliente'], function(){
    Route::get('me', 'ClienteController@me');

    Route::put('me', 'ClienteController@update');
    Route::delete('me', 'ClienteController@destroy');

    Route::get('me/produto', 'ProdutoController@meusProdutos');
    Route::get('me/produto/{id}', 'ProdutoController@meuProduto');
    Route::get('produto', 'ProdutoController@index');
    Route::get('produto/{id}', 'ProdutoController@show');
    Route::post('produto/{id}', 'ProdutoController@toogleFavoritar');

    Route::get('pedido-aberto', 'PedidoController@pedidoAtual');

    Route::get('pedido', 'PedidoController@index');
    Route::get('pedido/{id}', 'PedidoController@show');
    Route::post('pedido/finalizar', 'PedidoController@finalizar');
    Route::post('pedido/adicionar/{id}', 'PedidoController@adicionarProduto');
    Route::delete('pedido/remover/{id}', 'PedidoController@removerProduto');
    Route::put('pedido/{id}', 'PedidoController@update');

    Route::apiResource('cartao', 'CartaoController');

    Route::get('categoria', 'CategoriaController@index');
});
