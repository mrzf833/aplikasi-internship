<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\School;
use DB;
use Exception;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required'
        ]);
        DB::beginTransaction();
        try{
            School::create([
                'name' => $request->name
            ]);
            DB::commit();
            return back()->with('success','data school berhasil di tambahkan');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }  
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            $school = School::findOrfail($id);
            $school->delete();
            DB::commit();
            return back()->with('success','data school berhasil di hapus');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }
}
