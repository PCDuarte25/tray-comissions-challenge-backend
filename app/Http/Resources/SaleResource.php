<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'value' => $this->value,
            'commission' => $this->commission,
            'sale_date' => $this->sale_date,
            'seller' => new SellerResource($this->whenLoaded('seller')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
