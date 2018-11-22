@extends('layouts.app')

@section('content')
<div class="container col-md-12">
    <table class="table table-hover" id='employee_table'>
        <thead>
            <tr>
                <th><a class='column-sort' id='id' data-order='asc' href='#'>ID</a></th>
                <th><a class='column-sort' id='name' data-order='asc' href='#'>ФИО</a></th>
                <th><a class='column-sort' id='position' data-order='asc' href='#'>Должность</a></th>
                <th><a class='column-sort' id='salary' data-order='asc' href='#'>Заработная плата</a></th>
                <th><a class='column-sort' id='employment' data-order='asc' href='#'>Дата приёма на работу</a></th>
                <th>Действие</th>
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
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click', '.column-sort', function(){
            var column_name = $(this).attr('id');
            var order = $(this).attr('data-order');  
            var arrow = ''; 
            
            $('i#arrow'+column_name).remove();

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
                    //$('#employee_table').html(data);
                    $('#'+column_name).append(arrow);
                    var index;
                    var arr = JSON.parse(data);
                    $('tbody').empty();
                    for (index = 0; index < arr.length; ++index) {
                        $('tbody').append('<tr><td>'+arr[index].id+'</td><td>'+arr[index].name+'</td><td>'+arr[index].position+'</td><td>'+arr[index].salary+'</td><td>'+arr[index].employment+'</td><td></td></tr>');
                    }
                    $('#'+column_name).removeAttr('data-order');
                    $('#'+column_name).attr('data-order', new_order);
                }
            })
        });
    });
</script>
@endsection