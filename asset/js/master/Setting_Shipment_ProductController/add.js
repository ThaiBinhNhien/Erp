var called_index = 0;
$(document).ready(function(){
    LoadData();
    
});

// Load Data
function LoadData(){
	$.ajax({
		url:productViewUrl,
		data:{type_product:2,product_id:"",supplier:"",product_name:"",t_category:"",
			category:"",t_catalogue:"",
			  catalogue:"",start_index:0,special:false},
		dataType:'json',
		method:'GET',
		success:function(result){

			var tables = $.fn.dataTable.fnTables(true);

			$(tables).each(function () {
				$(this).dataTable().fnDestroy();
			});

			var html = '';
			for(var i=0; i<result.length; i++){
				html += '<tr id="product'+result[i]['id']+'" data-id='+result[i]['id']+'>';
				html += '<td class="col-xs-3">'+result[i]['sell_product_id']+'</td>';
				html += '<td class="col-xs-7">'+result[i]['sell_product_name']+'</td>';
				html += '</tr>';
				
            }
            
			$("#tab_product tbody").html(html);
			$('#tab_product').DataTable( {
					"scrollY":        "200px",
					"scrollCollapse": true,
					"paging":         false,
					"responsive": true,
					"searching": false, 
					"ordering": false,
					"info":     false,
					"destroy": true
				} );
            called_index = 0;
			renewScroll();
			
		},
		error: function(xhr, ajaxOptions, thrownError){
				alert(thrownError);
		},
	});
}


 function renewScroll(){
	 $('#box-page .dataTables_scrollBody').on('scroll', function() {
	  //Return number tr row in tbody

		  var start_index = $('#tab_product tbody tr').length;

		  if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
            if(called_index == start_index)
                return;
            called_index = start_index;
		  $.ajax({
				  url : productViewUrl,
				  data:{type_product:2, product_id:"",supplier:"",product_name:"",t_category:"",
					category:"",t_catalogue:"",
					  catalogue:"",start_index:start_index,special:false},
				  type: 'GET',
				  dataType:'json',
				  success: function(result) {
					  if(result.length>0){
						  for(var i=0; i<result.length; i++){
							var html = '<tr id="product'+result[i]['id']+'" data-id='+result[i]['id']+'>';
							html += '<td class="col-xs-3">'+result[i]['sell_product_id']+'</td>';
							html += '<td class="col-xs-7">'+result[i]['sell_product_name']+'</td>';
							html += '</tr>';
							$('#tab_product tbody').append(html);
						}
                        // Adjust
                        var table = $('#box-page table').DataTable();
                        table.columns.adjust();
					  
					  }
				  }
		   });
		};
	});
 }


 // Click
 $(document).on("click","#tab_product tbody tr", function(){
    if($(this).hasClass("active")) {
        $(this).removeClass("active");
    } else {
        $(this).addClass("active");
    }
 });

 $(document).on("click","#tab_product_set tbody tr", function(){
    if($(this).hasClass("active")) {
        $(this).removeClass("active");
    } else {
        $(this).addClass("active");
    }
 });


 $(document).on("click","#right", function(){
    $('#tab_product tbody tr.active').each(function(){
        var id_product = $(this).data("id"); 
        var html = '<tr data-id="'+id_product+'" class="row">';
        html += $(this).html();
        html += '<td class="col-xs-2 input-fixed"><input class="form-control" type="number" name="form_stt" id="form_stt'+id_product+'"></td>';
        html += '</tr>';
        $('#tab_product_set tbody').append(html);
        $(this).removeClass("active");
        $(this).hide();
    });
 });

 $(document).on("click","#right_all", function(){
	$('#tab_product_set tbody').html("");
    $('#tab_product tbody tr').each(function(){
        var id_product = $(this).data("id"); 
        var html = '<tr data-id="'+id_product+'" class="row">';
        html += $(this).html();
        html += '<td class="col-xs-2 input-fixed"><input class="form-control" type="number" name="form_stt" id="form_stt'+id_product+'"></td>';
        html += '</tr>';
        $('#tab_product_set tbody').append(html);
        $(this).removeClass("active");
        $(this).hide();
    });
 });

 $(document).on("click","#left", function(){
    $('#tab_product_set tbody tr.active').each(function(){
        var id_product = $(this).data("id"); 
        $('#product'+id_product).show();
        $(this).remove();
    });
 });

 $(document).on("click","#left_all", function(){
    $('#tab_product_set tbody tr').each(function(){
        var id_product = $(this).data("id"); 
        $('#product'+id_product).show();
        $(this).remove();
    });
 });


 // Add 
$(document).on("click","#btnAddSetProduct", function(){

    // Setting validation
    $("#form_add_set_product").validate({
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 50
            }, 800);
        }
    });

	$('#id_set_product').rules('add', VALIDATION_ID);
    $('#name_set_product').rules('add', { required: true });
    $('#name_set_product').tooltip({
        trigger: 'manual',
        placement:'bottom'
	});
	$('#id_set_product').tooltip({
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
	var name_set_product = $("#name_set_product").val();
	var id = $("#id_set_product").val();

    // Detail
    var detail_arr = [];

    $('#tab_product_set tbody tr').each(function(){
        var id_product = $(this).data("id"); 
        var stt_product = $('#form_stt'+id_product).val();
        detail_arr.push({
            "id" : id_product,
            "stt" : stt_product
        });
    });

    // Ajax Add
    $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
        {
            url:addListSetProduct,
            data:{id:id,name:name_set_product,detail:detail_arr },
            error_message:message_error_ajax,
            is_master: true
        }
    );
});

$(document).on("change","input[name=form_stt]", function(){
	var value = $(this).val();

	if(value != "" && value != null) {
		var detail_value = [];
		$('input[name=form_stt]').each(function(){
			var value_input = $(this).val();
			if(value_input != "" && value_input != null) {
				detail_value.push(value_input);
			}
		});
		if(array_unique(detail_value).length != detail_value.length) {
			$(this).helloWorld(message_is_exits_set_product);
		}
	}
});

function array_unique(array) {
    var unique = {};
    $.each(array, function(x, value) {
        unique[value] = value;
    });
    return $.map(unique, function(value) { return value; });
}