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
    var BM_MASTER_CHECK = "";
        if ($('#BM_MASTER_CHECK').is(":checked"))
        {
            BM_MASTER_CHECK = true;
        }
    var form_id = $('#form_id').val();
    var form_name = $('#form_name').val();
    var form_company = $('#form_company').val();
    var form_province = $('#form_province').val();
    var form_post_office = $('#form_post_office').val();
    var form_post_phone = $('#form_post_phone').val();
    var form_post_fax = $('#form_post_fax').val();
    var form_post_address = $('#form_post_address').val();

    $.ajax({
        url:getListBaseMaster,
        data:{BM_MASTER_CHECK:BM_MASTER_CHECK,form_id:form_id,name:form_name,company:form_company,province:form_province,post_office:form_post_office,phone:form_post_phone,fax:form_post_fax,address:form_post_address},
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
                html += '<td>'+result[i]['company']+'</td>';
                html += '<td>';
                if(result[i]['post_office'] != null) {
                    html +=result[i]['post_office'];
                }
                html += '</td>';
                html += '<td>';
                if(result[i]['address1'] != null) {
                    html +=result[i]['address1'];
                }
                html += '</td>';
                html += '<td>';
                if(result[i]['address2'] != null) {
                    html +=result[i]['address2'];
                }
                html += '</td>';
                html += '<td><a href="'+editBaseMaster+'?id='+result[i]['id']+'"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['id']+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
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
        var BM_MASTER_CHECK = "";
        if ($('#BM_MASTER_CHECK').is(":checked"))
        {
            BM_MASTER_CHECK = true;
        }
        var form_id = $('#form_id').val();
        var form_name = $('#form_name').val();
        var form_company = $('#form_company').val();
        var form_province = $('#form_province').val();
        var form_post_office = $('#form_post_office').val();
        var form_post_phone = $('#form_post_phone').val();
        var form_post_fax = $('#form_post_fax').val();
        var form_post_address = $('#form_post_address').val();

        if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
            if(called_index == start_index)
                return;
            called_index = start_index;
            $.ajax({
                url:getListBaseMaster,
                data:{form_id:form_id,name:form_name,company:form_company,province:form_province,post_office:form_post_office,phone:form_post_phone,fax:form_post_fax,address:form_post_address,BM_MASTER_CHECK:BM_MASTER_CHECK,start_index:start_index},
                dataType:'json',
                method:'GET',
                success:function(result){

                    var html = '';
                    for(var i=0; i<result.length; i++){
                        html += '<tr>';
                        html += '<td>'+result[i]['id']+'</td>';
                        html += '<td>'+result[i]['name']+'</td>';
                        html += '<td>'+result[i]['company']+'</td>';
                        html += '<td>';
                if(result[i]['post_office'] != null) {
                    html +=result[i]['post_office'];
                }
                html += '</td>';
                html += '<td>';
                if(result[i]['address1'] != null) {
                    html +=result[i]['address1'];
                }
                html += '</td>';
                        html += '<td>';
                if(result[i]['address2'] != null) { 
                    html +=result[i]['address2'];
                }
                html += '</td>';
                        html += '<td><a href="'+editBaseMaster+'?id='+result[i]['id']+'"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['id']+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
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
    var message_confirm = String.format(message_confirm_delete_field, $('table thead tr th:first').html()+" : "+value_id);
    $(this).parent().parent().attr("data-delete","1");
	$(this).parent().parent().siblings().attr("data-delete","0"); 
    $(this).helloWorld(message_confirm, null , null, {
        url: deleteBaseMaster,
        data:{id:value_id},
        error_message: errorAjax,
        success_callback_function:"remove_record"
    }); 
});
window.remove_record = function remove_record(){
    $("table tbody").find("tr[data-delete=1]").remove();
}