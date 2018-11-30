@extends('layouts.app')

@section('content')
<form method="post" action='{{route("employees.update", $employee->id)}}' enctype="multipart/form-data">
    <div class="container col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Информация о сотруднике</div>
            <div class="panel-body">
                
                @method('PUT')
                @csrf
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Поле</th>
                            <th>Данные</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ID</td>
                            <td>{{$employee->id}}</td>
                        </tr>
                        <tr>
                            <td>ФИО:</td>
                            <td><input class="form-control" type="text" name="name" value="{{$employee->name}}" required></td>
                        </tr>
                        <tr>
                            <td>Должность:</td>
                            <td>
                                <select class="form-control" name="position" id="position_select" required>
                                    <option value="0" @if($employee->position == 'President') selected @endif>President</option>
                                    <option value="1" @if($employee->position == 'First level') selected @endif>First level</option>
                                    <option value="2" @if($employee->position == 'Second level') selected @endif>Second level</option>
                                    <option value="3" @if($employee->position == 'Third level') selected @endif>Third level</option>
                                    <option value="4" @if($employee->position == 'Fourth level') selected @endif>Fourth level</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Размер заработной платы:</td>
                            <td><input class="form-control" type="number" name="salary" value="{{$employee->salary}}" required></td>
                        </tr>
                        <tr>
                            <td>Дата приёма на работу:</td>
                            <td><input class="form-control" type="date" name="employment" value="{{$employee->employment}}" required></td>
                        </tr>
                        <tr>
                            <td>Начальник:</td>
                            <td>
                                <select class="form-control" name="supervisor" id="supervisor_select" required>
                                    @if($employee->depth == '0')
                                        <option value="0">-</option>
                                    @else
                                        @foreach($supervisors as $supervisor)
                                        <option value="{{$supervisor->id}}" @if($supervisor->id == $employee->parent) selected @endif>{{$supervisor->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="btn btn-success" type="submit">Сохранить</button></td>
                        </tr>
                    </tbody>
                    </table>
                
            </div>
        </div>       
    </div>
    <div class="container col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Фото сотрудника</div>
            <div class="panel-body">
                @if(isset($employee->photo))<img src='{{$photo_path}}' title="Фото сотрудника"></br>@endif
                <input type="file" class="form-control-file" name="photo" id="employee_photo">
            </div>
        </div>
    </div>
</form>
<script src='/js/employees_edit.js'></script>
@endsection