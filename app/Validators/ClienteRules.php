<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:29
 */

namespace App\Validators;

use App\Entities\Cliente;
use Illuminate\Validation\Rule;


/**
 * Class ClienteRules
 * @package App\Validators
 */
class ClienteRules
{
    /**
     * @return array
     */
    static public function login(): array
    {
        return [

            'email' => 'required|string|exists:' . (new Cliente)->getTable(),
            'senha' => 'required|string',
        ];
    }

    /**
     * Regras para criação de Cliente
     * @return array
     */
    static public function store(): array
    {
        return [
            //TODO Implementar store
        ];
    }

    /**
     * Regras para alteração de Cliente
     * @return array
     */
    static public function update(): array
    {
        return [
            //TODO Implementar update
        ];
    }
}
