<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:30
 */

namespace App\Http\Resources;


use App\Entities\Administrador;

class AdministradorResource extends Resource
{
    public function __construct($resource, $withToken = false)
    {
        parent::__construct($resource);
        $this->withToken = $withToken;
    }

    /**
     * @param Administrador $resource
     * @return array
     */
    public function toResource($resource)
    {
        $data = [
            'id' => $resource->getKey(),
            'nome' => $resource->nome,
            'email' => $resource->email,
            'cargo' => $resource->cargo,
            'is_master' => $resource->isMaster()
        ];

        return $data;
    }
}
