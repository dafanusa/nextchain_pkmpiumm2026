<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(6),
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => User::ROLE_USER,
        ]);

        $token = JWTAuth::login($user);

        return $this->respondWithToken($token, $user);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        return $this->respondWithToken($token, JWTAuth::user());
    }

    public function me(): JsonResponse
    {
        return response()->json(JWTAuth::user());
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(JWTAuth::refresh(), JWTAuth::user());
    }

    public function logout(): JsonResponse
    {
        JWTAuth::logout();

        return response()->json(['message' => 'Logout berhasil.']);
    }

    private function respondWithToken(string $token, ?User $user): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }
}
