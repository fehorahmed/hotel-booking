<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "room_no" => $this->room_no,
            "description" => $this->description,
            "hotel_id" => $this->hotel_id,
            "hotel" => new HotelResource($this->hotel),
            "room_category_id" => $this->room_category_id,
            "price_for_govt" => $this->price_for_govt,
            "price_for_non_govt" => $this->price_for_non_govt,
            "is_special" => $this->is_special,
            "status" => $this->status,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
        ];
    }
}
