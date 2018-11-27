<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeesCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::where('id', '<', 30)->get();

        return view('employees.index')->with('employees', $employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $positions = ['President', 'First level', 'Second level', 'Third level', 'Fourth level'];

        $employee = new Employee;
        $employee->name = $request->name;
        $employee->position = $positions[$request->position];
        $employee->salary = $request->salary;
        $employee->parent = $request->supervisor;
        $employee->depth = $request->position;
        $employee->employment = $request->employment;
        $employee->save();

        $employee = Employee::orderBy('id', 'desc')->get()->first();

        return view('employees.read', compact('employee'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        $supervisor = Employee::find($employee->parent)->select('name')->get();

        return view('employees.read', compact('employee', 'supervisor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $supervisors = Employee::where('depth', $employee->depth - 1)->select('name', 'id')->get();
        
        return view('employees.edit', compact('employee', 'supervisors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $positions = ['President', 'First level', 'Second level', 'Third level', 'Fourth level'];

        $employee = Employee::find($id);

        $employee->name = $request->name;
        $employee->position = $positions[$request->position];
        $employee->salary = $request->salary;
        $employee->employment = $request->employment;
        $employee->parent = $request->supervisor;
        $employee->depth = $request->position;

        $employee->save();

        return redirect('employees');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect('employees');
    }

    /**
     * Return the specified list.
     *
     * @param  \Illuminate\Http\Request  $request
     */
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

    /**
     * Return the list of supervisor according to the chosen position.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getSupervisor(Request $request) {

        if($request->selected_position != 0) {
            $supervisors = Employee::where('depth', $request->selected_position - 1)->get()->toArray();
            return json_encode($supervisors);
        } else {
            return false;
        }
        
    }
}
