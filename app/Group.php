<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * adviser
     *
     * @return void
     */
    public function adviser()
    {
        return $this->hasOne('App\User');
    }
    /**
     * students
     *
     * @return void
     */
    public function students()
    {
        return $this->hasMany('App\Students');
    }
    
    /**
     * milestones
     *
     * @return void
     */
    public function milestones()
    {
        return $this->belongsToMany('App\Milestone');
    }

    /**
     * appointments
     *
     * @return void
     */
    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }

    /**
     * path
     *
     * @return void
     */
    public function path()
    {
        return url('/group/'.$this->id);
    }
}
