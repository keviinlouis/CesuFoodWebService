<?php
/**
 * Created by PhpStorm.
 * User: DevMaker Backend
 * Date: 28/02/2018
 * Time: 15:40
 */

namespace App\Services;


use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Storage;
use URL;

class FileService
{
    private $public;
    private $pathTemp;
    private $extensions_allowed;
    private $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * FileService constructor.
     * @param array $extensions
     */
    public function __construct(array $extensions = [])
    {
        $this->public = "public";
        $this->pathTemp = $this->public . "/temp/";

        if (!Storage::exists($this->pathTemp)) {
            Storage::makeDirectory($this->pathTemp);
        }

        $this->setExtensionsAllowed($extensions);
    }

    /**
     * @param array $extensions
     */
    public function setExtensionsAllowed(array $extensions): void
    {
        $newExtensions = [];
        foreach ($extensions as $extension) {
            $extension = '.' . str_replace('.', '', $extension);
            $newExtensions[] = $extension;
            $extensionUpper = strtoupper($extension);
            if (in_array($extensionUpper, $newExtensions) === false) {
                $newExtensions[] = $extensionUpper;
            }
        }
        $this->extensions_allowed = collect($newExtensions);
    }

    public function setImageExtensions($moreExtensions = [])
    {
        $this->setExtensionsAllowed($this->image_extensions + $moreExtensions);
    }

    /**
     * @return Collection
     */
    public function getExtensionsAllowed(): Collection
    {
        return $this->extensions_allowed;
    }

    /**
     * @param $extension
     * @return bool
     * @throws \Exception
     */
    public function checkIsAllowed($extension)
    {
        if ($this->getExtensionsAllowed()->isNotEmpty() && !$this->getExtensionsAllowed()->search($extension)) {
            throw new \Exception('Tipo de arquivo não permitido.', 401);
        }
        return true;
    }

    /**
     * @param $file
     * @param string $extension
     * @return string
     * @throws \Exception
     */
    public function makeFileName($file, string $extension = ''): string
    {
        $extension = $this->extractExtension($file, $extension);

        $this->checkIsAllowed($extension);

        $fileName = uniqid() . $extension;

        return $fileName;
    }

    /**
     * @param $file
     * @param string $extension
     * @return string
     */
    public function extractExtension($file, string $extension = ''): string
    {
        if ($extension == '' || is_null($extension)) {
            $extension = $file->getClientOriginalExtension();
        }

        if (strpos($extension, '.') === false) {
            $extension = '.' . $extension;
        }
        return strtolower($extension) == '.jpeg' || strtolower($extension) == '.JPEG' ? '.jpg' : $extension;
    }

    /**
     * @param $file
     * @return string
     */
    public function extractExtensionFromFileName($file): string
    {
        $arrayFileName = explode('/', $file);
        $arrayFileName = explode('.', end($arrayFileName));
        $extension = end($arrayFileName);
        return $extension;
    }

    /**
     * @param $file
     * @return string
     */
    public function extractExtensionFromFacebook($file): string
    {
        $arrayFileName = explode('?', $file);
        $arrayFileName = explode('/', reset($arrayFileName));
        $arrayFileName = explode('.', end($arrayFileName));
        $extension = end($arrayFileName);
        return $extension;
    }

    /**
     * @param $file
     * @return string
     */
    public function extractNameFromFacebook($file): string
    {
        $arrayFileName = explode('?', $file);
        $arrayFileName = explode('/', reset($arrayFileName));
        $arrayFileName = explode('.', end($arrayFileName));
        $name = reset($arrayFileName);
        return $name;
    }

    /**
     * @param $file
     * @param string $extension
     * @param bool $url
     * @return string
     * @throws \Exception
     */
    public function uploadFileToTmp($file, string $extension = '', $url = false): string
    {
        return $this->uploadFile($this->pathTemp, $file, $extension, $url);

    }

    /**
     * @param $path
     * @param $file
     * @param string $extension
     * @param bool $url
     * @return string
     * @throws \Exception
     */
    public function uploadFile($path, $file, string $extension = '', $url = false): string
    {
        $fileName = $this->makeFileName($file, $extension);

        $file->storeAs($path, $fileName);

        return $url ? $this->url($path . $fileName) : $path . $fileName;
    }

    public function removeArrayFiles(array $files)
    {
        foreach ($files as $file) {
            $this->removeFile($file);
        }
    }

    public function removeArrayFromTmp(array $files)
    {
        foreach ($files as $file) {
            $this->removeFromTmp($file);
        }
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function removeFromTmp(string $fileName): bool
    {
        return $this->removeFile($this->pathTemp . $fileName);
    }

    /**
     * @param $fromPath
     * @return bool
     */
    public function removeFile($fromPath): bool
    {
        return !Storage::exists($fromPath) || Storage::delete($fromPath);
    }

    /**
     * @param string $fileName
     * @throws \Exception
     */
    public function checkNameIsValid(string $fileName): void
    {
        if (strlen($fileName) <= 0 || is_null($fileName) || empty($fileName)) {
            throw new \Exception('O Nome do arquivo é obrigatorio ', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param string $fileName
     * @param string $newPath
     * @return bool|string
     * @throws \Exception
     */
    public function moveFileFromTmp(string $fileName, string $newPath): string
    {
        $this->checkNameIsValid($fileName);

        $fromPath = $this->pathTemp . '/' . $fileName;
        $toPath = $newPath . '/' . $fileName;

        return $this->moveFile($fromPath, $toPath);
    }

    /**
     * @param string $fromPath
     * @param string $toPath
     * @return string
     * @throws \Exception
     */
    public function moveFile(string $fromPath, string $toPath): string
    {
        Storage::exists($toPath) ?: Storage::makeDirectory($toPath);

        if (!Storage::exists($fromPath) && !Storage::exists($toPath)) {
            throw new \Exception('Arquivo não encontrado', Response::HTTP_NOT_FOUND);
        }

        if (!Storage::exists($toPath) && !Storage::move($fromPath, $toPath)) {
            throw new \Exception('Erro ao mover o arquivo', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->url($toPath);

    }

    /**
     * @param string $fileName
     * @param string $newPath
     * @param bool $url
     * @return string
     * @throws \Exception
     */
    public function copyFileFromTmp(string $fileName, string $newPath, $url = false): string
    {
        $this->checkNameIsValid($fileName);

        $fromPath = $this->pathTemp . '/' . $fileName;
        $toPath = $newPath . '/' . $fileName;
        return $this->copyFile($fromPath, $toPath, $url);
    }

    /**
     * @param string $fromPath
     * @param string $toPath
     * @param bool $url
     * @return string
     * @throws \Exception
     */
    public function copyFile(string $fromPath, string $toPath, $url = false): string
    {
//        Storage::exists($toPath) ?: Storage::makeDirectory($toPath);

        if (!Storage::exists($fromPath) && !Storage::exists($toPath)) {
            throw new \Exception('Arquivo não encontrado', Response::HTTP_NOT_FOUND);
        }

        if (!Storage::exists($toPath) && !Storage::copy($fromPath, $toPath)) {
            throw new \Exception('Erro ao copiar o arquivo', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $url ? $this->url($toPath) : $toPath;

    }

    /**
     * @param string $path
     * @return string
     */
    public function url(string $path): string
    {
        return URL::to(Storage::url($path));
    }


    /**
     * @param string $path
     * @param string $value
     * @param string $search
     * @return string
     */
    public function makePath(string $path, string $value, string $search): string
    {
        return str_replace('{' . $search . '}', $value, $path);
    }


}