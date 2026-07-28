<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Session\SessionCollection;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class SessionController extends Controller
{
    /**
     * GET /api/sessions
     * Lists every active token (device/session) for the authenticated user.
     */
    public function index(Request $request)
    {
        $tokens = $request->user()->tokens()->latest('last_used_at')->get();

        return response()->json([
            'sessions' => new SessionCollection($tokens),
        ]);
    }

    /**
     * DELETE /api/sessions/{token}
     * Revokes one specific session by its token id.
     */
    public function destroy(Request $request, PersonalAccessToken $token)
    {
        abort_unless(
            $token->tokenable_type === $request->user()->getMorphClass()
                && $token->tokenable_id === $request->user()->id,
            404
        );

        $token->delete();

        return response()->json([
            'message' => 'Session révoquée.',
        ]);
    }

    /**
     * DELETE /api/sessions
     * Revokes every other session but keeps the one used for this request active.
     */
    public function destroyAll(Request $request)
    {
        $request->user()->tokens()
            ->where('id', '!=', $request->user()->currentAccessToken()->id)
            ->delete();

        return response()->json([
            'message' => 'Toutes les autres sessions ont été révoquées.',
        ]);
    }
}
