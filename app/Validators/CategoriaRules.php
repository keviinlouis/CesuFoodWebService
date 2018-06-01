<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 27/05/2018
 * Time: 02:12
 */

namespace App\Validators;

use App\Entities\Categoria;
use Illuminate\Validation\Rule;


/**
 * Class CategoriaRules
 * @package App\Validators
 */
class CategoriaRules
{

    /**
     * Regras para criação de Categoria
     * @return array
     */
    static public function store(): array
    {
        return [
            'nome' => 'required|string|min:3'
        ];
    }

    /**
     * Regras para alteração de Categoria
     * @return array
     */
    static public function update(): array
    {
        return [
            'nome' => 'required|string|min:3'
        ];
    }
}
