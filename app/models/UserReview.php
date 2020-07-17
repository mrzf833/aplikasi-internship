<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    protected $table = 'user_reviews';
    protected $guarded = [''];
    public function users(){
        return $this->belongsTo('App\User','id_user','id');
    }
    public function mentors(){
        return $this->belongsTo('App\User','id_mentor','id');
    }

    public function projects(){
        return $this->belongsTo('App\models\Project', 'id_project','id');
    }
}
