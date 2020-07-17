<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\models\RoleUser;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){
        $students = RoleUser::where('name','Instructor')->first()->users()->findOrFail(Auth::id())->instructor_profile()->get();
        return view('instructor.review_student.index')->with([
            'students' => $students
        ]);
    }
}
