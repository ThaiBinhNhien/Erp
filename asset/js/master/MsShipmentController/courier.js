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
    var input_search_id = $('#inputLabel3').val();
    var input_search_name = $('#inputLabel4').val();

    $.ajax({
        url:getListClassifition,
        data:{id:input_search_id,name:input_search_name},
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
                html += '<tr>';
                html += '<td>'+result[i]['id']+'</td>';
                html += '<td>'+result[i]['name']+'</td>';
                html += '<td>'+result[i]['number_container']+'</td>';
                html += '<td>'+result[i]['number_truck']+'</td>';
                html += '<td>'+result[i]['number_max_truck']+'</td>';
                html += '<td><a href="'+editListClassifition+'?id='+result[i]['id']+'"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['id']+'" class="btnDeletePrice"><img src="'+urlImage+'del.png"/></a></td>';
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

        var input_search_id = $('#inputLabel3').val();
        var input_search_name = $('#inputLabel4').val();

        if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
            if(called_index == start_index)
                return;
            called_index = start_index;
            $.ajax({
                url:getListClassifition,
                data:{id:input_search_id,name:input_search_name,start_index:start_index},
                dataType:'json',
                method:'GET',
                success:function(result){

                var html = '';
                for(var i=0; i<result.length; i++){
                    var amount = parseFloat(result[i]['price']);
                    html += '<tr>';
                    html += '<td>'+result[i]['id']+'</td>';
                    html += '<td>'+result[i]['name']+'</td>';
                    html += '<td>'+result[i]['number_container']+'</td>';
                    html += '<td>'+result[i]['number_truck']+'</td>';
                    html += '<td>'+result[i]['number_max_truck']+'</td>';
                    html += '<td><a href="'+editListClassifition+'?id='+result[i]['id']+'"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['id']+'" class="btnDeletePrice"><img src="'+urlImage+'del.png"/></a></td>';
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
$(document).on("click",".btnDeletePrice",function(){
    var value_id = $(this).data("id");
    var message_confirm = String.format(message_confirm_delete_field, $('table thead tr th:first').html()+" : "+value_id);
    $(this).parent().parent().attr("data-delete","1");
	$(this).parent().parent().siblings().attr("data-delete","0"); 
    $(this).helloWorld(message_confirm, null , null, {
        url: deleteListClassifition,
        data:{id:value_id},
        error_message: errorAjax,
        success_callback_function:"remove_record"
    }); 
});
window.remove_record = function remove_record(){
    $("table tbody").find("tr[data-delete=1]").remove();
}