<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\models\Project;
use App\models\RoleUser;
use App\models\UserReview;
use App\User;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(){
        $projects = UserReview::where('id_user',Auth::id())->get();
        $mentors = RoleUser::where('name','Mentor')->first()->users()->get();
        return view('student.project.index')->with([
            'projects' => $projects,
            'mentors' => $mentors,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'mentor' => ['required',Rule::exists('users','id')->where('id_role',RoleUser::where('name','Mentor')->first()->id)],
            'description' => 'required',
            'url' => 'required'
        ]);

        DB::beginTransaction();
        try{
            $project = Project::create([
                'name'=> $request->name,
                'description' => $request->description,
                'url' => $request->url
            ]);
            UserReview::create([
                'id_user' => Auth::id(),
                'id_mentor' => $request->mentor,
                'id_project' => $project->id,
                'score' => '',
                'comment' => ''
            ]);
            DB::commit();
            return back()->with('success','data berhasil di buat');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }

    public function edit(Request $request,$id){
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
            'url' => 'required'
        ]);

        DB::beginTransaction();
        try{
            $user = User::findOrFail(Auth::id());
            $user = $user->user_reviews()->get();
            $project = $user->where('id_project',$id)->first();
            if(empty($project)){
                return abort(404,'404 project not found');
            }
            $project = $project->projects()->first();
            $project->update([
                'name' => $request->name,
                'description' => $request->description,
                'url' => $request->url
            ]);
            DB::commit();
            return back()->with('success','data project berhasil di perbarui');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }
}
