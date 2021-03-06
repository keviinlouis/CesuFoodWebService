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

namespace App\Services;

use App\Entities\Categoria;
use App\Validators\CategoriaRules;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class CategoriaService
 * @package App\Services
 */
class CategoriaService extends Service
{
    public $relations;

    public $relationsCount;

    /**
     * CategoriaService constructor.
     */
    public function __construct()
    {
        $this->relations = [];
        $this->relationsCount = ['produtos'];
    }


    /**
     * Listagem de Categoria
     * @param Collection $filters
     * @return Categoria[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function index(Collection $filters = null)
    {
        if (!$filters) {
            $filters = collect();
        }

        $query = Categoria::with($this->relations);

        if($filters->has('count_produtos')){
            $query->withCount('produtos');
        }
        if($filters->has('count_produtos_vendidos')){
            $query->withCount('clientesProdutos');
        }

        $order = $filters->get('order', 'asc');

        $sortBy = $filters->get('sort', 'nome');

        $limit = $filters->get('limit', 15);

        $query->orderBy($sortBy, $order);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    /**
     * Visualizar Categoria pelo id
     * @param int|Categoria $model
     * @return Categoria
     * @throws ModelNotFoundException
     */
    public function show($model): Categoria
    {
        if (!$model instanceof Categoria) {
            $model = Categoria::whereId($model)->firstOrFail();
        }

        return $model->load($this->relations);
    }

    /**
     * Criar Categoria
     * @param Collection $data
     * @return Categoria
     * @throws Exception
     */
    public function store(Collection $data): Categoria
    {
        $this->validateWithArray($data->toArray(), CategoriaRules::store());

        $model = Categoria::create($data->all());

        return $this->show($model);
    }


    /**
     * Atualizar Categoria
     * @param Collection $data
     * @param int|Categoria $id
     * @throws ModelNotFoundException
     * @throws Exception
     * @return Categoria
     */
    public function update(Collection $data, $id): Categoria
    {
        $this->validateWithArray($data->toArray(), CategoriaRules::update());

        $model = $this->show($id);

        $model->update($data->all());

        return $this->show($model);
    }

    /**
     * Deletar Categoria
     * @param int|Categoria $id
     * @return Categoria
     * @throws ModelNotFoundException
     * @throws Exception
     * @throws \Throwable
     */
    public function delete($id): Categoria
    {
        $model = $this->show($id);

        throw_if($model->produtos->isNotEmpty(), Exception::class, 'Você não pode deletar uma categoria com produtos', Response::HTTP_BAD_REQUEST);

        $model->delete();

        return $model;
    }
}
