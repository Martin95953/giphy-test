<?php

namespace App\Exceptions;

use Exception;

class GifApiException extends Exception
{
    private $data;
    private $msg;

    public function __construct($code, $message, $data)
    {
        parent::__construct($message, $code);
        $this->data = json_decode($data)->meta;
        $this->msg = $this->data->msg;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMsg(): string
    {
        return $this->msg;
    }
}
