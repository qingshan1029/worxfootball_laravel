<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Activity extends Model
{
    use Notifiable;

    public $table = 'activities';

    protected $hidden = [

    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'player_id',
        'type',
        'content',
        'created_at',
        'updated_at',
    ];
}
