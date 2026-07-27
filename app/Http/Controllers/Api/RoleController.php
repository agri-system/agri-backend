<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\SyncRolePermissionsRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Roles\RoleCollection;
use App\Http\Resources\Roles\RoleResource;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * GET /api/roles
     */
    public function index()
    {
        $roles = Role::withCount('users')->orderBy('name')->get();

        return response()->json([
            'roles' => new RoleCollection($roles),
        ]);
    }

    /**
     * POST /api/roles
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());

        return response()->json([
            'role' => new RoleResource($role),
        ], 201);
    }

    /**
     * GET /api/roles/{role}
     */
    public function show(Role $role)
    {
        $role->load('permissions');

        return response()->json([
            'role' => new RoleResource($role),
        ]);
    }

    /**
     * PUT /api/roles/{role}
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return response()->json([
            'role' => new RoleResource($role),
        ]);
    }

    /**
     * DELETE /api/roles/{role}
     */
    public function destroy(Role $role)
    {
        if ($role->users()->exists()) {
            return response()->json([
                'message' => 'Impossible de supprimer ce rôle : des utilisateurs y sont encore rattachés.',
            ], 409);
        }

        $role->delete();

        return response()->json(null, 204);
    }

    /**
     * GET /api/roles/{role}/permissions
     */
    public function permissions(Role $role)
    {
        return response()->json([
            'permissions' => new PermissionCollection($role->permissions),
        ]);
    }

    /**
     * PUT /api/roles/{role}/permissions
     */
    public function syncPermissions(SyncRolePermissionsRequest $request, Role $role)
    {
        $role->permissions()->sync($request->validated('permission_ids'));

        return response()->json([
            'permissions' => new PermissionCollection($role->permissions()->get()),
        ]);
    }
}
