<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index() {
        return Project::with('tasks')->get();
    }

    public function store(Request $request) {
        if(auth()->user()->role !== 'admin'){
            return response()->json(['error'=>'Forbidden'],403);
        }

        return Project::create([
            'name'=>$request->name,
            'created_by'=>auth()->id()
        ]);
    }
}
