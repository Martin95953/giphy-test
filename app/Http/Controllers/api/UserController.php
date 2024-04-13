<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repository\UserRepository;

class UserController extends Controller
{
    public function show(UserRepository $userRepository): \Illuminate\Http\JsonResponse
    {
        $user_session = auth()->user();
        $user = $userRepository->show($user_session->id);
        return response()->json($user);
    }

    public function index(UserRepository $userRepository): \Illuminate\Http\JsonResponse
    {
        $users = $userRepository->index();
        return response()->json($users);
    }

}
