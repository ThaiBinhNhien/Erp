var called_index = 0;
$(document).ready(function(){
	LoadData();
	
}); 

// // Load Data
function LoadData(val_async){
	// value for async
    if(val_async == "" || val_async == null) {
        val_async = true;
    } else {
        val_async = false;
	}
	
	var ux_id  			= $("#ux_id").val();
	var ux_base  		= $("#ux_base").val();
	var ux_name 		= $("#ux_name").val();
	var ux_address      = $("#ux_address").val();
	var ux_number       = $("#ux_number").val();
		$.ajax({
			url:catViewUrl,
			data:{ux_id: ux_id, ux_base: ux_base,ux_name : ux_name, ux_address: ux_address, ux_number : ux_number, start_index:0},
			async:val_async,
			dataType:'json',
			method:'GET',
			success:function(result){
				$("#cat-table").css("display","block");
				var tables = $.fn.dataTable.fnTables(true);

				$(tables).each(function () {
				    $(this).dataTable().fnDestroy();
				});
				//$("#table_header").parent().parent().parent().attr("id","product-table");
				var html = '';
				for(var i=0; i<result.length; i++){
					html += '<tr data-id='+result[i]['id'] +'>';
					html += '<td>'+(result[i]['id'] == null ? "" : result[i]['id'])+'</td>';
					html += '<td>'+(result[i]['ux_name'] == null ? "" : result[i]['ux_name'])+'</td>';
					html += '<td>'+(result[i]['ux_name1'] == null ? "" : result[i]['ux_name1'])+'</td>';
					html += '<td>'+(result[i]['ux_regency'] == null ? "" : result[i]['ux_regency'])+'</td>';
					html += '<td>'+(result[i]['ux_address'] == null ? "" : result[i]['ux_address'])+'</td>';
					html += '<td>'+(result[i]['ux_number'] == null ? "" : result[i]['ux_number'])+'</td>';
					html += '<td>'+(result[i]['ux_base'] == null ? "" : result[i]['ux_base'])+'</td>';
					html += '<td ><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';
                	html += '</tr>';
				}

				$("#detail_data").html(html);
				//if(isDatatable == true) {
				 	$('.datatable').DataTable( {
						"scrollY":        "360px",
						"scrollCollapse": true,
						"paging":         false,
						"responsive": true,
						"searching": false, 
						"ordering": false,
						"info":     false,
						"destroy": true,
						
					} ); 
					called_index = 0;
					renewScroll();

				//}
				
			},
			error:function(result) {
                var html = '';

				html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
	            $("#detail_data").html(html);
            },
		})
	
}

