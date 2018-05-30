<?php
/**
 * Created by PhpStorm.
 * User: DevMaker BackEnd
 * Date: 12/04/2018
 * Time: 12:52
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait StatusScope
{
    public function scopeAtivos(Builder $query)
    {
        return $query->where('status', self::ATIVO);
    }

    public function scopeInativos(Builder $query)
    {
        return $query->where('status', self::INATIVO);
    }

    public function isStatus(int $status)
    {
        return $this->status == $status;
    }

    public function isAtivo()
    {
        return $this->isStatus(self::ATIVO);
    }

    public function isInativo()
    {
        return $this->isStatus(self::INATIVO);
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status){
            case self::ATIVO:
                return 'Ativo';
            case self::INATIVO:
                return 'Inativo';
            default:
                return '';
        }
    }
}
