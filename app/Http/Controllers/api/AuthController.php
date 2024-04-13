<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request, UserRepository $userRepository): JsonResponse
    {
        $email = $request->email;
        $password = $request->password;

        $user = $userRepository->search(['email' => $email]);

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->successResponse('Login success', $user);
    }

    public function register(RegisterRequest $request, UserRepository $userRepository): JsonResponse
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = $userRepository->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return $this->successResponse('Register success', $user);
    }

    private function generateToken(User $user): string
    {
        return $user->createToken('UserSession')->accessToken;
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logout']);
    }

    private function successResponse($message,$user): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'user' => $user,
            'token' => $this->generateToken($user)
        ]);
    }
}
