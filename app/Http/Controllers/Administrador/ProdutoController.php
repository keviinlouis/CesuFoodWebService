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

namespace App\Http\Controllers\Administrador;

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

        $model = $this->produtoService->index($request->toCollection());

        return new ProdutoResource($model);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ProdutoResource
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(Request $request): ProdutoResource
    {
        $model = $this->produtoService->store($request->toCollection());

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

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return ProdutoResource
     * @throws \Exception
     */
    public function update(Request $request, int $id): ProdutoResource
    {
        $model = $this->produtoService->update($request->toCollection(), $id);

        return new ProdutoResource($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return ProdutoResource
     * @throws \Exception
     */
    public function destroy(int $id): ProdutoResource
    {
        $model = $this->produtoService->delete($id);

        return new ProdutoResource($model);
    }
}
