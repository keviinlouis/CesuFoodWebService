<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 02/03/2018
 * Time: 18:45
 */

namespace App\Observers;

use App\Entities\Arquivo;
use App\Entities\Cliente;
use App\Entities\Produto;
use App\Services\FileService;

class ArquivoObserver extends Observer
{
    private $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    protected $tiposRemoviveisAoRemoverDoBanco = [
        Produto::FOTO,
        Cliente::FOTO_PERFIL
    ];

    protected $tiposComThumb = [
        Produto::FOTO,
        Cliente::FOTO_PERFIL
    ];

    /**
     * @param Arquivo $arquivo
     * @throws \Exception
     */
    public function creating(Arquivo $arquivo)
    {
        if(!$this->checkIfIsFile($arquivo->nome)){
            return;
        }
        $this->copyFile($arquivo);
    }

    public function created(Arquivo $arquivo)
    {
        $this->fileService->removeFromTmp(
            $arquivo->nome
        );
        if (in_array($arquivo->tipo, $this->tiposComThumb) !== false) {
            $this->makeThumb($arquivo);
        }
    }

    /**
     * @param Arquivo $arquivo
     * @throws \Exception
     */
    public function updating(Arquivo $arquivo)
    {
        if($this->isNotEqual('nome', $arquivo)){
            $this->copyFile($arquivo);
        }
    }

    public function updated(Arquivo $arquivo)
    {
        if (in_array($arquivo->tipo, $this->tiposComThumb) !== false) {
            $this->makeThumb($arquivo);
        }

        $this->fileService->removeFromTmp(
            $arquivo->nome
        );
        $this->fileService->removeFile(
            $arquivo->getOriginal('path')
        );
    }

    /**
     * @param Arquivo $arquivo
     */
    public function deleted(Arquivo $arquivo)
    {
        if (in_array($arquivo->tipo, $this->tiposRemoviveisAoRemoverDoBanco) !== false) {
            $arquivo->removeFile();
            $arquivo->removeThumb();
        }
    }

    public function checkIfIsFile($nome)
    {
        return strpos($nome, '.') !== true;
    }

    /**
     * @param $path
     * @param $name
     * @param $arquivo
     * @throws \Exception
     */
    public function copyFile(Arquivo &$arquivo)
    {
        $toPath = explode('/', $arquivo->path);
        if($toPath[count($toPath)-1] == $arquivo->nome){
            unset($toPath[count($toPath)-1]);
        }
        $toPath = implode('/', $toPath);

        $path = $this->fileService->copyFileFromTmp(
            $arquivo->nome,
            $toPath
        );

        $arquivo->path = $path;
        $arquivo->url = $this->fileService->url($arquivo->path);
        $arquivo->extensao = $this->fileService->extractExtensionFromFileName($arquivo->nome);
    }

    public function makeThumb(Arquivo $arquivo)
    {
        if($arquivo->isImage()){
            $this->fileService->resizeImage(Arquivo::THUMB_WIDTH, Arquivo::THUMB_HEIGHT, $arquivo->path, $arquivo->nome_thumb);
        }
    }

}
