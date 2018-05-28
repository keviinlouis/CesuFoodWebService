<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 27/05/2018
 * Time: 01:30
 */

namespace App\Validators;

use App\Entities\Produto;
use App\Rules\RuleFileExistsOnTmp;
use Illuminate\Validation\Rule;


/**
 * Class ProdutoRules
 * @package App\Validators
 */
class ProdutoRules
{

    /**
     * Regras para criação de Produto
     * @return array
     */
    static public function store(): array
    {
        return [
            'nome' => 'required|string|min:3',
            'valor' => 'required|numeric|not_in:0',
            'descricao' => 'required|string|min:10',
            'categoria_id' => 'required|exists:categorias,id',
            'status' => 'required|between:0,1',
            'fotos' => 'required|array|min:1',
            'fotos.*' => ['required', new RuleFileExistsOnTmp()],
        ];
    }

    /**
     * Regras para alteração de Produto
     * @return array
     */
    static public function update(): array
    {
        return [
            'nome' => 'string|min:3',
            'valor' => 'numeric|not_in:0',
            'descricao' => 'string|min:10',
            'categoria_id' => 'exists:categorias,id',
            'status' => 'between:0,1',
            'fotos_removidas' => 'array',
            'fotos_adicionadas' => 'array',
            'fotos_adicionadas.*' => ['required', new RuleFileExistsOnTmp()],
        ];
    }
}
