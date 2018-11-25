@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">Информация о сотруднике</div>
        <div class="panel-body">
            <form method="post" action='{{route("employees.create")}}'>
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
                        <td>ФИО:</td>
                        <td><input class="form-control" type="text" name="name" required></td>
                    </tr>
                    <tr>
                        <td>Должность:</td>
                        <td>
                            <select class="form-control" name="position" required>
                                <option value="President">President</option>
                                <option value="First level">First level</option>
                                <option value="Second level">Second level</option>
                                <option value="Third level">Third level</option>
                                <option value="Fourth level">Fourth level</option>
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
                            <select class="form-control" name="manager" required>
                                <option value="">MANAGER</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button class="btn btn-success" type="submit" name="submit-btn">Сохранить</button></td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>
    </div>       
</div>
<div class="container col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">Фото сотрудника</div>
        <div class="panel-body">
            <img src="" title="Фото сотрудника"></br>
            <input type="file" class="form-control-file" name="photo" id="employee_photo">
        </div>
    </div>
</div>

@endsection