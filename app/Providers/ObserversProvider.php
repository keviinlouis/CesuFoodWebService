<?php

namespace App\Providers;

use App\Entities\Arquivo;
use App\Entities\ClientesProduto;
use App\Entities\Pedido;
use App\Observers\ArquivoObserver;
use App\Observers\ClientesProdutoObserver;
use App\Observers\PedidoObserver;
use Illuminate\Support\ServiceProvider;

class ObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Arquivo::observe(ArquivoObserver::class);
        Pedido::observe(PedidoObserver::class);
        ClientesProduto::observe(ClientesProdutoObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
