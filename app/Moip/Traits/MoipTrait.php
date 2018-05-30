<?php
/**
 * Created by PhpStorm.
 * User: DevMaker BackEnd
 * Date: 18/05/2018
 * Time: 15:43
 */

namespace App\Moip\Traits;


trait MoipTrait
{
    /**
     * @param $status
     * @return int|null
     */
    static public function moipStatusToVendaStatus($status)
    {
        switch ($status) {
            case 'CREATED':
                return self::AGUARDANDO_PAGAMENTO;
                break;
            case 'WAITING':
                return self::AGUARDANDO_PAGAMENTO;
                break;
            case 'IN_ANALYSIS':
                return self::AGUARDANDO_PAGAMENTO;
                break;
            case 'PRE_AUTHORIZED':
                return self::FINALIZADO;
                break;
            case 'AUTHORIZED':
                return self::FINALIZADO;
                break;
            case 'CANCELLED':
                return self::CANCELADO;
                break;
            case 'REFUNDED':
                return self::REEMBOLSADO;
                break;
            case 'SETTLED':
                return self::FINALIZADO;
                break;
            case 'REVERSED':
                return self::ESTORNO;
                break;
            default:
                return null;
        }
    }

    /**
     * @param $evento
     * @return bool
     */
    static public function isPago($evento)
    {
        return in_array($evento, [
                self::FINALIZADO
            ]) !== false;
    }

    /**
     * @param $evento
     * @return bool
     */
    static public function isRecusado($evento)
    {
        return in_array($evento, [
                self::ESTORNO, self::REEMBOLSADO, self::CANCELADO
            ]) !== false;
    }
}
