<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 29/05/2018
 * Time: 21:45
 */

namespace App\Http\Controllers\Cliente;

use App\Entities\Produto;
use App\Http\Resources\ClientesProdutoResource;
use App\Http\Resources\ProdutoResource;
use App\Services\ProdutoService;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;

class ProdutoController extends Controller
{
    private $produtoService;

    /**
     * ProdutoController constructor.
     * @param ProdutoService $produtoService
     */
    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ProdutoResource
     * @throws \Exception
     */
    public function index(Request $request): ProdutoResource
    {
        $data = $request->toCollection();
        $data['status'] = Produto::ATIVO;

        $model = $this->produtoService->index($data);

        return new ProdutoResource($model);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return ProdutoResource
     */
    public function show(int $id): ProdutoResource
    {
        $model = $this->produtoService->show($id);

        return new ProdutoResource($model);
    }

    public function meusProdutos()
    {
        return new ClientesProdutoResource(auth()->user()->clientesProdutos);
    }

    public function meuProduto($id)
    {
        $clienteProduto = auth()->user()->clientesProdutos()->where('id', $id)->firstOrFail();

        return new ClientesProdutoResource($clienteProduto);
    }


}
