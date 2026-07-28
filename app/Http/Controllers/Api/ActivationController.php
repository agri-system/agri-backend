<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivateAccountRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ActivationController extends Controller
{
    /**
     * GET /api/auth/activation/{token}
     * Lets the frontend validate the link before showing the "set your password" form.
     */
    public function check(string $token)
    {
        $user = $this->findValidToken($token);

        if (! $user) {
            return response()->json([
                'message' => "Ce lien d'activation est invalide ou a expiré.",
            ], 404);
        }

        return response()->json([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ]);
    }

    /**
     * POST /api/auth/activation/{token}
     * Sets the user's own password, marks the email verified, activates the
     * account, invalidates the token, and signs the user in immediately.
     */
    public function activate(ActivateAccountRequest $request, string $token)
    {
        $user = $this->findValidToken($token);

        if (! $user) {
            return response()->json([
                'message' => "Ce lien d'activation est invalide ou a expiré.",
            ], 404);
        }

        $attributes = [
            'password' => Hash::make($request->validated('password')),
            'status' => 'active',
            'email_verified_at' => now(),
            'activation_token' => null,
            'activation_token_expires_at' => null,
        ];

        if ($request->hasFile('avatar')) {
            $attributes['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->forceFill($attributes)->save();

        $apiToken = $user->createToken($request->userAgent() ?? 'api')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user->fresh()),
            'token' => $apiToken,
        ]);
    }

    private function findValidToken(string $token): ?User
    {
        return User::query()
            ->where('activation_token', $token)
            ->where('activation_token_expires_at', '>', now())
            ->first();
    }
}
