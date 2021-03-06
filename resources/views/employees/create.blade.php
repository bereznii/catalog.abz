@extends('layouts.app')

@section('content')
<form method="post" action='{{route("employees.store")}}' enctype="multipart/form-data">
    <div class="container col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Информация о сотруднике</div>
            <div class="panel-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                            <td>ФИО:</td>
                            <td><input class="form-control" type="text" name="name" required></td>
                        </tr>
                        <tr>
                            <td>Должность:</td>
                            <td>
                                <select class="form-control" id="position_select" name="position" required>
                                    <option value="">-</option>
                                    <option value="0">President</option>
                                    <option value="1">First level</option>
                                    <option value="2">Second level</option>
                                    <option value="3">Third level</option>
                                    <option value="4">Fourth level</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Размер заработной платы:</td>
                            <td><input class="form-control" type="number" name="salary" required></td>
                        </tr>
                        <tr>
                            <td>Дата приёма на работу:</td>
                            <td><input class="form-control" type="date" name="employment" required></td>
                        </tr>
                        <tr>
                            <td>Начальник:</td>
                            <td>
                                <select class="form-control" name="supervisor" id="supervisor_select" required>
                                    <option value="">Выберите должность</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="btn btn-success" type="submit" name="submit-btn">Сохранить</button></td>
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
                <input type="file" class="form-control-file" name="photo" id="employee_photo">
            </div>
        </div>
    </div>
</form>
<script src='/js/employees_create.js'></script>
@endsection