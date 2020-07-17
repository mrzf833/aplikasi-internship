<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = [''];
    public function user_profiles(){
        return $this->hasMany('App\models\UserProfile','id_position','id');
    }
}
