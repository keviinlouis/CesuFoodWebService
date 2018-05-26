<?php
namespace App\Entities;


/**
 * App\Entities\Arquivo
 *
 * @property int $id
 * @property string $path
 * @property string $nome
 * @property string $extensao
 * @property string $url
 * @property int $tipo
 * @property string|null $descricao
 * @property int $entidade_id
 * @property string $entidade_type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $entidade
 * @property-read string $nome_com_extensao
 * @property-read mixed $nome_thumb
 * @property-read mixed $path_sem_nome
 * @property-read mixed $path_thumb
 * @property-read mixed $url_thumb
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereEntidadeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereEntidadeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereExtensao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Arquivo whereUrl($value)
 * @mixin \Eloquent
 */
class Arquivo extends Entity
{
    public static $snakeAttributes = false;

    protected $casts = [
        'tipo' => 'int',
        'entidade_id' => 'int'
    ];

    protected $fillable = [
        'nome',
        'extensao',
        'tipo',
        'path',
        'url',
        'descricao',
        'entidade_id',
        'entidade_type'
    ];

    const THUMB_PREFIX = 'thumb_';

    const TAMANHO_PEQUENO = 'P';
    const TAMANHO_ORIGINAL = 'O';

    const THUMB_WIDTH = 256;
    const THUMB_HEIGHT = 256;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entidade()
    {
        return $this->morphTo();
    }

    public function getUrlThumbAttribute(): string
    {
        $url = explode('/', $this->url);

        $thumb = Arquivo::THUMB_PREFIX.end($url);

        $url[count($url)-1] = $thumb;

        $urlThumb = implode('/', $url);

        return $urlThumb;
    }

    public function getPathThumbAttribute(): string
    {
        $path = explode('/', $this->path);

        $thumb = Arquivo::THUMB_PREFIX.end($path);

        $path[count($path)-1] = $thumb;

        $pathThumb = implode('/', $path);

        return $pathThumb;
    }

    /**
     * @return string
     */
    public function getNomeComExtensaoAttribute()
    {
        $extensao = str_replace('.', '', $this->extensao);
        return $this->nome.'.'.$extensao;
    }

    public function getPathSemNomeAttribute()
    {
        return str_replace($this->nome, '', $this->path);
    }

    public function getNomeThumbAttribute()
    {
        return Arquivo::THUMB_PREFIX.$this->nome;
    }

    public function hasThumb()
    {
        return \Storage::exists($this->pathThumb);
    }

    public function removeFile()
    {
        return \Storage::delete($this->path);
    }

    public function removeThumb()
    {
        return $this->hasThumb() && \Storage::delete($this->pathThumb);
    }

    /**
     * @param $path
     * @return $this
     * @throws \Exception
     */
    public function moveTo($path)
    {
        $this->checkDestinoExists($path);

        \Storage::move($this->path, $path.'/'.$this->nome_com_extensao);

        return $this;
    }

    /**
     * @param $path
     * @return $this
     * @throws \Exception
     */
    public function copyTo($path)
    {
        $this->checkDestinoExists($path);

        \Storage::copy($this->path, $path.'/'.$this->nome_com_extensao);

        return $this;
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public function checkDestinoExists($path)
    {
        if(!\Storage::exists($path)){
            \Storage::makeDirectory($path);
        }
    }

    public function isImage()
    {
        return in_array($this->extensao, ['jpg', 'jpeg', 'png', 'gif', 'bmp']) !== false;
    }

}
