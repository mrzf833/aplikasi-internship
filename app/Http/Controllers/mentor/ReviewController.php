<?php

namespace App\Http\Controllers\mentor;

use App\Http\Controllers\Controller;
use App\models\Project;
use App\models\RoleUser;
use App\models\UserReview;
use App\User;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){
        $modals = UserReview::where('id_mentor',Auth::id())->get();
        $mentors = User::findOrfail(Auth::id())->user_mentor_profile()->get()->groupBy('name_instructor');
        return view('mentor.review.index')->with([
            'mentors' => $mentors,
            'modals' => $modals
        ]);
    }

    public function review_student(Request $request,$id){
        $this->validate($request,[
            'score' => 'in:A,B,C,D,E|required',
            'comment' => 'required'
        ]);
        DB::beginTransaction();
        try{
            $students = UserReview::where('id_mentor',Auth::id());
            $student = $students->findOrFail($id);
            $student->update([
                'score' => $request->score,
                'comment' => $request->comment
            ]);
            DB::commit();
            return back()->with('success','data berhasil di review');
        }catch(Exception $e){
            DB::rollBack();
            return back('error',$e->getMessage());
        }
    }

    public function delete_review($id){
        DB::beginTransaction();
        try{
            $students = UserReview::where('id_mentor',Auth::id());
            $student = $students->findOrFail($id);
            $student->users()->first()->projects()->detach();
            $project = UserReview::where('id_project',$student->id_project)->get(); // cari jumlah project yang ada di dalam table user reviews
            if(count($project) < '1'){
                Project::findOrFail($student->id_project)->delete();
            }
            DB::commit();
            return back()->with('success','data review berhasil di hapus');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }
}