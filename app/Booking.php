<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use SoftDeletes, Notifiable;

    public $table = 'bookings';

    protected $hidden = [

    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $fillable = [
        'match_id',
        'player_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
