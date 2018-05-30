<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 30/05/2018
 * Time: 00:01
 */

namespace App\Observers;


use App\Entities\ClientesProduto;
use App\Entities\Pedido;

class PedidoObserver extends Observer
{
    public function updated(Pedido $pedido)
    {
        if($this->isNotEqual('status', $pedido)){
            switch($pedido->status){
                case Pedido::AGUARDANDO_PAGAMENTO:
                    $pedido->clientesProdutos->each(function (ClientesProduto $clientesProduto) {
                        $clientesProduto->update(['status' => ClientesProduto::RESERVADO]);
                    });
                    break;
                case Pedido::FINALIZADO:

                    break;
            }
        }
    }
}
