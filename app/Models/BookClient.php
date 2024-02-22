<?php

namespace App\Models;

use App\Enums\RentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookClient extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'client_id', 'status'];


    protected $casts = [
        'status' => RentStatusEnum::class
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
}
