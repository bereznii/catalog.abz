$(document).ready(function(){
    $( "#position_select" ).change(function() {
        var selected_position = $(this).val();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/get_supervisor',
            method: 'POST',
            data: {selected_position:selected_position},
            success: function (data) {
                var arr = JSON.parse(data);
                $('#supervisor_select').empty();
                for (index = 0; index < arr.length; ++index) {
                    if('{{$employee->position}}' == arr[index].position) var str = 'selected';
                    $('#supervisor_select').append('<option value="'+arr[index].id+'" '+str+'>'+arr[index].name+'</option>');
                }
            },
            error: function (data) {
                $('#supervisor_select').empty();
                $('#supervisor_select').append('<option value="0">-</option>');  
            }
        })
    });
});