<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserCreateException extends Exception
{
    protected $message = 'User creation failed';
    protected int $status = 500;
    private Throwable $detailedError;

    public function __construct(Throwable $detailedError)
    {
        $this->detailedError = $detailedError;
    }

    public function render(): JsonResponse
    {
        return response()->api($this->message,$this->status,['error' => $this->detailedError->getMessage()]);
    }

}
