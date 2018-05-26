<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/05/2018
 * Time: 01:17
 */

namespace App\Exceptions;


use Throwable;

class ExceptionWithData extends \Exception
{
    private $data;

    public function __construct(string $message = "", int $code = 0, $data, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }


}
