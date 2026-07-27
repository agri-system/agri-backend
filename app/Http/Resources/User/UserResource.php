<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Roles\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->resource->loadMissing(['role.permissions', 'permissions']);

        $permissions = $this->role->permissions
            ->merge($this->permissions)
            ->unique('id')
            ->values();

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'avatar_url' => $this->avatar_url,
            'status' => $this->status,
            'role' => new RoleResource($this->whenLoaded('role')),
            'permissions' => new PermissionCollection($permissions),
        ];
    }
}
