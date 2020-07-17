<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $guarded = [''];
    protected $dates = ['start_internship','end_internship'];

    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }

    public function schools(){
        return $this->belongsTo('App\models\School','id_school','id');
    }

    public function positions(){
        return $this->belongsTo('App\models\Position','id_position','id');
    }

    public function instructors(){
        return $this->belongsTo('App\User','id_instructor','id');
    }
}
