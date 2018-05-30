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
            'valor' => 0,
            'produto' => new ProdutoResource($resource->produto),
            'admin' => new AdministradorResource($resource->administrador)
        ];

        return $data;
    }
}
