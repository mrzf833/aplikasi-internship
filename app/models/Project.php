<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [''];
    public function user_reviews(){
        return $this->hasMany('App\User','id_project','id');
    }
}
