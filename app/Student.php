<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'surname', 'email', 'student_number', 'group_id',
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

    /**
     * appointments
     *
     * @return void
     */
    public function appointments()
    {
        return $this->belongsToMany('App\Appointment');
    }
}
