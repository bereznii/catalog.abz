$(document).ready(function() {
    $('.list-group-item').on('dblclick', function(event) {
        var id = $(event.target).attr('id');

        if($('#'+id).attr('opened') == 'no') {
            $('#'+id).addClass('list-group-item-info');
            $('#'+id).attr('opened', 'yes');
            $('#'+id+' i').remove(); //replace plus with minus in next line
            $('#'+id).prepend('<i class="fas fa-minus"></i>');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:'POST',
                url:'/hierarchy_add',
                data: {
                    id: id,
                },
                success:function(data){
                    var index;
                    var arr = JSON.parse(data);

                    if( $('#successors_of_'+id).length ){
                        $('#successors_of_'+id).remove();//to avoid repeating subgroups
                    }
                    
                    $('#'+id).append('<ul class="list-group list-group-flush sortable-list" id="successors_of_'+id+'"></ul>');
                    for (index = 0; index < arr.length; ++index) {
                        $('#successors_of_'+id).append('<li class="list-group-item" id="'+arr[index].id+'" opened="no"><i class="fas fa-plus"></i>'+arr[index].position+' | '+arr[index].name+'</li>');
                    }

                    $(".sortable-list").sortable({
                        connectWith: '.sortable-list',
                        disableSelection: true,
                        revert: 200,
                        update:  function(event, ui) {
                            if (this === ui.item.parent()[0]) {//so 'update' won't fire twice

                                var new_parent_id = $(ui.item)[0].parentElement.parentElement.id;//id of new parent
                                var element_id = $(ui.item)[0].id;//id of moved element

                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    type:'POST',
                                    url:'update_hierarchy',
                                    data: {
                                        id: element_id,
                                        parent_id: new_parent_id,
                                    },
                                    success:function(data){
                                        console.log(data);
                                    }
                                });
                            }
                            
                        }
                        
                    });
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