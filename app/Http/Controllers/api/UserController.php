<?php

namespace App\Http\Controllers\api;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function show($id,UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->show($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $this->apiResponse("Show user ID: $id",200,$user);
    }

    public function index(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->index();
        return $this->apiResponse('List of users',200,$users);
    }

}
