<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{


    protected $fillable = [
        'reservation_id',
        'prixP',
    ];


    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
