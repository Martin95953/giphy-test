<?php

namespace App\Http\Controllers\api;

use App\Exceptions\AuthLoginException;
use App\Exceptions\AuthLogoutException;
use App\Exceptions\UserCreateException;
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
            throw new AuthLoginException();
        }

        return $this->apiResponse('Login successful',200,$this->addTokenToUserResponse($user));
    }

    public function register(RegisterRequest $request, UserRepository $userRepository): JsonResponse
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        try{
            $user = $userRepository->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password)
            ]);
        } catch (\Exception $e) {
            throw new UserCreateException($e);
        }

        return $this->apiResponse('User created', 201,$this->addTokenToUserResponse($user));
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->token()->revoke();
        } catch (\Exception $e) {
            throw new AuthLogoutException($e);
        }

        return $this->apiResponse('Logout successful');
    }

    private function generateToken(User $user): string
    {
        return $user->createToken('UserSession')->accessToken;
    }

    private function addTokenToUserResponse($user): array
    {
        return [
            'user' => $user,
            'token' => $this->generateToken($user),
            'token_type' => 'O Auth2.0'
        ];
    }
}
