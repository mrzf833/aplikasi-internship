<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\UserMailCreate;
use App\Mail\UserMailDelete;
use App\Mail\UserMailEdit;
use App\models\RoleUser;
use App\models\School;
use App\models\UserProfile;
use App\User;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;
use Str;

class UserController extends Controller
{
    public function user(){
        $schools = School::all();
        $students = RoleUser::where('name','Student')->first()->users()->get();
        return view('admin.users.index')->with([
            'students' => $students,
            'schools' => $schools
        ]);
    }
    public function create(){
        $schools = School::all();
        $instructors = RoleUser::where('name','Instructor')->first()->users()->get();
        $schools = $schools->implode('name','","');
        return view('admin.users.create')->with([
            'schools' => $schools,
            'instructors' => $instructors
        ]);
    }
    public function store(Request $request){
        $phone_number = preg_replace_array('/-/',[''],$request->phone_number);
        $request->merge(['phone_number' => $phone_number]);
        $this->validate($request,[
            'fullname' => 'required|not_regex:/[^a-zA-z\s]/',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'alpha_num|required',
            'asal_sekolah' => 'required',
            'selesai_magang' => 'date_format:d/m/Y|required',
            'mulai_magang' => 'date_format:d/m/Y|required|before:selesai_magang',
            'instructor' => [Rule::exists('users','id')->where('id_role',RoleUser::where('name','Instructor')->first()->id)],
            'flag' => 'in:0,1|required'
        ]);
        DB::beginTransaction();
        // function($query){
        //     $query->where('id_role',RoleUser::where('name','Instructor')->first()->id);
        // }
        try{
            $password = Str::random(10);
            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => bcrypt($password),
                'id_role' => RoleUser::where('name','Student')->first()->id,
                'flag' => $request->flag
            ]);

            $school = School::firstOrCreate(
                ['name' => $request->asal_sekolah], [
                    'name' => $request->asal_sekolah
                    ]
            );

            UserProfile::create([
                'id_user' => $user->id,
                'phone_number' => $request->phone_number,
                'id_school' => $school->id,
                'start_internship' => Carbon::createFromFormat('d/m/Y',$request->mulai_magang),
                'end_internship' => Carbon::createFromFormat('d/m/Y',$request->selesai_magang),
                'id_position' => null,
                'id_instructor' => $request->instructor
            ]);
            DB::commit();
            return redirect()->route('admin.users.index')->with('success','data student berhasil di buat');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }

    public function show($id){
        $student = RoleUser::where('name','Student')->first()->users()->findOrFail($id);
        $schools = School::all();
        $schools = $schools->implode('name','","');
        $instructors = RoleUser::where('name','Instructor')->first()->users()->get();
        return view('admin.users.edit')->with([
            'schools' => $schools,
            'student' => $student,
            'instructors' => $instructors
        ]);
    }

    public function edit(Request $request,$id){
        $phone_number = preg_replace_array('/-/',[''],$request->phone_number);
        $request->merge(['phone_number' => $phone_number]);
        $this->validate($request,[
            'fullname' => 'required|not_regex:/[^a-zA-z\s]/',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'alpha_dash|nullable',
            'phone_number' => 'alpha_num|required',
            'asal_sekolah' => 'required',
            'instructor' => [Rule::exists('users','id')->where('id_role',RoleUser::where('name','Instructor')->first()->id)],
            'selesai_magang' => 'date_format:d/m/Y|required',
            'mulai_magang' => 'date_format:d/m/Y|required|before:selesai_magang',
            'flag' => 'in:0,1|required'
        ]);
            try{
                $user = User::findOrfail($id);
                $school = School::firstOrCreate(
                    ['name' => $request->asal_sekolah], [
                        'name' => $request->asal_sekolah
                        ]
                );
        
                $user->update([
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'flag' => $request->flag
                ]);

                UserProfile::where('id_user',$id)->update([
                    'phone_number' => $request->phone_number,
                    'id_school' => $school->id,
                    'start_internship' => Carbon::createFromFormat('d/m/Y',$request->mulai_magang),
                    'end_internship' => Carbon::createFromFormat('d/m/Y',$request->selesai_magang),
                    'id_instructor' => $request->instructor
                ]);

                if(!empty($request->password)){
                    $user->update([
                        'password' => $request->password
                    ]);
                }
                DB::commit();
                return redirect()->route('admin.users.index')->with('success','data student berhasil di update');
            }catch(Exception $e){
                DB::rollBack();
                return back()->with('error',$e->getMessage());
            }
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            $user = RoleUser::where('name','Student')->first()->users()->findOrfail($id);
            foreach($user->user_reviews()->get() as $project){
                $project->projects()->first()->delete();
            }
            $user->delete();
            DB::commit();
            return back()->with('success','data student berhasil di hapus');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
