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
}
