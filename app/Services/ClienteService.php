<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 00:28
 */

namespace App\Services;

use App\Entities\Cliente;
use App\Exceptions\ExceptionWithData;
use App\Validators\ClienteRules;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ClienteService
 * @package App\Services
 */
class ClienteService extends Service
{
    public $relations;

    public $relationsCount;

    /**
     * ClienteService constructor.
     */
    public function __construct()
    {
        $this->relations = [];
        $this->relationsCount = [];
    }


    /**
     * Listagem de Cliente
     * @param Collection $filters
     * @return Cliente[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function index(Collection $filters = null)
    {
        if (!$filters) {
            $filters = collect();
        }

        $query = Cliente::with($this->relations);

        $order = $filters->get('desc', false) ? 'desc' : 'asc';

        $sortBy = $filters->get('sort', 'id');

        $limit = $filters->get('limit', 15);

        $query->orderBy($sortBy, $order);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    /**
     * Visualizar Cliente pelo id
     * @param int|Cliente $model
     * @return Cliente
     * @throws ModelNotFoundException
     */
    public function show($model): Cliente
    {
        if (!$model instanceof Cliente) {
            $model = Cliente::whereId($model)->firstOrFail();
        }

        return $model->load($this->relations);
    }

    /**
     * Criar Cliente
     * @param Collection $data
     * @return Cliente
     * @throws Exception
     */
    public function store(Collection $data): Cliente
    {
        $this->validateWithArray($data->toArray(), ClienteRules::store());

        $model = Cliente::create($data->all());

        return $this->show($model);
    }


    /**
     * Atualizar Cliente
     * @param Collection $data
     * @param int|Cliente $id
     * @throws ModelNotFoundException
     * @throws Exception
     * @return Cliente
     */
    public function update(Collection $data, $id): Cliente
    {
        $this->validateWithArray($data->toArray(), ClienteRules::update());

        $model = $this->show($id);

        $model->update($data->all());

        return $this->show($model);
    }

    /**
     * Deletar Cliente
     * @param int|Cliente $id
     * @return Cliente
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function delete($id): Cliente
    {
        $model = $this->show($id);

        $model->delete();

        return $model;
    }

    /**
     * @param Collection $data
     * @return Cliente
     * @throws Exception
     * @throws \Throwable
     */
    public function login(Collection $data): Cliente
    {
        $this->validateWithArray($data, ClienteRules::login());
        $model = Cliente::whereEmail($data->get('email'))->first();

        if(!$model->checkSenha($data->get('senha'))){
            throw new ExceptionWithData('Dados Inválidos', Response::HTTP_BAD_REQUEST, ['senha' => ['senha inválida']]);
        }

        return $model;
    }
}
