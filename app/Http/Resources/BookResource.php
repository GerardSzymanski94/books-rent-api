<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class BookResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $return = [
            'id' =>  $this->id,
            'name' =>  $this->name,
        ];
        if(!$this->isAvailable()){
            $client = $this->activeRent();
            $return['available'] = false;
            $return['client'] =
                new ClientResource($client->client);

        }else{
            $return['available'] = true;
        }

        return $return;
    }
}
