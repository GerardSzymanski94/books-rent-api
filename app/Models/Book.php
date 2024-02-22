<?php

namespace App\Models;

use App\Enums\RentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'author', 'year', 'publishing'];

    public function clients(){
        return $this->hasMany(BookClient::class);
    }

    public function isAvailable(){
        return !$this->clients()->where('status', RentStatusEnum::RENT)->exists();
    }

    public function rent(Client $client){
        $this->clients()->create(['client_id' => $client->id, 'status' => RentStatusEnum::RENT]);
    }

    public function return(){
        $this->clients()->where('status', RentStatusEnum::RENT)->update(['status' => RentStatusEnum::RETURN]);
    }

    public function activeRent(){
        return $this->clients()->where('status', RentStatusEnum::RENT)->first() ?? null;
    }

}
