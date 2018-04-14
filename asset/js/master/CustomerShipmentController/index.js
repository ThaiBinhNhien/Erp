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
    var id_search = $('#inputLabel3').val();
    var input_search = $('#inputLabel4').val();

    $.ajax({
        url:getListLink,
        data:{id:id_search,name:input_search},
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
                html += '<td>'+result[i]['customer_name']+'</td>';
                html += '<td><a href="'+url_edit_customer+'?id='+result[i]['id']+'"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['id']+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
                html += '</tr>';
            }
            
            $("#list-table tbody").html(html);

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
        },
        error:function(result) {
            var html = '';
            html = '<tr class="odd row-empty"><td valign="top" colspan="4" class="dataTables_empty">'+message_empty_data+'</td></tr>';
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
                        html += '<tr>';
                        html += '<td>'+result[i]['id']+'</td>';
                        html += '<td>'+result[i]['name']+'</td>';
                        html += '<td>'+result[i]['customer_name']+'</td>';
                        html += '<td><a href="'+url_edit_customer+'?id='+result[i]['id']+'"><img src="'+urlImage+'edit.png"/></a>  <a data-id="'+result[i]['id']+'" class="btnDelete"><img src="'+urlImage+'del.png"/></a></td>';
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
    $('#group_customer').val("");
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
    var value_customer = $(this).data("customer");

    $('#group_id').val(value_id);
    $('#group_id').prop('disabled', true);
    $('#id_set_category').val(value_id);
    $('#group_name').val(value_name);
    $('#group_customer').val(value_customer);

    $('#myModalAdd .print-add').hide();
    $('#myModalAdd .print-edit').show();

    $('#myModalAdd .modal-title-add').hide();
    $('#myModalAdd .modal-title-edit').show();

    $('#myModalAdd').modal("show"); 

});


// Add 
$(document).on("click","#btnAddCategory", function(){

    // Setting validation
    $("#form_add_category").validate({
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 50
            }, 800);
        }
    });

    $('#group_name').rules('add', { required: true });
    $('#group_id').rules('add', { required: true,
        number: true,
        min: -2147483648,
        max: 2147483647, });
    $('#group_customer').rules('add', { required: true });
    $('#group_name').tooltip({
        trigger: 'manual',
        placement:'right'
    });
    $('#group_id').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#group_customer').tooltip({
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
    var id = $("#group_id").val();
    var name = $("#group_name").val();
    var customer = $("#group_customer").val();

    $.ajax({
        url:addPostLink,
        data:{id:id,name:name,customer:customer },
        dataType:'json',
        method:'POST',
        success:function(result){
            if(result.success == true) {
                $(this).helloWorld(result.message, urlIndex);
            } else {
                $(this).helloWorld(result.message);
            }
        }
    });
});

// Edit 
$(document).on("click","#btnEditCategory", function(){

    // Setting validation
    $("#form_add_category").validate({
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 50
            }, 800);
        }
    });

    $('#group_name').rules('add', { required: true });
    $('#group_customer').rules('add', { required: true });
    $('#group_name').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#group_customer').tooltip({
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
    var customer = $("#group_customer").val();

    $.ajax({
        url:editPostLink,
        data:{id:id,name:name,customer:customer },
        dataType:'json',
        method:'POST',
        success:function(result){
            if(result.success == true) {
                $(this).helloWorld(result.message, urlIndex);
            } else {
                $(this).helloWorld(result.message);
            }
        }
    });
});

// Export csv
$(document).on("click", "#btnExport", function(){
    // Export
    var getUrl = url_export.split("?")[0];
    window.open(getUrl);
});


// Export csv
$('#form_import_csv').on("submit", function(e){  
    e.preventDefault();
    $.ajax({  
         url:url_import,  
         method:"POST",  
         data:new FormData(this),  
         contentType:false,
         cache:false,
         processData:false, 
         success: function(data){  
            var result = JSON.parse(data);
            if(result.success == true) {
                $(this).helloWorld(result.message, urlIndex);
            } else {
                $(this).helloWorld(result.message);
            }
         }  
    })
});  