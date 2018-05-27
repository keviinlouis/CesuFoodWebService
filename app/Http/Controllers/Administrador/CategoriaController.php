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

namespace App\Http\Controllers\Administrador;

use App\Http\Resources\CategoriaResource;
use App\Services\CategoriaService;
use App\Http\Requests\Request;
use App\Http\Controllers\Controller;

class CategoriaController extends Controller
{
    private $categoriaService;

    /**
     * CategoriaController constructor.
     * @param CategoriaService $categoriaService
     */
    public function __construct(CategoriaService $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CategoriaResource
     * @throws \Exception
     */
    public function index(Request $request): CategoriaResource
    {

        $model = $this->categoriaService->index($request->toCollection());

        return new CategoriaResource($model);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return CategoriaResource
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(Request $request): CategoriaResource
    {
        $model = $this->categoriaService->store($request->toCollection());

        return new CategoriaResource($model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return CategoriaResource
     */
    public function show(int $id): CategoriaResource
    {
        $model = $this->categoriaService->show($id);

        return new CategoriaResource($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return CategoriaResource
     * @throws \Exception
     */
    public function update(Request $request, int $id): CategoriaResource
    {
        $model = $this->categoriaService->update($request->toCollection(), $id);

        return new CategoriaResource($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return CategoriaResource
     * @throws \Exception
     */
    public function destroy(int $id): CategoriaResource
    {
        $model = $this->categoriaService->delete($id);

        return new CategoriaResource($model);
    }
}
