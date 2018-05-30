<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 30/05/2018
 * Time: 00:12
 */

namespace App\Services;

use App\Entities\Cartao;
use App\Validators\CartaoRules;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class CartaoService
 * @package App\Services
 */
class CartaoService extends Service
{
    public $relations;

    public $relationsCount;

    /**
     * CartaoService constructor.
     */
    public function __construct()
    {
        $this->relations = [];
        $this->relationsCount = [];
    }


    /**
     * Listagem de Cartao
     * @param Collection $filters
     * @return Cartao[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function index(Collection $filters = null)
    {
        if (!$filters) {
            $filters = collect();
        }

        $query = Cartao::with($this->relations);

        if ($clienteId = $filters->get('cliente_id')) {
            $query->whereIn('cliente_id', (array)$clienteId);
        }

        $order = $filters->get('desc', false) ? 'desc' : 'asc';

        $sortBy = $filters->get('sort', 'id');

        $limit = $filters->get('limit', 15);

        $query->orderBy($sortBy, $order);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    /**
     * Visualizar Cartao pelo id
     * @param int|Cartao $model
     * @return Cartao
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function show($model): Cartao
    {
        if (!$model instanceof Cartao) {
            $model = Cartao::whereId($model)->firstOrFail();
        }

        if(auth()->user()->isCliente() && $model->cliente_id != auth()->id()){
            throw new Exception('Este cartão não pertence a este usuario', Response::HTTP_UNAUTHORIZED);
        }

        return $model->load($this->relations);
    }

    /**
     * Criar Cartao
     * @param Collection $data
     * @return Cartao
     * @throws Exception
     */
    public function store(Collection $data): Cartao
    {
        $this->validateWithArray($data->toArray(), CartaoRules::store());

        $model = Cartao::create($data->all());

        return $this->show($model);
    }


    /**
     * Atualizar Cartao
     * @param Collection $data
     * @param int|Cartao $id
     * @throws ModelNotFoundException
     * @throws Exception
     * @return Cartao
     */
    public function update(Collection $data, $id): Cartao
    {
        $this->validateWithArray($data->toArray(), CartaoRules::update());

        $model = $this->show($id);

        $model->update($data->all());

        return $this->show($model);
    }

    /**
     * Deletar Cartao
     * @param int|Cartao $id
     * @return Cartao
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function delete($id): Cartao
    {
        $model = $this->show($id);

        $model->delete();

        return $model;
    }
}
