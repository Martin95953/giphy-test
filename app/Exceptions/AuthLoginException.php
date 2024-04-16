<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AuthLoginException extends Exception
{
    protected $message = 'Unauthorized';
    protected int $status = 401;

    public function render($request): JsonResponse
    {
        return response()->api($this->message,$this->status);
    }
}
