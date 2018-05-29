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
        $this->relationsCount = [];
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
     */
    public function delete($id): Categoria
    {
        $model = $this->show($id);

        $model->delete();

        return $model;
    }
}
