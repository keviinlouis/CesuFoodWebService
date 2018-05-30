<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 29/05/2018
 * Time: 21:48
 */

namespace App\Http\Controllers\Cliente;

use App\Http\Resources\PedidoResource;
use App\Services\PedidoService;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;

class PedidoController extends Controller
{
    private $pedidoService;

    /**
     * PedidoController constructor.
     * @param PedidoService $pedidoService
     */
    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return PedidoResource
     * @throws \Exception
     */
    public function index(Request $request): PedidoResource
    {
        $data = $request->toCollection();
        $data['cliente_id'] = auth()->id();
        $model = $this->pedidoService->index($data);

        return new PedidoResource($model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return PedidoResource
     * @throws \Exception
     */
    public function show(int $id): PedidoResource
    {
        $model = $this->pedidoService->show($id);

        return new PedidoResource($model);
    }

    public function pedidoAtual()
    {
        return new PedidoResource(auth()->user()->pedido_aberto);
    }

    /**
     * @param int $id
     * @return PedidoResource
     * @throws \App\Exceptions\ExceptionWithData
     */
    public function adicionarProduto(int $id)
    {
        $model = $this->pedidoService->adicionarProduto(auth()->user()->pedido_aberto, $id, auth()->id());

        return new PedidoResource($model);
    }

    /**
     * @param int $id
     * @return PedidoResource
     */
    public function removerProduto(int $id)
    {
        $model = $this->pedidoService->removerProduto(auth()->user()->pedido_aberto, $id);

        return new PedidoResource($model);
    }

    /**
     * @param Request $request
     * @return PedidoResource
     * @throws \Exception
     */
    public function finalizar(Request $request)
    {
        $model = $this->pedidoService->finalizarPedido(auth()->user()->pedido_aberto, $request->toCollection());

        return new PedidoResource($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return PedidoResource
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $model = $this->pedidoService->update($request->toCollection(), $id);

        return new PedidoResource($model);
    }
}
