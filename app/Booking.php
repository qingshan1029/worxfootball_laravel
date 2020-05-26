<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use Notifiable;

    public $table = 'bookings';

    protected $hidden = [

    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'match_id',
        'player_id',
        'created_at',
        'updated_at',
    ];
}
