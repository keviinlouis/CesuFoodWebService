<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:28
 */

namespace App\Validators;

use App\Entities\Administrador;
use Illuminate\Validation\Rule;


/**
 * Class AdministradorRules
 * @package App\Validators
 */
class AdministradorRules
{
    /**
     * @return array
     */
    static public function login(): array
    {
        return [

            'email' => 'required|string|exists:' . (new Administrador)->getTable(),
            'senha' => 'required|string',
        ];
    }

    /**
     * Regras para criação de Administrador
     * @return array
     */
    static public function store(): array
    {
        return [
            //TODO Implementar store
        ];
    }

    /**
     * Regras para alteração de Administrador
     * @return array
     */
    static public function update(): array
    {
        return [
            //TODO Implementar update
        ];
    }
}
