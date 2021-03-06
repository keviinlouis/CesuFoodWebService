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
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

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
     * Listagem de ClienteController
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

        $order = $filters->get('order', 'asc');

        $sortBy = $filters->get('sort', 'id');

        $limit = $filters->get('limit', 15);

        $query->orderBy($sortBy, $order);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    /**
     * Visualizar ClienteController pelo id
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
     * Criar ClienteController
     * @param Collection $data
     * @return Cliente
     * @throws Exception
     */
    public function store(Collection $data): Cliente
    {
        $this->validateWithArray($data->toArray(), ClienteRules::store());
        \DB::beginTransaction();

        $model = Cliente::create($data->all());

        if ($fotosPerfil = $data->get('foto_perfil')) {
            $model->fotoPerfil()->create([
                'nome' => $fotosPerfil,
                'path' => $model->getPublicPathFiles(),
                'tipo' => Cliente::FOTO_PERFIL
            ]);
        }

        \DB::commit();
        return $this->show($model);
    }


    /**
     * Atualizar ClienteController
     * @param Collection $data
     * @param int|Cliente $id
     * @throws ModelNotFoundException
     * @throws Exception
     * @return Cliente
     * @throws \Throwable
     */
    public function update(Collection $data, $id): Cliente
    {
        $this->validateWithArray($data->toArray(), ClienteRules::update());

        $model = $this->show($id);

        if($novaSenha = $data->get('nova_senha')){
            throw_if(
                !$model->checkSenha($data->get('senha')),
                ExceptionWithData::class,
                'Dados Inválidos',
                Response::HTTP_BAD_REQUEST,
                ['senha' => ['Senha incorreta']]
            );

            $data['senha'] = $novaSenha;
        }

        \DB::beginTransaction();

        $model->update($data->all());

        if ($fotosPerfil = $data->get('foto_perfil')) {
            $model->fotoPerfil()->updateOrCreate(
                [
                    'tipo' => Cliente::FOTO_PERFIL
                ],
                [
                    'nome' => $fotosPerfil,
                    'path' => $model->getPublicPathFiles()

                ]
            );
        }

        \DB::commit();
        return $this->show($model);
    }

    /**
     * Deletar ClienteController
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

        $model = Cliente::whereRa($data->get('ra'))->withTrashed()->firstOrFail();

        if (!$model->checkSenha($data->get('senha'))) {
            throw new ExceptionWithData('Dados Inválidos', Response::HTTP_BAD_REQUEST, ['senha' => ['senha inválida']]);
        }


        !$model->trashed()?:$model->restore();

        return $model;
    }
}
