<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'email', 'password','id_role','flag'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function user_reviews(){
        return $this->hasMany('App\models\UserReview','id_user','id');
    }

    public function mentor_reviews(){
        return $this->hasMany('App\models\UserReview','id_mentor','id');
    }

    public function instructor_profile(){
        return $this->hasMany('App\models\UserProfile','id_instructor','id');
    }

    public function user_profiles(){
        return $this->hasMany('App\models\UserProfile','id_user','id');
    }

    public function role_users(){
        return $this->belongsTo('App\models\RoleUser','id_role','id');
    }

    public function user_mentor_profile(){
        return $this->hasMany('App\models\UserReview','id_mentor','id')->join('users','user_reviews.id_user','=','users.id')->select('*','user_reviews.id as id')->join('user_profiles','users.id','=','user_profiles.id_user')->join('users as user_instructor','user_profiles.id_instructor','=','user_instructor.id')->select('user_reviews.*','user_instructor.fullname as name_instructor');
    }

    public function projects(){
        return $this->belongsToMany('App\models\Project', 'user_reviews','id_user','id_project');
    }
}
