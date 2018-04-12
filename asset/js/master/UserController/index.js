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
function showList(){
    var input_search1 = $('#inputLabel1').val(); 
    var input_search2 = $('#inputLabel2').val();
    var input_search3 = $('#inputLabel3').val();
    $.ajax({
        url:getListMasterUser,
        data:{username:input_search1,name:input_search2,base:input_search3},
        dataType:'json',
        method:'GET',
        success:function(result){
            var tables = $.fn.dataTable.fnTables(true);

            $(tables).each(function () {
                $(this).dataTable().fnDestroy();
            });
            var html = '';
            for(var i=0; i<result.length; i++){
                html += '<tr>';
                html += '<td>'+result[i]['id']+'</td>';
                html += '<td>'+result[i]['name']+'</td>';
                if(result[i]['shimei'] != null) {
                    html += '<td>'+result[i]['shimei']+'</td>';
                } else {
                    html += '<td></td>';
                }
                html += '<td>'+result[i]['base_name']+'</td>';
                if(result[i]['address'] != null) {
                    html += '<td>'+result[i]['address']+'</td>';
                } else {
                    html += '<td></td>';
                }
                 html += '<td>'+result[i]['date']+'</td>';
                html += '<td><a href="'+editMasterUser+'?i='+result[i]['id']+'"><img src="'+urlImage+'edit.png"/></a> ';
                if(result[i]['id'] != user_id) {
                html += '<a data-id="'+result[i]['id']+'" class="btnDeleteUser" ><img src='+urlImage+'del.png></a>';
                }else {
                    html += '<i data-id="'+result[i]['id']+'" ><img class="__web-inspector-hide-shortcut__" src='+urlImage+'del.png></i>';
                }
                html += '</td>';
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
           // }
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

        var input_search1 = $('#inputLabel1').val(); 
        var input_search2 = $('#inputLabel2').val();
        var input_search3 = $('#inputLabel3').val();

        if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
            if(called_index == start_index)
                return;
            called_index = start_index;
            $.ajax({
                url:getListMasterUser,
                data:{username:input_search1,name:input_search2,base:input_search3,start_index:start_index},
                dataType:'json',
                method:'GET',
                success:function(result){

                var html = '';
                for(var i=0; i<result.length; i++){
                    html += '<tr>';
                    html += '<td>'+result[i]['id']+'</td>';
                    html += '<td>'+result[i]['name']+'</td>';
                    if(result[i]['shimei'] != null) {
                        html += '<td>'+result[i]['shimei']+'</td>';
                    } else {
                        html += '<td></td>';
                    }
                    html += '<td>'+result[i]['base_name']+'</td>';
                    if(result[i]['address'] != null) {
                        html += '<td>'+result[i]['address']+'</td>';
                    } else {
                        html += '<td></td>';
                    }
                    html += '<td>'+result[i]['date']+'</td>';
                    html += '<td><a href="'+editMasterUser+'?i='+result[i]['id']+'"><img src="'+urlImage+'edit.png"/></a> ';
                if(result[i]['id'] != user_id) {
                html += '<a data-id="'+result[i]['id']+'" class="btnDeleteUser" ><img src='+urlImage+'del.png></a>';
                } else {
                    html += '<i data-id="'+result[i]['id']+'" ><img class="__web-inspector-hide-shortcut__" src='+urlImage+'del.png></i>';
                }
                html += '</td>';
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
$(document).on("click",".btnDeleteUser",function(){
    var value_id = $(this).data("id");
    var msg = String.format(message_confirm_delete_field, $('table thead tr th:first').html()+" : "+ value_id);
    $(this).parent().parent().attr("data-delete","1");
	$(this).parent().parent().siblings().attr("data-delete","0");
    $(this).helloWorld(msg, null , null, {
        url: deleteMasterUser,
        data:{id:value_id},
        error_message: errorAjax,
        success_callback_function:"remove_record"
    }); 
});
window.remove_record = function remove_record(){
    $("table tbody").find("tr[data-delete=1]").remove();
}