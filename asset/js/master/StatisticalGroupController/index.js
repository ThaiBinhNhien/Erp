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

    var input_search = $('#inputLabel4').val();
    var id = $('#id').val();
    $.ajax({
        url:getListStatisticalGroup,
        data:{id: id,input_search:input_search},
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
                var amount = parseFloat(result[i]['price']);
                var group_type = "";
                var group_report = "";
                if(result[i]['group_report'] == 3 || result[i]['group_report'] == "3") {
                    group_type = "全て";
                } else if(result[i]['group_report'] == 1 || result[i]['group_report'] == "1") {
                    group_type = "日計表Ａ";
                } else if(result[i]['group_report'] == 2 || result[i]['group_report'] == "2") {
                    group_type = "日計表Ｂ";
                }
                if(result[i]['group_type'] == 1 || result[i]['group_type'] == "1") {
                    group_report = "ｺﾝﾄﾛｰﾙ";
                } else if(result[i]['group_type'] == 2 || result[i]['group_type'] == "2") {
                    group_report = "浴衣補充費";
                }

                html += '<tr data-id="'+result[i]['group_code']+'">';
                html += '<td>'+result[i]['group_code']+'</td>';
                html += '<td>'+result[i]['group_name']+'</td>';
                html += '<td>'+group_type+'</td>';
                html += '<td>'+group_report+'</td>';
                html += '<td><a data-type="'+result[i]['group_type']+'" data-schedule="'+result[i]['group_report']+'" data-name="'+result[i]['group_name']+'" data-id="'+result[i]['group_code']+'" class="btnEdit"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['group_code']+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
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

        var input_search = $('#inputLabel4').val();
        var id = $('#id').val();

        if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
            if(called_index == start_index)
                return;
            called_index = start_index;
            $.ajax({
                url:getListStatisticalGroup,
                data:{id: id, input_search:input_search,start_index:start_index},
                dataType:'json',
                method:'GET',
                success:function(result){

                    var html = '';
                    for(var i=0; i<result.length; i++){
                        var amount = parseFloat(result[i]['price']);
                        var group_type = "";
                        var group_report = "";
                        if(result[i]['group_report'] == 3 || result[i]['group_report'] == "3") {
                            group_type = "全て";
                        } else if(result[i]['group_report'] == 1 || result[i]['group_report'] == "1") {
                            group_type = "日計表Ａ";
                        } else if(result[i]['group_report'] == 2 || result[i]['group_report'] == "2") {
                            group_type = "日計表Ｂ";
                        }
                        if(result[i]['group_type'] == 1 || result[i]['group_type'] == "1") {
                            group_report = "ｺﾝﾄﾛｰﾙ";
                        } else if(result[i]['group_type'] == 2 || result[i]['group_type'] == "2") {
                            group_report = "浴衣補充費";
                        }

                        html += '<tr data-id="'+result[i]['group_code']+'">';
                        html += '<td>'+result[i]['group_code']+'</td>';
                        html += '<td>'+result[i]['group_name']+'</td>';
                        html += '<td>'+group_type+'</td>';
                        html += '<td>'+group_report+'</td>';
                        html += '<td><a data-type="'+result[i]['group_type']+'" data-schedule="'+result[i]['group_report']+'" data-name="'+result[i]['group_name']+'" data-id="'+result[i]['group_code']+'" class="btnEdit"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['group_code']+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
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
   $(this).parent().parent().attr("data-delete","1");
	$(this).parent().parent().siblings().attr("data-delete","0");  
   $(this).helloWorld(msg, null , null, {
        url: deleteStatisticalGroup,
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

    $('#id_group_code').val("");
    $('#id_group_code').prop('disabled', false);
    $('#id_set_group_code').val("");
    $('#name_group_code').val("");
    $('#myModalAdd .print-edit').hide();
    $('#myModalAdd .print-add').show();
    $('#id_group_type').val("");
    $('#id_group_schedule').val("");

    $('#myModalAdd .print-add').show();
    $('#myModalAdd .print-edit').hide();

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
    var value_type = $(this).data("type");
    var value_schedule = $(this).data("schedule"); 

    $('#id_group_code').val(value_id);
    $('#id_group_code').prop('disabled', true);
    $('#id_set_group_code').val(value_id);
    $('#name_group_code').val(value_name);
    $('#id_group_type').val(value_type);
    $('#id_group_schedule').val(value_schedule);

    $('#myModalAdd .print-add').hide();
    $('#myModalAdd .print-edit').show();

    $('#myModalAdd .modal-title-add').hide();
    $('#myModalAdd .modal-title-edit').show();
    $('#myModalAdd').modal("show"); 

});


// Add 
$(document).on("click","#btnAddGroupCode", function(){ 

    // Setting validation
    $("#form_add_set_product").validate();

    $('#name_group_code').rules('add', { required: true });
    $('#id_group_code').rules('add', VALIDATION_ID);
    $('#name_group_code').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#id_group_code').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#form_add_set_product");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var id = $("#id_group_code").val();
    var name = $("#name_group_code").val();
    var type = $("#id_group_type option:selected").val();
    var schedule = $("#id_group_schedule option:selected").val();

    // Ajax Add-Popup
    $(this).helloWorld(message_confirm_save_field ,null,null,
        {
            url:addPostStatisticalGroup,
            data:{id:id,group_name:name,group_type:type,group_report:schedule },
            error_message:message_error_ajax,
            success_callback_function:"add_record", 
            is_master: true
        }
    );
});

// Edit 
$(document).on("click","#btnEditGroupCode", function(){

    // Setting validation
    $("#form_add_set_product").validate();

    $('#name_group_code').rules('add', { required: true });
    $('#name_group_code').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#form_add_set_product");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var group_code = $("#id_set_group_code").val();
    var name = $("#name_group_code").val();
    var type = $("#id_group_type option:selected").val();
    var schedule = $("#id_group_schedule option:selected").val();

    // Ajax Edit-Popup
    $(this).helloWorld(message_confirm_save_field ,null,null,
        {
            url:editPostStatisticalGroup,
            data:{group_code:group_code,group_name:name,group_type:type,group_report:schedule },
            error_message:message_error_ajax,
            success_callback_function:"edit_record", 
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

            var id = $("#id_group_code").val();
            var name = $("#name_group_code").val();
            var schedule = $("#id_group_schedule option:selected").text();
            var type = $("#id_group_type option:selected").text();
            var schedule_id = $("#id_group_schedule option:selected").val();
            var type_id = $("#id_group_type option:selected").val();
            $("tr[data-id="+id+"]").remove();

            var html = "<tr data-id="+id +">";
			html += '<td>'+id+'</td>';
            html += '<td>'+name+'</td>';
            html += '<td>'+schedule+'</td>';
            html += '<td>'+type+'</td>';
            html += '<td><a data-type="'+type_id+'" data-schedule="'+schedule_id+'" data-name="'+name+'" data-id="'+id+'" class="btnEdit"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+id+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
			html += "</tr>";
			$('#list-table tbody').prepend(html); 
			$('#myModalAdd').modal('toggle');
        }
	}
	window.edit_record = function edit_record(data,result){ 
			$('#myModalAdd').modal('toggle');
            var id = $("#id_group_code").val();
            var name = $("#name_group_code").val();
            var schedule = $("#id_group_schedule option:selected").text();
            var type = $("#id_group_type option:selected").text();
			var editTr = $("#list-table tbody").find("tr[data-id="+id+"]");
			editTr.find("td:eq(0)").text(id);
            editTr.find("td:eq(1)").text(name);
            editTr.find("td:eq(2)").text(schedule);
            editTr.find("td:eq(3)").text(type);
    }
});