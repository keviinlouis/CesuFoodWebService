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

use App\Entities\Administrador;
use App\Exceptions\ExceptionWithData;
use App\Validators\AdministradorRules;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class AdministradorService
 * @package App\Services
 */
class AdministradorService extends Service
{
    public $relations;

    public $relationsCount;

    /**
     * AdministradorService constructor.
     */
    public function __construct()
    {
        $this->relations = [];
        $this->relationsCount = [];
    }


    /**
     * Listagem de Administrador
     * @param Collection $filters
     * @return Administrador[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function index(Collection $filters = null)
    {
        if (!$filters) {
            $filters = collect();
        }

        $query = Administrador::with($this->relations);

        $order = $filters->get('order', 'asc');

        $sortBy = $filters->get('sort', 'id');

        $limit = $filters->get('limit', 15);

        $query->orderBy($sortBy, $order);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    /**
     * Visualizar Administrador pelo id
     * @param int|Administrador $model
     * @return Administrador
     * @throws ModelNotFoundException
     */
    public function show($model): Administrador
    {
        if (!$model instanceof Administrador) {
            $model = Administrador::whereId($model)->firstOrFail();
        }

        return $model->load($this->relations);
    }

    /**
     * Criar Administrador
     * @param Collection $data
     * @return Administrador
     * @throws Exception
     */
    public function store(Collection $data): Administrador
    {
        $this->validateWithArray($data->toArray(), AdministradorRules::store());

        $model = Administrador::create($data->all());

        return $this->show($model);
    }


    /**
     * Atualizar Administrador
     * @param Collection $data
     * @param int|Administrador $id
     * @throws ModelNotFoundException
     * @throws Exception
     * @return Administrador
     */
    public function update(Collection $data, $id): Administrador
    {
        $this->validateWithArray($data->toArray(), AdministradorRules::update());

        $model = $this->show($id);

        $model->update($data->all());

        return $this->show($model);
    }

    /**
     * Deletar Administrador
     * @param int|Administrador $id
     * @return Administrador
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function delete($id): Administrador
    {
        $model = $this->show($id);

        $model->delete();

        return $model;
    }

    /**
     * @param Collection $data
     * @return Administrador
     * @throws Exception
     * @throws \Throwable
     */
    public function login(Collection $data): Administrador
    {
        $this->validateWithArray($data, AdministradorRules::login());

        $model = Administrador::whereEmail($data->get('email'))->first();

        if(!$model->checkSenha($data->get('senha'))){
            throw new ExceptionWithData('Dados Inválidos', Response::HTTP_BAD_REQUEST, ['senha' => ['senha inválida']]);
        }

        return $model;
    }
}
