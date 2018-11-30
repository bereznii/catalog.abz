@extends('layouts.app')

@section('content')
<div class="container col-md-12">
    <form method='post' action='{{route("list_sort")}}'>
        @csrf
        <div class="input-group add-on">
            <input class="form-control" placeholder="Search" id="query" name="search" type="text">
            <div class="input-group-btn">
                <button class="btn btn-default" id="search_btn" type="button" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
    </form>
    <div class="container col-md-12">
        <div class="col-md-10">
            <h2>Управление сотрудниками<h2>
        </div>
        <div class="bar-button col-md-2">
            <a href="{{ route('employees.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>Добавить сотрудника</a>					
        </div>
    </div>
    <table class="table table-hover" id='employee_table'>
        <thead>
            <tr>
                <th><a class='column-sort' id='id' data-order='asc' href='#'>ID</a></th>
                <th><a class='column-sort' id='name' data-order='asc' href='#'>ФИО</a></th>
                <th><a class='column-sort' id='position' data-order='asc' href='#'>Должность</a></th>
                <th><a class='column-sort' id='salary' data-order='asc' href='#'>Заработная плата</a></th>
                <th><a class='column-sort' id='employment' data-order='asc' href='#'>Дата приёма на работу</a></th>
                <th>Действие</th>
                <th>Фото</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{$employee->id}}</td>
                <td>{{$employee->name}}</td>
                <td>{{$employee->position}}</td>
                <td>{{$employee->salary}}</td>
                <td>{{$employee->employment}}</td>
                <td>
                    <a href="{{ route('employees.show', ['id' => $employee->id]) }}" 
                       title="Просмотреть">
                            <i class="fas fa-user"></i>
                    </a>
                    <a href="{{ route('employees.edit', ['id' => $employee->id]) }}"
                       title="Редактировать">
                            <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ url('/employees', ['id' => $employee->id]) }}" id="destroy_form{{$employee->id}}" method="post" style="display: inline;">
                        @method('DELETE')
                        @csrf
                        <a href="javascript:document.getElementById('destroy_form{{$employee->id}}').submit();"><i class="fas fa-trash"></i></a>
                    </form>
                </td>
                <td>@if(isset($employee->photo))<img class="list_photo" src='/storage/{{$employee->photo}}' title="Фото сотрудника"></br>@endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src='/js/employees_index.js'></script>
@endsection