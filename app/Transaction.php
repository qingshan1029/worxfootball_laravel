<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use Notifiable;

    public $table = 'transactions';

    protected $hidden = [

    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'player_id',
        'match_id',
        'event_name',
        'datetime',
        'amount',
        'credit',
        'created_at',
        'updated_at',
    ];
}
