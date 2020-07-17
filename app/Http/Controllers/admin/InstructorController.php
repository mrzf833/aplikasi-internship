<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\UserMailCreate;
use App\Mail\UserMailDelete;
use App\Mail\UserMailEdit;
use App\models\RoleUser;
use App\models\UserProfile;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Mail;
use Str;

class InstructorController extends Controller
{
    public function index(){
        $instructors = RoleUser::where('name','Instructor')->first()->users()->get();
        return view('admin.instructors.index')->with([
            'instructors' => $instructors
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'fullname' => 'required|not_regex:/[^a-zA-z\s]/',
            'email' => 'required|email|unique:users,email'
        ]);
        DB::beginTransaction();
        try{
            $password = Str::random(10);
            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => bcrypt($password),
                'id_role' => RoleUser::where('name','Instructor')->first()->id,
                'flag' => '1'
            ]);
            UserProfile::create([
                'id_user' => $user->id
            ]);
            Mail::to($request->email)->send(new UserMailCreate($request,$password));
            DB::commit();
            return back()->with('success','data instructor berhasil di buat');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }

    public function edit(Request $request,$id){
        $this->validate($request,[
            'fullname' => 'required|not_regex:/[^a-zA-z\s]/',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|alpha_dash'
        ]);
        DB::beginTransaction();
        try{
            $user = RoleUser::where('name','Instructor')->first()->users()->findOrFail($id);
            $user->update([
                'fullname' => $request->fullname,
                'email' => $request->email
            ]);
            if(!empty($request->password)){
                $user->update([
                    'password' => bcrypt($request->password)
                ]);
                Mail::to($request->email)->send(new UserMailEdit($request,$request->password));
            }
            DB::commit();
            return back()->with('success','data instructor berhasil di update');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            $user = RoleUser::where('name','Instructor')->first()->users()->findOrFail($id);
            $user->delete();
            Mail::to($user->email)->send(new UserMailDelete());
            DB::commit();
            return back()->with('success','data instructor berhasil di hapus');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
