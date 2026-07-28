<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserRoleRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Notifications\AccountActivationInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * GET /api/users
     */
    public function index(Request $request)
    {
        $query = User::query()->with('role');

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'ilike', "%{$search}%")
                    ->orWhere('last_name', 'ilike', "%{$search}%")
                    ->orWhere('username', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->query('role_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        match ($request->query('trashed')) {
            'only' => $query->onlyTrashed(),
            'with' => $query->withTrashed(),
            default => null,
        };

        return new UserCollection($query->paginate($request->integer('per_page', 15)));
    }

    /**
     * POST /api/users
     * No password is set here: the account starts "pending" and the user
     * chooses their own password through the emailed activation link.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $activationToken = Str::random(64);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'role_id' => $data['role_id'],
            'platform_access' => $data['platform_access'],
            'status' => 'pending',
            'activation_token' => $activationToken,
            'activation_token_expires_at' => now()->addDays(3),
        ]);

        if (! empty($data['site_ids'])) {
            $user->sites()->sync($data['site_ids']);
        }

        $user->notify(new AccountActivationInvite($activationToken));

        return response()->json([
            'user' => new UserResource($user->fresh()),
            'message' => "Un email d'activation a été envoyé à l'utilisateur.",
        ], 201);
    }

    /**
     * GET /api/users/{id}
     */
    public function show(User $user)
    {
        $user->load(['role.permissions', 'sites']);

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    /**
     * PUT /api/users/{id}
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update(collect($data)->except('site_ids')->all());

        if (array_key_exists('site_ids', $data)) {
            $user->sites()->sync($data['site_ids']);
        }

        return response()->json([
            'user' => new UserResource($user->fresh()),
        ]);
    }

    /**
     * DELETE /api/users/{id}
     * Soft delete: hard deleting is blocked anyway by RESTRICT foreign keys
     * on every table referencing user_id (sales, harvests, expenses, ...).
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return response()->json([
                'message' => 'Vous ne pouvez pas supprimer votre propre compte.',
            ], 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json(null, 204);
    }

    /**
     * PATCH /api/users/{id}/restore
     */
    public function restore(User $user)
    {
        $user->restore();

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    /**
     * PATCH /api/users/{id}/activate
     * Re-enables a previously deactivated account. Distinct from the user's own
     * first-time activation (POST /api/auth/activation/{token}): a "pending" user
     * has never set a real password yet, so forcing them active here would just
     * strand them with a login that can never succeed.
     */
    public function activate(User $user)
    {
        if ($user->status === 'pending') {
            return response()->json([
                'message' => "Ce compte n'a pas encore été activé par l'utilisateur. Renvoyez-lui plutôt le lien d'activation.",
            ], 422);
        }

        $user->update(['status' => 'active']);

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    /**
     * PATCH /api/users/{id}/deactivate
     */
    public function deactivate(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return response()->json([
                'message' => 'Vous ne pouvez pas désactiver votre propre compte.',
            ], 422);
        }

        $user->update(['status' => 'inactive']);
        $user->tokens()->delete();

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    /**
     * PUT /api/users/{id}/roles
     * Kept plural in the URL to match the requested route, but a user has exactly
     * one role_id (see project decision): this replaces it rather than adding to a set.
     */
    public function updateRole(UpdateUserRoleRequest $request, User $user)
    {
        $user->update(['role_id' => $request->validated('role_id')]);

        return response()->json([
            'user' => new UserResource($user->fresh()),
        ]);
    }

    /**
     * DELETE /api/users/{id}/roles/{role}
     * Always rejected: role_id is required and unique per user, so there is no
     * "remove a role" operation that leaves the user in a valid state. Use
     * PUT /api/users/{id}/roles to assign a different role instead.
     */
    public function removeRole(User $user, Role $role)
    {
        return response()->json([
            'message' => $user->role_id === $role->id
                ? "Impossible de retirer ce rôle : chaque utilisateur doit toujours en avoir un. Utilisez PUT /api/users/{$user->id}/roles pour lui assigner un autre rôle."
                : "Cet utilisateur n'a pas ce rôle.",
        ], 422);
    }
}
