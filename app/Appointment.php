<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start', 'end', 'group_id', 'description', 'traffic_light_status', 'rating'
    ];
    
    /**
     * group
     *
     * @return void
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
