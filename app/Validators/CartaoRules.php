<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 30/05/2018
 * Time: 00:12
 */

namespace App\Validators;

use App\Entities\Cartao;
use App\Rules\RuleNomeCompleto;
use Illuminate\Validation\Rule;


/**
 * Class CartaoRules
 * @package App\Validators
 */
class CartaoRules
{

    /**
     * Regras para criação de Cartao
     * @return array
     */
    static public function store(): array
    {
        return [
            'hash' => 'required|string',
            'bandeira' => 'required|string',
            'ultimos_digitos' => 'required|string',
            'nome_completo' => ['required', new RuleNomeCompleto()],
            'data_expiracao' => ['required', 'date_format:"m-y'],
            'cliente_id' => 'required|exists:clientes,id'
        ];
    }

    /**
     * Regras para alteração de Cartao
     * @return array
     */
    static public function update(): array
    {
        return [
            //TODO Implementar update
        ];
    }
}
