<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 30/05/2018
 * Time: 00:11
 */

namespace App\Http\Controllers\Cliente;

use App\Http\Resources\CartaoResource;
use App\Services\CartaoService;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;

class CartaoController extends Controller
{
    private $cartaoService;

    /**
     * CartaoController constructor.
     * @param CartaoService $cartaoService
     */
    public function __construct(CartaoService $cartaoService)
    {
        $this->cartaoService = $cartaoService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CartaoResource
     * @throws \Exception
     */
    public function index(Request $request): CartaoResource
    {

        $model = $this->cartaoService->index($request->toCollection());

        return new CartaoResource($model);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return CartaoResource
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(Request $request): CartaoResource
    {
        $data = $request->toCollection();
        $data['cliente_id'] = auth()->id();
        $model = $this->cartaoService->store($data);

        return new CartaoResource($model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return CartaoResource
     * @throws \Exception
     */
    public function show(int $id): CartaoResource
    {
        $model = $this->cartaoService->show($id);

        return new CartaoResource($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return CartaoResource
     * @throws \Exception
     */
    public function update(Request $request, int $id): CartaoResource
    {
        $model = $this->cartaoService->update($request->toCollection(), $id);

        return new CartaoResource($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return CartaoResource
     * @throws \Exception
     */
    public function destroy(int $id): CartaoResource
    {
        $model = $this->cartaoService->delete($id);

        return new CartaoResource($model);
    }
}
