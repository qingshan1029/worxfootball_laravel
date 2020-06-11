<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Bonus extends Model
{
    use Notifiable;

    public $table = 'bonuses';

    protected $hidden = [

    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'active',
        'from_date',
        'to_date',
        'amount',
        'created_at',
        'updated_at',
    ];
}
