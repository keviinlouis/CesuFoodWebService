<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 29/05/2018
 * Time: 21:48
 */

namespace App\Services;

use App\Entities\ClientesProduto;
use App\Entities\Pedido;
use App\Entities\Produto;
use App\Exceptions\ExceptionWithData;
use App\Validators\PedidoRules;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class PedidoService
 * @package App\Services
 */
class PedidoService extends Service
{
    public $relations;

    public $relationsCount;

    /**
     * PedidoService constructor.
     */
    public function __construct()
    {
        $this->relations = [];
        $this->relationsCount = [];
    }


    /**
     * Listagem de Pedido
     * @param Collection $filters
     * @return Pedido[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function index(Collection $filters = null)
    {
        if (!$filters) {
            $filters = collect();
        }

        $query = Pedido::with($this->relations);

        if($clienteId = $filters->get('cliente_id')){
            $query->whereIn('cliente_id', (array) $clienteId);
        }

        if(($status = $filters->get('status', null)) !== null){
            $query->whereIn('status', (array) $status);
        }

        $order = $filters->get('desc', false) ? 'desc' : 'asc';

        $sortBy = $filters->get('sort', 'id');

        $limit = $filters->get('limit', 15);

        $query->orderBy($sortBy, $order);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    /**
     * Visualizar Pedido pelo id
     * @param int|Pedido $model
     * @return Pedido
     * @throws ModelNotFoundException
     */
    public function show($model): Pedido
    {
        if (!$model instanceof Pedido) {
            $model = Pedido::whereId($model)->firstOrFail();
        }

        return $model->load($this->relations);
    }

    /**
     * Criar Pedido
     * @param Collection $data
     * @return Pedido
     * @throws Exception
     */
    public function store(Collection $data): Pedido
    {
        $this->validateWithArray($data->toArray(), PedidoRules::store());

        $model = Pedido::create($data->all());

        return $this->show($model);
    }


    /**
     * Atualizar Pedido
     * @param Collection $data
     * @param int|Pedido $id
     * @throws ModelNotFoundException
     * @throws Exception
     * @return Pedido
     */
    public function update(Collection $data, $id): Pedido
    {
        $this->validateWithArray($data->toArray(), PedidoRules::update());

        $model = $this->show($id);

        $model->update($data->all());

        return $this->show($model);
    }

    /**
     * Deletar Pedido
     * @param int|Pedido $id
     * @return Pedido
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function delete($id): Pedido
    {
        $model = $this->show($id);

        $model->delete();

        return $model;
    }

    /**
     * @param Pedido $pedido
     * @param $produtoId
     * @param $clienteId
     * @return Pedido
     * @throws ExceptionWithData
     * @throws Exception
     */
    public function adicionarProduto(Pedido $pedido, $produtoId, $clienteId)
    {
        if(!$pedido->isAberto()){
            throw new ExceptionWithData('Pedido precisa estar no status aberto para adicionar produtos', Response::HTTP_BAD_REQUEST);
        }

        $produto = Produto::whereId($produtoId)->firstOrFail();

        \DB::beginTransaction();

        $pedido->clientesProdutos()->create([
            'cliente_id' => $clienteId,
            'produto_id' => $produto->getKey(),
            'status' => ClientesProduto::AGUARDANDO_FECHAMENTO
        ]);

        \DB::commit();

        return $this->show($pedido);
    }

    public function removerProduto(Pedido $pedido, $produtoId)
    {
        $pedido->clientesProdutos()->where('produto_id', $produtoId)->first()->delete();

        return $this->show($pedido);
    }

    public function finalizarPedido(Pedido $pedido)
    {
        // TODO Finalizar Pedido
    }
}
