<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found';
    protected int $status = 404;

    public function render(): JsonResponse
    {
        return response()->api($this->message,$this->status);
    }

}
