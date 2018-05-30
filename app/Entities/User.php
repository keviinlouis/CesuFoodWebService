<?php

namespace App\Entities;

use App\Traits\AttributesMasks;
use App\Traits\Files;
use App\Traits\Senha;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class User extends Authenticatable implements JWTSubject
{
	use SoftDeletes, AttributesMasks, Senha, Files;

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return [
            'id' => $this->getKey(),
            'class' => $this->getClassAuth()
        ];
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims() : array
    {
        return [];
    }

    abstract function getClassAuth():string;

    public function isAdmin()
    {
        return $this instanceof Administrador;
    }

    public function isCliente()
    {
        return $this instanceof Cliente;
    }
}
