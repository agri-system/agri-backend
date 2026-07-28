<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Permission\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * GET /api/permissions
     * Read-only catalog of every permission the system knows about
     * (permissions are seeded by developers as features are built, not created by admins at runtime).
     */
    public function index(Request $request)
    {
        $permissions = Permission::query()
            ->when($request->query('module'), fn ($query, $module) => $query->where('module', $module))
            ->orderBy('module')
            ->orderBy('action')
            ->get();

        return response()->json([
            'permissions' => new PermissionCollection($permissions),
        ]);
    }

    /**
     * GET /api/permissions/{permission}
     */
    public function show(Permission $permission)
    {
        return response()->json([
            'permission' => new PermissionResource($permission),
        ]);
    }
}
