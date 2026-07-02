<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * POST /api/v1/auth/register
     * Registrasi pengguna baru.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
            'data'    => [
                'user'  => new UserResource($result['user']),
                'token' => $result['token'],
                'token_type' => 'Bearer',
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * POST /api/v1/auth/login
     * Login dan dapatkan token Sanctum.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil.',
                'data'    => [
                    'user'       => new UserResource($result['user']),
                    'token'      => $result['token'],
                    'token_type' => 'Bearer',
                ],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
                'errors'  => $e->errors(),
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * POST /api/v1/auth/logout
     * Logout dan revoke token saat ini.
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
            'data'    => null,
        ]);
    }

    /**
     * GET /api/v1/auth/me
     * Data user yang sedang login.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diambil.',
            'data'    => new UserResource($request->user()),
        ]);
    }
}
