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
            url: '/list_sort',
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
                    var destroy_link = `<form action='/employees/`+arr[index].id+`' id="destroy_form`+arr[index].id+`" method="post" style="display: inline;"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="`+$('meta[name="csrf-token"]').attr('content')+`"><a href=javascript:document.getElementById("destroy_form`+arr[index].id+`").submit();><i class="fas fa-trash"></i></a></form>`;
                    
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
            url: '/list_sort',
            method: 'POST',
            data: {search:query},
            success: function (data) {
                var index;
                var arr = JSON.parse(data);
                $('tbody').empty();
                for (index = 0; index < arr.length; ++index) {
                    var show_link = "/employees/"+arr[index].id;
                    var edit_link = "/employees/"+arr[index].id+"/edit";
                    var destroy_link = `<form action='/employees/`+arr[index].id+`' id="destroy_form`+arr[index].id+`" method="post" style="display: inline;"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="`+$('meta[name="csrf-token"]').attr('content')+`"><a href=javascript:document.getElementById("destroy_form`+arr[index].id+`").submit();><i class="fas fa-trash"></i></a></form>`;
                    
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