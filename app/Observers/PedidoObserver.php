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
                    $this->notificarClienteAguardandoPagamento($pedido);
                    break;
                case Pedido::FINALIZADO:
                    $this->notificarClientePagamentoAutorizado($pedido);
                    break;
                case Pedido::CANCELADO:
                    $this->notificarClientePagamentoNaoAutorizado($pedido);
                    break;
            }
        }
    }

    private function notificarClienteAguardandoPagamento(Pedido $pedido)
    {
        //TODO Notificar cliente sobre o novo pagamento que será gerado
    }

    private function notificarClientePagamentoAutorizado(Pedido $pedido)
    {
        //TODO Notificar cliente sobre a retirada dos produtos e do pagamento autorizado
    }

    private function notificarClientePagamentoNaoAutorizado(Pedido $pedido)
    {
        //TODO Notificar Cliente sobre o pagamento não autorizado
    }
}
