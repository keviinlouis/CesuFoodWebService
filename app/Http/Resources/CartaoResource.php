<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 30/05/2018
 * Time: 00:10
 */

namespace App\Http\Resources;


use App\Entities\Cartao;

class CartaoResource extends Resource
{
    /**
     * @param Cartao $resource
     * @return array
     */
    public function toResource($resource)
    {
        $data = [
            'id' => $resource->getKey(),
            'hash' => $resource->hash,
            'bandeira' => $resource->bandeira,
            'ultimos_digitos' => $resource->ultimos_digitos,
            'nome_completo' => $resource->nome_completo,
            'data_expiracao' => $resource->data_expiracao
        ];

        return $data;
    }
}
