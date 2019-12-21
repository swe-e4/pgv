<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'deadline',
    ];

    /**
     * groups
     *
     * @return void
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }
}
