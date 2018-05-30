<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 29/05/2018
 * Time: 21:49
 */

namespace App\Validators;

use App\Entities\Pedido;
use Illuminate\Validation\Rule;


/**
 * Class PedidoRules
 * @package App\Validators
 */
class PedidoRules
{

    /**
     * Regras para criação de Pedido
     * @return array
     */
    static public function store(): array
    {
        return [
            //TODO Implementar store
        ];
    }

    /**
     * Regras para alteração de Pedido
     * @return array
     */
    static public function update(): array
    {
        return [
            //TODO Implementar update
        ];
    }
}
