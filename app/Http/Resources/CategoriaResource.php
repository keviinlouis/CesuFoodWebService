<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 27/05/2018
 * Time: 01:56
 */

namespace App\Http\Resources;


use App\Entities\Categoria;

class CategoriaResource extends Resource
{
    /**
     * @param Categoria $resource
     * @return array
     */
    public function toResource($resource)
    {
        $data =[
            'id' => $resource->getKey(),
            'nome' => $resource->nome
        ];

        return $data;
    }
}
