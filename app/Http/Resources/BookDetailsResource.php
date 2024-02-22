<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class BookDetailsResource extends JsonResource
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
            'author' => $this->author,
            'year' => $this->year,
            'publishing' => $this->publishing,
        ];
        if(!$this->isAvailable()){
            $client = $this->activeRent();
            $return['available'] = false;
            $return['client'] =
                ['first_name' => $client->client->first_name, 'last_name' => $client->client->last_name];

        }else{
            $return['available'] = true;
        }

        return $return;
    }
}
