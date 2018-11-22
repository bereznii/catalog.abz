<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeesListController extends Controller
{
    public function index()
    {
        $employees = Employee::where('id', '<', 30)->get();

        return view('employees_list')->with('employees', $employees);
    }

    public function getSortedList(Request $request)
    {
        if($request->order == 'desc') {
            $order = 'asc';
        } else {
            $order = 'desc';
        }
        
        if(!isset($request->column_name)) {
            $column_name = 'id';
            $order = 'asc';
            $query = '';
            $request->session()->forget('query');
        } else {
            $column_name = $request->column_name;
            $query = $request->session()->get('query');
        }
        
        if(isset($request->search)) {
            $request->session()->put('query', $request->search);
            $query = $request->search;
        }

        $employees = Employee::where('id', 'LIKE', '%'.$query.'%')
                                ->orWhere('name', 'LIKE', '%'.$query.'%')
                                ->orWhere('position', 'LIKE', '%'.$query.'%')
                                ->orWhereRaw("DATE_FORMAT(employment, '%Y-%m-%d') LIKE '%".$query."%'")
                                ->orWhere('salary', 'LIKE', '%'.$query.'%')->orderBy($column_name, $order)->limit(30)->get()->toArray();

        return json_encode($employees);
    }

}
