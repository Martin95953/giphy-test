<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function show($id,UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->show($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function index(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->index();
        return response()->json($users);
    }

}
