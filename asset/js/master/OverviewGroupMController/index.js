// Ajax select
var called_index = 0;
$(document).ready(function(){
    showList();
}); 

// Search
$(document).on("click","#btnSearch", function(){
    showList();
});

// Show list
function showList(val_async){
    // value for async
    if(val_async == "" || val_async == null) {
        val_async = true;
    } else {
        val_async = false;
    }

    var id_search = $('#inputLabel3').val();
    var input_search = $('#inputLabel4').val();

    $.ajax({
        url:getListLink,
        data:{id:id_search,name:input_search},
        async:val_async,
        dataType:'json',
        method:'GET',
        success:function(result){
            var tables = $.fn.dataTable.fnTables(true);

            $(tables).each(function () {
                $(this).dataTable().fnDestroy();
            });
            var html = '';
            for(var i=0; i<result.length; i++){
                html += '<tr data-id="'+result[i]['id']+'">';
                html += '<td>'+result[i]['id']+'</td>';
                html += '<td>'+result[i]['name']+'</td>';
                html += '<td><a data-id="'+result[i]['id']+'" data-name="'+result[i]['name']+'" class="btnEdit"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['id']+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
                html += '</tr>';
            }

            
            $("#list-table tbody").html(html);

            //if(isDatatable == true) {
                $("#list-table table").DataTable( {
                    "scrollY":        "360px",
                    "scrollCollapse": true,
                    "paging":         false,
                    responsive: true,
                    searching: false, paging: false,
                    "ordering": false,
                    "info":     false
                });
                called_index = 0;
                renewScroll();
            //}
        },
        error:function(result) {
            var html = '';
            html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            $("#list-table tbody").html(html);
        }
    });
}

// Scroll
function renewScroll(){
    $('#list-table .dataTables_scrollBody').on('scroll', function() {
        var start_index = $('#list-table tbody tr').length;

        var id_search = $('#inputLabel3').val();
    var input_search = $('#inputLabel4').val();

        if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
            if(called_index == start_index)
                return;
            called_index = start_index;
            $.ajax({
                url:getListLink,
                data:{id:id_search,name:input_search,start_index:start_index},
                dataType:'json',
                method:'GET',
                success:function(result){

                    var html = '';
                    for(var i=0; i<result.length; i++){
                        html += '<tr data-id="'+result[i]['id']+'">';
                        html += '<td>'+result[i]['id']+'</td>';
                        html += '<td>'+result[i]['name']+'</td>';
                        html += '<td><a data-id="'+result[i]['id']+'" data-name="'+result[i]['name']+'" class="btnEdit"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['id']+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
                        html += '</tr>';
                    }
                    
                $("#list-table tbody").append(html);
                // Adjust
                var table = $('#list-table table').DataTable();
                table.columns.adjust();

                }
            });
        }
    });
     
}

// Click to delete
$(document).on("click",".btnDelete",function(){
    var value_id = $(this).data("id");
    var msg = String.format(message_confirm_delete_field, $('table thead tr th:first').html()+" : "+ value_id);
    //message_confirm_delete_field = String.format(message_confirm_delete_field, "商品コード : "+value_id);
    $(this).parent().parent().attr("data-delete","1");
	$(this).parent().parent().siblings().attr("data-delete","0"); 
    $(this).helloWorld(msg, null , null, {
        url: deleteLink,
        data:{id:value_id},
        error_message: errorAjax,
        success_callback_function:"remove_record"
    }); 
});
window.remove_record = function remove_record(){
    $("table tbody").find("tr[data-delete=1]").remove();
}

// Click to delete
$(document).on("click","#btnInsert",function(){
    $("form .tooltip").remove();
    $("form")[0].reset();
    
    $('#group_id').val("");
    $('#group_id').prop('disabled', false);
    $('#group_name').val("");
    $('#group_weight').val("");
    $('#group_type').val("");
    $('#myModalAdd .print-edit').hide();
    $('#myModalAdd .print-add').show();
    $('#myModalAdd .modal-title-add').show();
    $('#myModalAdd .modal-title-edit').hide();
    $('#myModalAdd').modal("show");

});

// Click to edit
$(document).on("click",".btnEdit",function(){
    $("form .tooltip").remove();
    $("form")[0].reset();

    var value_id = $(this).data("id");
    var value_name = $(this).data("name");
    var value_weight = $(this).data("weight");
    var value_type = $(this).data("type");

    $('#group_id').val(value_id);
    $('#group_id').prop('disabled', true);
    $('#id_set_category').val(value_id);
    $('#group_name').val(value_name);
    $('#group_weight').val(value_weight);
    $('#group_type').val(value_type);

    $('#myModalAdd .print-add').hide();
    $('#myModalAdd .print-edit').show();
    $('#myModalAdd .modal-title-add').hide();
    $('#myModalAdd .modal-title-edit').show();
    $('#myModalAdd').modal("show"); 

});


// Add 
$(document).on("click","#btnAddCategory", function(){

    // Setting validation
    $("#form_add_category").validate();

    $('#group_name').rules('add', { required: true });
    $('#group_id').rules('add', VALIDATION_ID);
    $('#group_name').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#group_id').tooltip({
        trigger: 'manual',
        placement:'top'
    });

    //Show loading display here
    var form = $("#form_add_category");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var id = $("#group_id").val();
    var name = $("#group_name").val();

    // Ajax Add-Popup
    $(this).helloWorld(message_confirm_save_field ,null,null,
        {
            url:addPostLink,
            data:{id:id,name:name }, 
            error_message:message_error_ajax,
            success_callback_function:"add_record", 
            is_master: true
        }
    );

});

$(document).ready(function(){
	window.add_record = function add_record(data,result){
        if(result.success == true) {
            // reset data list
            $('form')[0].reset();
            showList("false");

            var id = $("#group_id").val();
            var name = $("#group_name").val();
            $("tr[data-id="+id+"]").remove();
            
            var html = "<tr data-id="+id +">";
			html += '<td>'+id+'</td>';
			html += '<td>'+name+'</td>';
            html += '<td><a data-id="'+id+'" data-name="'+name+'" class="btnEdit"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+id+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
			html += "</tr>";
			$('#list-table tbody').prepend(html); 
			$('#myModalAdd').modal('toggle');
        }
	}
	window.edit_record = function edit_record(data,result){ 
			$('#myModalAdd').modal('toggle');
            var id = $("#group_id").val();
            var name = $("#group_name").val();
			var editTr = $("#list-table tbody").find("tr[data-id="+id+"]");
			editTr.find("td:eq(0)").text(id);
			editTr.find("td:eq(1)").text(name);
    }
});

// Edit 
$(document).on("click","#btnEditCategory", function(){

    // Setting validation
    $("#form_add_category").validate();

    $('#group_name').rules('add', { required: true });
    $('#group_name').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#form_add_category");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var id = $("#id_set_category").val();
    var name = $("#group_name").val();

    // Ajax Edit-Popup
    $(this).helloWorld(message_confirm_save_field ,null,null,
        {
            url:editPostLink,
            data:{id:id,name:name }, 
            error_message:message_error_ajax,
            success_callback_function:"edit_record", 
            is_master: true
        }
    );
});