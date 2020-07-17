<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::all();
        return view('admin.projects.index')->with([
            'projects' => $projects
        ]);
    }
}
