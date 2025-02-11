<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Infrastructure\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $token = $this->authService->login($request->email, $request->password);

        if (!$token) {
            return response()->json([
                'errors' => ['The provided credentials are incorrect.'],
            ], 401);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $userId = $request->user_id;
        $this->authService->logout($userId);

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
