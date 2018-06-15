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
            'data' => $this->resource->validator->errors()
        ];

        foreach($response['data'] as $key => $value){
            $response['data'][$key] = $this->formatMessage($value);
        }

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

    private function formatMessage(string $message)
    {
        $message = str_replace('.', ' ', $message);
        $message = str_replace('_', ' ', $message);
        $message = ucfirst(trim($message));
        if($message[strlen($message)-1] != '.'){
            $message .= '.';
        }

        return $message;
    }
}
