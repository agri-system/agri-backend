<?php

namespace App\Http\Resources\Roles;

use App\Http\Resources\Permission\PermissionCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'description' => $this->description,
            'users_count' => $this->when(isset($this->users_count), $this->users_count),
            'permissions' => $this->whenLoaded(
                'permissions',
                fn ($permissions) => new PermissionCollection($permissions)
            ),
        ];
    }
}
