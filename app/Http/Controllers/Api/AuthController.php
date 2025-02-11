<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Infrastructure\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {

        $token = $this->authService->login($request->email, $request->password);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
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

    public function verifyToken(Request $request)
    {
        $token = $request->bearerToken();

        if (!$this->authService->checkToken($token)) {
            return response()->json([
                'message' => 'Token not found or invalid.',
            ], 401);
        }

        return response()->json([
            'message' => 'Token verified successfully.',
        ]);
    }
}
