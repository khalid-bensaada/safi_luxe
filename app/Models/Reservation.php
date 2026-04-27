<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{


    protected $fillable = [
        'user_id',
        'room_id',
        'start_Reserve',
        'end_Reserv',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function room()
    {
        return $this->belongsTo(Room::class);
    }


    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
