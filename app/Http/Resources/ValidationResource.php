<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ValidationResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Illuminate\Validation\ValidationException
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $response = [
            'success' => false,
            'message' => 'Dados Inválidos',
            'data' => $this->formatMessage($this->resource->validator->errors()->toArray())
        ];
        if (env('APP_ENV') != 'production') {
            $response['url'] = $request->path();
            $response['method'] = $request->getMethod();
        }

        return $response;
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     * @return void
     */
    public function withResponse($request, $response): void
    {
        $response->setStatusCode(\Illuminate\Http\Response::HTTP_BAD_REQUEST);
    }

    private function formatMessage($messages)
    {
        try{
            if(is_object($messages)){
                $messages = (array) $messages;
            }
            if(is_array($messages) || $messages instanceof Collection){
                $data = [];
                foreach($messages as $input => $errors){
                    $data[$input] = $this->formatMessage($errors);
                }

                return $data;
            }
            if(!is_string($messages)){
                return '';
            }
            $text = str_replace('.', ' ', $messages);
            $text = str_replace('_', ' ', $text);
            $text = ucfirst(trim($text));
            if($text[strlen($text)-1] != '.'){
                $text .= '.';
            }

            return $text;
        }catch(\Exception $exception){
            dd($exception);
            return '';
        }
    }
}
