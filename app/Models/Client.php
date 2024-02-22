<?php

namespace App\Models;

use App\Enums\RentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name'];

    public function books(){
        return $this->hasMany(BookClient::class);
    }
    public function rentBooks(){
        return $this->books()->where('status', RentStatusEnum::RENT) ;
    }
}
