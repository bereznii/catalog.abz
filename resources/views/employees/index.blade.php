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
<script>
    $(document).ready(function(){

        //Sorting
        $(document).on('click', '.column-sort', function(){
            var column_name = $(this).attr('id');
            var order = $(this).attr('data-order');  
            var arrow = ''; 
            
            $('i.fas').remove();

            if(order == 'desc') {
                arrow = '<i class="fas fa-long-arrow-alt-up" id="arrow'+column_name+'"></i>';
                var new_order = 'asc';
            } else {
                arrow = '<i class="fas fa-long-arrow-alt-down" id="arrow'+column_name+'"></i>';
                var new_order = 'desc';
            }

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '{{route("list_sort")}}',
                method: 'POST',
                data: {column_name:column_name, order:order},
                success: function (data) {
                    $('#'+column_name).append(arrow);
                    var index;
                    var arr = JSON.parse(data);
                    $('tbody').empty();
                    for (index = 0; index < arr.length; ++index) {
                        var show_link = "/employees/"+arr[index].id;
                        var edit_link = "/employees/"+arr[index].id+"/edit";
                        var destroy_link = `<form action='/employees/`+arr[index].id+`' id="destroy_form`+arr[index].id+`" method="post" style="display: inline;">@method('DELETE')@csrf<a href=javascript:document.getElementById("destroy_form`+arr[index].id+`").submit();><i class="fas fa-trash"></i></a></form>`;
                        
                        if(!arr[index].photo) {
                            var photo_link = '';
                        } else {
                            var photo_link = `<img class="list_photo" src='/storage/`+arr[index].photo+`' title="Фото сотрудника"></br>`;
                        }
                        
                        $('tbody').append('<tr><td>'+arr[index].id+'</td><td>'+arr[index].name+'</td><td>'+arr[index].position+'</td><td>'+arr[index].salary+'</td><td>'+arr[index].employment+'</td><td><a href='+show_link+'    title="Просмотреть"><i class="fas fa-user"></i></a><a href="'+edit_link+'" title="Редактировать"><i class="fas fa-edit"></i></a>'+destroy_link+'</td><td>'+photo_link+'</td></tr>');
                    }
                    $('#'+column_name).removeAttr('data-order');
                    $('#'+column_name).attr('data-order', new_order);
                }
            })
        });

        //Searching
        $(document).on('click', '#search_btn', function(){
            var query = $('#query').val();
            $('i.fas').remove();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '{{route("list_sort")}}',
                method: 'POST',
                data: {search:query},
                success: function (data) {
                    var index;
                    var arr = JSON.parse(data);
                    $('tbody').empty();
                    for (index = 0; index < arr.length; ++index) {
                        var show_link = "/employees/"+arr[index].id;
                        var edit_link = "/employees/"+arr[index].id+"/edit";
                        var destroy_link = `<form action='/employees/`+arr[index].id+`' id="destroy_form`+arr[index].id+`" method="post" style="display: inline;">@method('DELETE')@csrf<a href=javascript:document.getElementById("destroy_form`+arr[index].id+`").submit();><i class="fas fa-trash"></i></a></form>`;
                        
                        if(!arr[index].photo) {
                            var photo_link = '';
                        } else {
                            var photo_link = `<img class="list_photo" src='/storage/`+arr[index].photo+`' title="Фото сотрудника"></br>`;
                        }
                        
                        $('tbody').append('<tr><td>'+arr[index].id+'</td><td>'+arr[index].name+'</td><td>'+arr[index].position+'</td><td>'+arr[index].salary+'</td><td>'+arr[index].employment+'</td><td><a href='+show_link+'    title="Просмотреть"><i class="fas fa-user"></i></a><a href="'+edit_link+'" title="Редактировать"><i class="fas fa-edit"></i></a>'+destroy_link+'</td><td>'+photo_link+'</td></tr>');
                    }
                }
            })
        });
    });
</script>
@endsection