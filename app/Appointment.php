<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * group
     *
     * @return void
     */
    public function group()
    {
        return $this->hasOne('App\Group');
    }
}
