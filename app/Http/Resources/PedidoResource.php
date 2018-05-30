<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 29/05/2018
 * Time: 21:48
 */

namespace App\Http\Resources;


use App\Entities\Pedido;

class PedidoResource extends Resource
{
    /**
     * @param Pedido $resource
     * @return array
     */
    public function toResource($resource)
    {
        $data = [
            'id' => $resource->getKey(),
            'status' => $resource->status,
            'status_label' => $resource->status_label,
            'cliente' => new ClienteResource($resource->cliente),
            'produtos' => new ClientesProdutoResource($resource->clientesProdutos),
            'cartao' => new CartaoResource($resource->cartao)
        ];

        return $data;
    }
}
