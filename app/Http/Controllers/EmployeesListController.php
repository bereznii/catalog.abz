<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeesListController extends Controller
{
    public function index()
    {
        $employees = Employee::where('id', '<', 100)->get();

        return view('employees_list')->with('employees', $employees);
    }

    public function getSortedList(Request $request)
    {
        if($request->order == 'desc') {
            $order = 'asc';
        } else {
            $order = 'desc';
        }
        
        $employees = Employee::orderBy($request->column_name, $order)->limit(30)->get()->toArray();

        return json_encode($employees);
    }
}
