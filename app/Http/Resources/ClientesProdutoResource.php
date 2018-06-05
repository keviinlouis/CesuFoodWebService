<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 29/05/2018
 * Time: 23:46
 */

namespace App\Http\Resources;


use App\Entities\ClientesProduto;

class ClientesProdutoResource extends Resource
{
    /**
     * @param ClientesProduto $resource
     * @return array
     */
    public function toResource($resource)
    {
        $data = [
            'id' => $resource->getKey(),
            'valor' => $resource->valor,
            'status' => $resource->status,
            'status_label' => $resource->status_label,
            'hash' => $resource->hash,
            'produto' => new ProdutoResource($resource->produto),
            'admin' => new AdministradorResource($resource->administrador),
            'url_qr_code' => $resource->url_qr_code,
            'cliente' => new ClienteResource($resource->cliente)
        ];

        return $data;
    }
}
