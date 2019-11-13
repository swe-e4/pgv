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
}
