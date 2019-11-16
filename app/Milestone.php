<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
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
