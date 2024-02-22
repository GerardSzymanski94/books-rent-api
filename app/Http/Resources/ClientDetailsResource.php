<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $return = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
        if($this->rentBooks()->exists()){
            $return['books'] = $this->rentBooks->map(function($item){
                return ['id' => $item->book->id, 'name' => $item->book->name];
            });
        }

        return $return;
    }
}
