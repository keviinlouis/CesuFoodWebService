<?php

namespace App\Console\Commands;

use App\Entities\ClientesProduto;
use Illuminate\Console\Command;
use QRCode;

class TestarQrCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teste:qrcode {hash}';

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
        $nome = uniqid().'.png';

        \Storage::exists('testes')?:\Storage::makeDirectory('testes');

        QRCode::url('https://cesufood-admin.herokuapp.com/vender/'.$this->argument('hash'))
            ->setSize(8)
            ->setMargin(2)
            ->setOutfile(storage_path('app').'/testes/'.$nome)
            ->png();
    }
}
