<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    

    protected $fillable = [
        'capacity',
        'imageRoom',
        'prixRoom',
        'description',
        'numberRoom',
        'status',
    ];

    
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'room_id', 'idRoom');
    }

    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'room_id', 'idRoom');
    }
}