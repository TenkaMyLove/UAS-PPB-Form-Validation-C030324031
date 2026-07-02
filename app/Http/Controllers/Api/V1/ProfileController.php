<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * GET /api/v1/profile
     * Tampilkan data profil user yang sedang login.
     */
    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Data profil berhasil diambil.',
            'data'    => new UserResource($request->user()),
        ]);
    }

    /**
     * PUT /api/v1/profile
     * Update profil user (nama, website, telp).
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $request->user()->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data'    => new UserResource($request->user()->fresh()),
        ]);
    }

    /**
     * PUT /api/v1/profile/password
     * Ganti password user.
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $request->user()->update([
            'password' => $request->password, // Di-hash otomatis oleh cast 'hashed'
        ]);

        // Revoke semua token lama agar harus login ulang
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah. Silakan login kembali.',
            'data'    => null,
        ]);
    }
}
