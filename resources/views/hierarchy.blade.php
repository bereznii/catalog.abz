@extends('layouts.app')

@section('content')
<div class="container col-md-12">
    <ul class="list-group list-group-flush">
        <li href="#" class="list-group-item" id="{{$president->id}}" opened="no"><i class="fas fa-plus"></i>{{$president->position}} | {{$president->name}}
        </li>
    </ul>
</div>

    <script>
    $(document).ready(function() {
        $('.list-group-item').on('click', function(event) {
            var id = $(event.target).attr('id');

            if($('#'+id).attr('opened') == 'no') {
                $('#'+id).addClass('list-group-item-info');
                $('#'+id).attr('opened', 'yes');
                $('#'+id+' i').remove(); //replace plus with minus in next line
                $('#'+id).prepend('<i class="fas fa-minus"></i>');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:'POST',
                    url:'{{route("add_level")}}',
                    data: {
                        id: id,
                    },
                    success:function(data){
                        var index;
                        var arr = JSON.parse(data);

                        if( $('#successors_of_'+id).length ){
                            $('#successors_of_'+id).remove();//to avoid repeating subgroups
                        }
                        
                        $('#'+id).append('<ul class="list-group list-group-flush" id="successors_of_'+id+'"></ul>');
                        for (index = 0; index < arr.length; ++index) {
                            $('#successors_of_'+id).append('<li href="#" class="list-group-item" id="'+arr[index].id+'" opened="no"><i class="fas fa-plus"></i>'+arr[index].position+' | '+arr[index].name+'</li>');
                        }
                    }
                });
            } else {
                $('#'+id).toggleClass('list-group-item-info');
                $('#'+id).attr('opened', 'no');
                $('#'+id+' i').remove();
                $('#'+id).prepend('<i class="fas fa-plus"></i>');
                $('#'+id+' ul#successors_of_'+id).remove();
            }
        });
    });
    </script>
@endsection