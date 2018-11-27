@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">Информация о сотруднике</div>
        <div class="panel-body">
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
                        <td>{{$employee->name}}</td>
                    </tr>
                    <tr>
                        <td>Должность:</td>
                        <td>{{$employee->position}}</td>
                    </tr>
                    <tr>
                        <td>Размер заработной платы:</td>
                        <td>{{$employee->salary}}</td>
                    </tr>
                    <tr>
                        <td>Дата приёма на работу:</td>
                        <td>{{$employee->employment}}</td>
                    </tr>
                    <tr>
                        <td>Начальник:</td>
                        <td>@if(isset($supervisor)){{$supervisor->name}}@else - @endif</td>
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
        </div>
    </div>
</div>

@endsection