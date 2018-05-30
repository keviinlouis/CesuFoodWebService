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


use App\Entities\Cliente;

class ClienteResource extends Resource
{
    public function __construct($resource, $withToken = false)
    {
        parent::__construct($resource);
        $this->withToken = $withToken;
    }

    /**
     * @param Cliente $resource
     * @return array
     */
    public function toResource($resource)
    {
        $data = [
            'id' => $resource->getKey(),
            'email' => $resource->email,
            'ra' => $resource->ra,
            'foto_perfil' => $resource->url_foto_perfil_thumb,
            'created_at' => $resource->created_at->toDateTimeString()
        ];

        if(auth()->check() && auth()->user()->isAdmin()){
            $data['status'] = $resource->status;
            $data['status_label'] = $resource->status_label;
        }

        return $data;
    }
}
