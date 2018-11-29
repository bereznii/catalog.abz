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

    /**
     * Return group of successors.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getSuccessors(Request $request)
    {
        $successors = Employee::where('parent', $request->id)->get()->toArray();

        return json_encode($successors);
    }

    /**
     * Update position and parent of element, moved in hierarchical tree.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateHierarchy(Request $request) {

        $positions = ['President', 'First level', 'Second level', 'Third level', 'Fourth level'];

        $employee_toUpdate = Employee::find($request->id);

        if($employee_toUpdate->parent != $request->parent_id) {//to avoid saving if element is moving inside current successors group
            $new_parent = Employee::find($request->parent_id);

            $employee_toUpdate->parent = $request->parent_id;
            $employee_toUpdate->depth = $new_parent->depth + 1;
            $employee_toUpdate->position = $positions[$employee_toUpdate->depth];

            $employee_toUpdate->save();
        }
    
        return true;
    }
}