$(document).ready(function(){
	$(document).on("click",".delete-cat",function(){
		var id = $(this).data("id");
		var data = {id:id}
		var msg = String.format(message_confirm_delete_field, $('table thead tr th:first').html()+" : "+ id);
		$(this).parent().parent().attr("data-delete","1");
		$(this).parent().parent().siblings().attr("data-delete","0"); 
		$(this).helloWorld(msg,null,null,{url:delUrl,data:data,error_message:'',success_callback_function:"remove_record"});
	});
	window.remove_record = function remove_record(){
		$("#detail_data").find("tr[data-delete=1]").remove();
	}
	window.add_record = function add_record(data,result){
		// reset data list
		$('form')[0].reset();
		LoadData("false");
		$("tr[data-id="+result.data['id'] +"]").remove();

		var html = "<tr data-id="+result.data['id'] +">";
		html += '<td>'+result.data['id']+'</td>';
		html += '<td>'+result.data['ux_name']+'</td>';
		html += '<td>'+result.data['ux_name1']+'</td>';
		html += '<td>'+result.data['ux_regency']+'</td>';
		html += '<td>'+result.data['ux_address']+'</td>';
		html += '<td>'+result.data['ux_number']+'</td>';
		html += '<td>'+result.data['ux_base']+'</td>';
		html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result.data['category_id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';	
		html += "</tr>";
		$('#detail_data').prepend(html);
		$('#create-form').modal('toggle');
				
	}
	$("#save").click(function(){
            if(raiseValidateCreate() == false)
                  return false;

            var data = {};
            data.ux_id 		= $("#create_ux_id").val();
            data.ux_base 		= $("#create_ux_base").val();
            data.ux_name_base 	=  $("#create_ux_base option:selected").text();
			data.ux_address 	= $("#create_ux_address").val();
			data.ux_number 	= $("#create_ux_number").val();
			data.ux_name 	=  $("#create_ux_name").val();
			data.ux_name1 	=  $("#create_ux_name1").val();
			data.ux_regency =  $("#create_ux_regency").val();
			$("#save").helloWorld(message_confirm_save_field ,null,null,{url:createUrl,data:data,error_message:'',success_callback_function:"add_record", is_master: true});
          
    })

	function raiseValidateCreate(){
		if($('#form').valid() && $('#form').data("validator")){
			return true;
		}
		return false;
	}
    function raiseValidateEdit(){
            if($('#edit_form').valid() && $('#edit_form').data("validator")){
                  return true;
            }
            return false;
      }
    window.edit_record = function edit_record(data,result){
		$('#edit-form').modal('toggle');
		var id = $("#edit_ux_id").val();
		var editTr = $("#detail_data").find("tr[data-id="+id+"]");
		editTr.find("td:eq(0)").text($("#edit_ux_id").val());
		editTr.find("td:eq(1)").text($("#edit_ux_name").val());
		editTr.find("td:eq(2)").text($("#edit_ux_name1").val());
		editTr.find("td:eq(6)").text($("#edit_ux_base option:selected").text());
		editTr.find("td:eq(3)").text($("#edit_ux_regency").val());
		editTr.find("td:eq(4)").text($("#edit_ux_address").val());
		editTr.find("td:eq(5)").text($("#edit_ux_number").val());
			
	}  
	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;

            var data = {};
            data.id 			= $("#edit_ux_id").val();
			data.ux_base 		= $("#edit_ux_base").val();
            data.ux_name_base 	=  $("#edit_ux_base option:selected").text();
			data.ux_address 	= $("#edit_ux_address").val();
			data.ux_number 	= $("#edit_ux_number").val();
			data.ux_name 	=  $("#edit_ux_name").val();
			data.ux_name1 	=  $("#edit_ux_name1").val();
			data.ux_regency =  $("#edit_ux_regency").val();
			$("#save").helloWorld(message_confirm_save_field ,null,null,{url:edit_CatUrl,data:data,error_message:'',success_callback_function:"edit_record", is_master: true});
      });
	$(".addModal").click(function(){
		$("#form .tooltip").remove();
    	$("#form")[0].reset();
    	
    });

	$(document).on("click",".edit",function(){
		$("#edit_form .tooltip").remove();
		$("#edit_form")[0].reset();
		var id =$(this).parent().parent().find("td:eq(0)").text().trim();
		var ux_name =$(this).parent().parent().find("td:eq(1)").text().trim();
		var ux_name1 =$(this).parent().parent().find("td:eq(2)").text().trim();
		var ux_base =$(this).parent().parent().find("td:eq(6)").text().trim();
		var ux_regency =$(this).parent().parent().find("td:eq(3)").text().trim();
		var ux_address =$(this).parent().parent().find("td:eq(4)").text().trim();
		var ux_number =$(this).parent().parent().find("td:eq(5)").text().trim();
        //$("#dp_id").val(id);
        $("#edit_ux_id").val(id);
        $("#edit_ux_name").val(ux_name);
        $("#edit_ux_name1").val(ux_name1);
        $("#edit_ux_base").val(ux_base);
        $("#edit_ux_regency").val(ux_regency);
        $("#edit_ux_address").val(ux_address);
        $("#edit_ux_number").val(ux_number);
       
		$('select#edit_ux_base option').each(function () {
		    if ($(this).text().toLowerCase() == ux_base.toLowerCase()) {
		        $(this).prop('selected','selected');
		        return;
		    }
		});
		
    })

	$("#edit_form").validate({
            rules : {
            	
            	edit_ux_address:{
            		required: true,
            		
            	},
            	edit_ux_name:{
            		required: true,
            		
            	},
            	edit_ux_base:{
            		required: true,
            		
            	},
            	
            },
            tooltip_options: {  // <- totally invalid option
		       
		       edit_ux_address: {
		            placement: 'bottom',html:true
		        },
		        edit_ux_name: {
		            placement: 'bottom',html:true
		        },
		        edit_ux_base: {
		            placement: 'bottom',html:true
		        },
		       
			}
      });

	$("#form").validate({
            rules : {
            	create_ux_address:{
            		required:true
            	},
            	create_ux_name:{
            		required:true,
            	},
            	create_ux_base:{
            		required:true,
            	},
            	create_ux_id:VALIDATION_ID,
            },
            tooltip_options: {  // <- totally invalid option
		        create_ux_address: {
		            placement: 'bottom'
		        },
		        create_ux_name: {
		            placement: 'bottom',html:true
		        },
		        create_ux_base: {
		            placement: 'bottom',html:true
		        },
		        create_ux_id: {
		            placement: 'bottom',html:true
		        },
		       
			}
    });
	$("#search").click(function(){
		LoadData();
	});

});
	

  function renewScroll(){
 	$('#cat-table .dataTables_scrollBody').on('scroll', function() {
	  //Return number tr row in tbody

		var start_index = $('#cat-table tbody tr').length;
		var ux_id  			= $("#ux_id").val();
		var ux_base  		= $("#ux_base").val();
		var ux_name 		= $("#ux_name").val();
		var ux_address      = $("#ux_address").val();
		var ux_number       = $("#ux_number").val();
	  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
	      $.ajax({
	              url:catViewUrl,
				  data:{ux_id: ux_id, ux_base: ux_base,ux_name : ux_name, ux_address: ux_address, ux_number : ux_number, start_index:start_index},
	              type: 'GET',
	              dataType:'json',
	              success: function(result) {
		              if(result.length>0){
			              for(var i=0; i<result.length; i++){
							var html = '<tr data-id='+result[i]['id'] +'>';
							html += '<td>'+(result[i]['id'] == null ? "" : result[i]['id'])+'</td>';
							html += '<td>'+(result[i]['ux_name'] == null ? "" : result[i]['ux_name'])+'</td>';
							html += '<td>'+(result[i]['ux_name1'] == null ? "" : result[i]['ux_name1'])+'</td>';
							html += '<td>'+(result[i]['ux_regency'] == null ? "" : result[i]['ux_regency'])+'</td>';
							html += '<td>'+(result[i]['ux_address'] == null ? "" : result[i]['ux_address'])+'</td>';
							html += '<td>'+(result[i]['ux_number'] == null ? "" : result[i]['ux_number'])+'</td>';
							html += '<td>'+(result[i]['ux_base'] == null ? "" : result[i]['ux_base'])+'</td>';
							html += '<td ><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['category_id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';
		                	html += '</tr>';
		                	$('#detail_data').append(html);
						}
						// Adjust
						var table = $('#cat-table table').DataTable();
						table.columns.adjust();
		              }
	              }
	       });
	    };
	});
 }

