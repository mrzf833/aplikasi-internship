<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\Position;
use DB;
use Exception;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required'
        ]);
        DB::beginTransaction();
        try{
            Position::create([
                'name' => $request->name
            ]);
            DB::commit();
            return back()->with('success','data position berhasil di tambahkan');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id){
        $user = Position::findOrfail($id);
        $user->delete();
        return back()->with('success','data position berhasil di hapus');
    }
}
