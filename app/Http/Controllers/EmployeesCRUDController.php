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
        dd($request);
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

        return view('employees.read', compact('employee'));
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

        return view('employees.edit', compact('employee'));
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
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id . 'destroy');
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
}
