<?php

namespace App\Console\Commands;

use App\Entities\ClientesProduto;
use Illuminate\Console\Command;

class TestarQrCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teste:qrcode {clienteProdutoId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar QR code com cliente produto';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @throws \LaravelQRCode\Exceptions\EmptyTextException
     * @throws \LaravelQRCode\Exceptions\MalformedUrlException
     */
    public function handle()
    {
        $clienteProduto = ClientesProduto::find($this->argument('clienteProdutoId'));

        if(!$clienteProduto){
            $this->error('Cliente Produto não encontrado');
            return;
        }

        $clienteProduto->gerarQrCode();
    }
}
