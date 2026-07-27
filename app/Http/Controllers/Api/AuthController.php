<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/auth/login
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('username', $credentials['username'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Identifiants incorrects.'],
            ]);
        }

        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'username' => ['Ce compte est désactivé.'],
            ]);
        }

        $deviceName = $credentials['device_name'] ?? $request->userAgent() ?? 'api';

        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    /**
     * POST /api/auth/logout
     * Revokes only the token used for the current request.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnecté avec succès.',
        ]);
    }

    /**
     * POST /api/auth/logout-all
     * Revokes every token issued to the user (all devices/sessions).
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Déconnecté de tous les appareils.',
        ]);
    }

    /**
     * GET /api/auth/me
     * Returns the currently authenticated user from the request (no re-query).
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => new UserResource($request->user()),
        ]);
    }

    /**
     * GET /api/auth/user
     * Re-fetches the user from the database, bypassing any in-memory/stale state
     * (e.g. after an admin changed the user's role or permissions).
     */
    public function refreshUser(Request $request)
    {
        return response()->json([
            'user' => new UserResource($request->user()->fresh()),
        ]);
    }
}
