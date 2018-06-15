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
use App\Rules\RuleFileExistsOnTmp;
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

            'ra' => 'required|string|exists:' . (new Cliente)->getTable(),
            'senha' => 'required|string',
        ];
    }

    /**
     * Regras para criação de ClienteController
     * @return array
     */
    static public function store(): array
    {
        return [
            'email' => 'required|unique:clientes|email',
            'ra' => 'required|digits:8',
            'senha' => 'required|min:6|string',
            'foto_perfil' => ['string', new RuleFileExistsOnTmp()]
        ];
    }

    /**
     * Regras para alteração de ClienteController
     * @return array
     */
    static public function update(): array
    {
        return [
            'senha' => 'required_with:nova_senha|min:6|string',
            'nova_senha' => 'required_with:senha|min:6|string',
            'foto_perfil' => ['string', new RuleFileExistsOnTmp()]

        ];
    }
}
