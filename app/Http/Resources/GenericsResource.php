<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GenericsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->generic->id,
            'name' => $this->generic->name,
        ];
    }
}
