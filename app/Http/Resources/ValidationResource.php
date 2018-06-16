<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'data' => $this->formatMessage($this->resource->validator->errors())
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

    private function formatMessage(array $messages)
    {
        $data = [];
        foreach($messages as $input => $errors){
            foreach($errors as $text){
                $text = str_replace('.', ' ', $text);
                $text = str_replace('_', ' ', $text);
                $text = ucfirst(trim($text));
                if($text[strlen($text)-1] != '.'){
                    $text .= '.';
                }
                $data[$input][] = $text;
            }

        }


        return $data;
    }
}
