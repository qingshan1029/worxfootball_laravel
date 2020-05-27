<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public $table = 'matches';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'host_photo',
        'host_name',
        'title',
        'start_time',
        'address',
        'reservations',
        'active',
        'rules',
        'latitude',
        'longitude',
        'credits',
        'created_at',
        'updated_at',
    ];

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartTimeAttribute($input)
    {
        if ($input != null && $input != '') {
//            $this->attributes['start_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $input)->format('Y-m-d H:i:s');
            $this->attributes['start_time'] = Carbon::createFromFormat(config('panel.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');

        } else {
            $this->attributes['start_time'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartTimeAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('panel.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('panel.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }
}
