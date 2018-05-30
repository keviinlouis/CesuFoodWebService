<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 30/05/2018
 * Time: 00:33
 */

namespace App\Observers;


use App\Entities\ClientesProduto;
use Illuminate\Support\Str;

class ClientesProdutoObserver extends Observer
{
    public function creating(ClientesProduto $clientesProduto)
    {
        $clientesProduto->hash = Str::uuid();
    }

    /**
     * @param ClientesProduto $clientesProduto
     * @throws \LaravelQRCode\Exceptions\EmptyTextException
     * @throws \LaravelQRCode\Exceptions\MalformedUrlException
     */
    public function updated(ClientesProduto $clientesProduto)
    {
        if($this->isNotEqual('status', $clientesProduto)){
            switch ($clientesProduto->status) {
                case ClientesProduto::AGUARDANDO_FECHAMENTO:

                    break;
                case ClientesProduto::RESERVADO:

                    break;
                case ClientesProduto::AGUARDANDO_RETIRADA:
                    $clientesProduto->gerarQrCode();
                    break;
                case ClientesProduto::FINALIZADO:
                    $this->notificarClienteSobreRetiradaDoProduto($clientesProduto);
                    break;
            }
        }
    }

    private function notificarClienteSobreRetiradaDoProduto(ClientesProduto $clientesProduto)
    {
        //TODO Notificar Cliente sobre as informações da retirada do produto
    }
}
