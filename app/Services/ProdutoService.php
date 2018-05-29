<?php
/**
 * Criado através de FileTemplate por Kevin.
 */

/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 27/05/2018
 * Time: 01:30
 */

namespace App\Services;

use App\Entities\Produto;
use App\Validators\ProdutoRules;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ProdutoService
 * @package App\Services
 */
class ProdutoService extends Service
{
    public $relations;

    public $relationsCount;

    /**
     * ProdutoService constructor.
     */
    public function __construct()
    {
        $this->relations = [];
        $this->relationsCount = [];
    }


    /**
     * Listagem de Produto
     * @param Collection $filters
     * @return Produto[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function index(Collection $filters = null)
    {
        if (!$filters) {
            $filters = collect();
        }

        $query = Produto::with($this->relations);

        if($categoria = $filters->get('categoria')){
            $query->whereCategoriaId($categoria);
        }

        if($valor = $filters->get('valor')){
            $query->whereValor($valor);
        }

        if($search = $filters->get('search')){
            $query->where(function(Builder $builder) use ($search) {
                $search = '%'.$search.'%';
               $builder->where('nome', 'like', $search);
            });
        }

        $order = $filters->get('order', 'asc');

        $sortBy = $filters->get('sort', 'id');

        $limit = $filters->get('limit', 15);

        $query->orderBy($sortBy, $order);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    /**
     * Visualizar Produto pelo id
     * @param int|Produto $model
     * @return Produto
     * @throws ModelNotFoundException
     */
    public function show($model): Produto
    {
        if (!$model instanceof Produto) {
            $model = Produto::whereId($model)->firstOrFail();
        }

        return $model->load($this->relations);
    }

    /**
     * Criar Produto
     * @param Collection $data
     * @return Produto
     * @throws Exception
     */
    public function store(Collection $data): Produto
    {
        $this->validateWithArray($data->toArray(), ProdutoRules::store());

        $model = Produto::create($data->all());

        foreach($data->get('fotos') as $foto){
            $model->fotos()->create([
                'nome' => $foto,
                'path' => $model->getPublicPathFiles(),
                'tipo' => Produto::FOTO
            ]);
        }

        return $this->show($model);
    }


    /**
     * Atualizar Produto
     * @param Collection $data
     * @param int|Produto $id
     * @throws ModelNotFoundException
     * @throws Exception
     * @return Produto
     */
    public function update(Collection $data, $id): Produto
    {
        $this->validateWithArray($data->toArray(), ProdutoRules::update());

        $model = $this->show($id);

        $model->update($data->all());

        foreach($data->get('fotos_adicionadas') as $foto){
            $model->fotos()->create([
                'nome' => $foto,
                'path' => $model->getPublicPathFiles(),
                'tipo' => Produto::FOTO
            ]);
        }

        $fotosRemovidas = $model->fotos()->whereIn('nome', $data->get('fotos_removidas'))->get();
        foreach($fotosRemovidas as $foto){
            $foto->delete();
        }

        return $this->show($model);
    }

    /**
     * Deletar Produto
     * @param int|Produto $id
     * @return Produto
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function delete($id): Produto
    {
        $model = $this->show($id);

        $model->delete();

        return $model;
    }
}
