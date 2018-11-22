<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class HierarchyController extends Controller
{
    public function index()
    {
        $president = Employee::where('position', 'President')->first();

        return view('hierarchy')->with('president', $president);
    }

    public function getSuccessors(Request $request)
    {
        $successors = Employee::where('parent', $request->id)->get()->toArray();

        return json_encode($successors);
    }
}
