<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        //validate name, photo, salary and employment date
        $validatedData = $request->validate([
            'name' => 'bail|required|alpha|max:100',
            'employment' => 'bail|required|date_format:"Y-m-d"',
            'salary' => 'bail|required|integer|numeric',
            'photo' => 'bail|required|max:1024',
        ]);

        $positions = ['President', 'First level', 'Second level', 'Third level', 'Fourth level'];

        $employee = new Employee;

        $employee->name = $request->name;
        $employee->position = $positions[$request->position];
        $employee->salary = $request->salary;
        $employee->employment = $request->employment;

        if($request->photo) {
            $employee->photo = $request->photo->store('photos');
        }
        
        $employee->parent = $request->supervisor;
        $employee->depth = $request->position;
        
        $employee->save();

        $employee = Employee::orderBy('id', 'desc')->get()->first();
        $supervisor = Employee::where('id', $employee->parent)->select('name')->first();
        $photo_path = Storage::url($employee->photo);
        
        return view('employees.read', compact('employee', 'supervisor', 'photo_path'));
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
        $supervisor = Employee::where('id', $employee->parent)->select('name')->first();
        $photo_path = Storage::url($employee->photo);

        return view('employees.read', compact('employee', 'supervisor', 'photo_path'));
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
        $photo_path = Storage::url($employee->photo);

        return view('employees.edit', compact('employee', 'supervisors', 'photo_path'));
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
        //validate name, photo, salary and employment date
        $validatedData = $request->validate([
            'name' => 'bail|required|alpha|max:100',
            'employment' => 'bail|required|date_format:"Y-m-d"',
            'salary' => 'bail|required|integer|numeric',
            'photo' => 'bail|required|max:1024',
        ]);

        $positions = ['President', 'First level', 'Second level', 'Third level', 'Fourth level'];

        $employee = Employee::find($id);

        if($request->file('photo')) {
            Storage::delete($employee->photo);
        }

        $employee->name = $request->name;
        $employee->position = $positions[$request->position];
        $employee->salary = $request->salary;
        $employee->employment = $request->employment;

        if($request->photo) {
            $employee->photo = $request->photo->store('photos');
        }

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
