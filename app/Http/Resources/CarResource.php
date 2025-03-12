<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'model' => $this->model,
            'image_url' => $this->image_url,
            'is_available' => $this->is_available,
            'daily_rate' => $this->daily_rate,
        ];
    }
}
