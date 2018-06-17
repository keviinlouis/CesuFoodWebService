<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 17/06/2018
 * Time: 15:53
 */

namespace App\Http\Controllers\Cliente;

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
}
