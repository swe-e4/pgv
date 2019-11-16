<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * users
     *
     * @return void
     */
    public function users()
    {
        return $this->hasMany('App\Users');
    }
}
