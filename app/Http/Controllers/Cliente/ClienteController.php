<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:31
 */

namespace App\Http\Controllers\Cliente;

use App\Http\Resources\ClienteResource;
use App\Services\ClienteService;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    private $clienteService;

    /**
     * ClienteController constructor.
     * @param ClienteService $clienteService
     */
    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ClienteResource
     * @throws \Exception
     */
    public function index(Request $request): ClienteResource
    {

        $model = $this->clienteService->index($request->toCollection());

        return new ClienteResource($model);
    }


    /** Login Method
     * @param Request $request
     * @return ClienteResource
     * @throws \Exception
     * @throws \Throwable
     */
    public function login(Request $request): ClienteResource
    {
        $model = $this->clienteService->login($request->toCollection());

        return new ClienteResource($model, true);
    }

    /**
     * Display the specified resource.
     *
     * @return ClienteResource
     */
    public function me(): ClienteResource
    {
        $model = $this->clienteService->show(auth()->id());

        return new ClienteResource($model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ClienteResource
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(Request $request): ClienteResource
    {
        $model = $this->clienteService->store($request->toCollection());

        return new ClienteResource($model, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return ClienteResource
     */
    public function show(int $id): ClienteResource
    {
        $model = $this->clienteService->show($id);

        return new ClienteResource($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return ClienteResource
     * @throws \Exception
     */
    public function update(Request $request): ClienteResource
    {
        $model = $this->clienteService->update($request->toCollection(), auth()->id());

        return new ClienteResource($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return ClienteResource
     * @throws \Exception
     */
    public function destroy(): ClienteResource
    {
        $model = $this->clienteService->delete(auth()->id());

        return new ClienteResource($model);
    }

}
