<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 28/03/2018
 * Time: 14:20
 */

namespace App\Http\Controllers\Utils;


use App\Entities\Pedido;
use App\Http\Requests\Request;
use Log;

class MoipController
{
    CONST PAYMENT = 'PAYMENT';

    /**
     * @param Request $request
     */
    public function webhook(Request $request)
    {

        Log::channel('moip')->info('Atualização Moip');
        $data = $request->toArray();

        list($tipo, $evento) = explode('.', $data['event']);

        Log::channel('moip')->info('Evento Moip: '.$evento.' Tipo: '.$tipo);

        $evento = Pedido::moipStatusToVendaStatus($evento);

        Log::channel('moip')->info('Evento Sistema: '.$evento);

        if($tipo == self::PAYMENT){
           $this->updatePagamento($data['resource']['payment']['id'], $evento);
        }
    }

    public function updatePagamento($id, $evento)
    {
        $pedido = Pedido::wherePagamentoId($id)->first();

        if(!$pedido){
            Log::channel('moip')->error('Pagamento ID '.$id.' não encontrado');
            return;
        }

        $pedido->update(['status' => $evento]);
    }

}
