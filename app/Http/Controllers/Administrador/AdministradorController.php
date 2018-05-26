<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:30
 */

namespace App\Http\Controllers\Administrador;

use App\Http\Resources\AdministradorResource;
use App\Services\AdministradorService;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;

class AdministradorController extends Controller
{
    private $administradorService;

    /**
     * AdministradorController constructor.
     * @param AdministradorService $administradorService
     */
    public function __construct(AdministradorService $administradorService)
    {
        $this->administradorService = $administradorService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AdministradorResource
     * @throws \Exception
     */
    public function index(Request $request): AdministradorResource
    {

        $model = $this->administradorService->index($request->toCollection());

        return new AdministradorResource($model);
    }


    /** Login Method
     * @param Request $request
     * @return AdministradorResource
     * @throws \Exception
     * @throws \Throwable
     */
    public function login(Request $request): AdministradorResource
    {
        $model = $this->administradorService->login($request->toCollection());

        return new AdministradorResource($model, true);
    }

    /**
     * Display the specified resource.
     *
     * @return AdministradorResource
     */
    public function me(): AdministradorResource
    {
        $model = $this->administradorService->show(auth()->id());

        return new AdministradorResource($model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return AdministradorResource
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(Request $request): AdministradorResource
    {
        $model = $this->administradorService->store($request->toCollection());

        return new AdministradorResource($model, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return AdministradorResource
     */
    public function show(int $id): AdministradorResource
    {
        $model = $this->administradorService->show($id);

        return new AdministradorResource($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return AdministradorResource
     * @throws \Exception
     */
    public function update(Request $request): AdministradorResource
    {
        $model = $this->administradorService->update($request->toCollection(), auth()->id());

        return new AdministradorResource($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return AdministradorResource
     * @throws \Exception
     */
    public function destroy(): AdministradorResource
    {
        $model = $this->administradorService->delete(auth()->id());

        return new AdministradorResource($model);
    }

}
