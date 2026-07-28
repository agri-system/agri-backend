<?php

namespace App\Http\Resources\Permission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'module' => $this->module,
            'action' => $this->action,
            // convenience key for simple frontend checks, e.g. permissions.includes('stocks.read')
            'name' => "{$this->module}.{$this->action}",
        ];
    }
}
