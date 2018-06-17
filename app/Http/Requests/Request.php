<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 21/02/2018
 * Time: 12:57
 */

namespace App\Http\Requests;


use Illuminate\Http\Request as RequestBase;

class Request extends RequestBase
{
    public function __construct(\Illuminate\Http\Request $request)
    {

        parent::__construct(
            $request->query->all(),
            $request->toArray(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->content
        );
    }

    public function toCollection($attributes = [])
    {
        $data = collect($this->all());
        if(count($attributes) > 0){
            return collect($data->only($attributes));
        }
        return $data;
    }
}
