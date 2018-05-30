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
     * @var bool
     */
    private $withQrCode;

    /**
     * ClientesProdutoResource constructor.
     * @param $resource
     * @param bool $withQrCode
     */
    public function __construct($resource, $withQrCode = false)
    {
        parent::__construct($resource);
        $this->withQrCode = $withQrCode;
    }

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
            'produto' => new ProdutoResource($resource->produto),
            'admin' => new AdministradorResource($resource->administrador)
        ];

        if($this->withQrCode){
            $data['qr_code'] = $resource->gerarQrCode();
        }

        return $data;
    }
}
