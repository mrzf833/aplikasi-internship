<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\UserMailCreate;
use App\Mail\UserMailDelete;
use App\Mail\UserMailEdit;
use App\models\Position;
use App\models\RoleUser;
use App\models\UserProfile;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Mail;
use Str;

class MentorController extends Controller
{
    public function index(){
        $positions = Position::all();
        $mentors = RoleUser::where('name','Mentor')->first()->users()->get();
        return view('admin.mentors.index')->with([
            'positions' => $positions,
            'mentors' => $mentors
        ]);
    }

    public function create(){
        $positions = Position::all();
        return view('admin.mentors.create')->with([
            'positions' => $positions
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'fullname' => 'required|not_regex:/[^a-zA-z\s]/',
            'email' => 'email|required|unique:users,email',
            'position' => 'required|exists:positions,id'
        ]);
        DB::beginTransaction();
        try{
            $password = Str::random(10);
            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => bcrypt($password),
                'id_role' => RoleUser::where('name','Mentor')->first()->id,
                'flag' => '1'
            ]);
            UserProfile::create([
                'id_user' => $user->id,
                'id_position' => $request->position
            ]);
            Mail::to($request->email)->send(new UserMailCreate($request,$password));
            DB::commit();
            return redirect()->route('admin.mentors.index')->with('success','data mentor berhasil di tambahkan');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }

    public function show($id){
        $mentor = User::findOrfail($id);
        $positions = Position::all();
        return view('admin.mentors.edit')->with([
            'mentor' => $mentor,
            'positions' => $positions
        ]);
    }

    public function edit(Request $request,$id){
        $this->validate($request,[
            'fullname' => 'required|not_regex:/[^a-zA-z\s]/',
            'email' => 'email|required|unique:users,email,' . $id,
            'password' => 'alpha_dash|nullable',
            'position' => 'required|exists:positions,id'
        ]);

        DB::beginTransaction();
        try{
            $user = User::findOrfail($id);
            $user->update([
                'fullname' => $request->fullname,
                'email' => $request->email,
            ]);
            $user->user_profiles()->update([
                'id_position' => $request->position
            ]);
            if(!empty($request->password)){
                $user->update([
                    'password' => bcrypt($request->password)
                ]);
                Mail::to($request->email)->send(new UserMailEdit($request,$request->password));
            }
            DB::commit();
            return redirect()->route('admin.mentors.index')->with('success','data mentor berhasil di update');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            $user = RoleUser::where('name','Mentor')->first()->users()->findOrfail($id);
            $user->delete();
            Mail::to($user->email)->send(new UserMailDelete());
            DB::commit();
            return back()->with('success','data Mentor berhasil di hapus');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }
}
