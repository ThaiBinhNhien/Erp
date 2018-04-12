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
	
	var cat_id = $("#cat_id").val();
	var cat_name = $("#cat_name").val();
		$.ajax({
			url:catViewUrl,
			data:{cat_id: cat_id,cat_name:cat_name, start_index:0},
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
					html += '<td>'+(result[i]['id'] == null ? "" : result[i]['id'] )+'</td>';
					html += '<td>'+(result[i]['name'] == null ? "" : result[i]['name'] )+'</td>';
					html += '<td>'+(result[i]['name_group_m'] == null ? "" : result[i]['name_group_m'] )+'</td>';
					html += '<td>'+(result[i]['display_order'] == null ? "" : result[i]['display_order'] )+'</td>';
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
			error: function(result){
                var html = '';
	            html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
	            $("#price-product-export tbody").html(html);
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
		$(this).helloWorld(msg ,null,null,{url:delUrl,data:data,error_message:'',success_callback_function:"remove_record"});
	});
	window.remove_record = function remove_record(){
		$("#detail_data").find("tr[data-delete=1]").remove();
	}
	window.add_record = function add_record(data,result){
		// reset data list
		$('form')[0].reset();
		LoadData("false");
		$("tr[data-id="+result.data['category_id']+"]").remove();
		
			var html = "<tr data-id="+result.data['category_id'] +">";
			html += '<td>'+result.data['category_id']+'</td>';
			html += '<td>'+result.data['category_name']+'</td>';
			html += '<td>'+result.data['group_m']+'</td>';
			html += '<td>'+result.data['display_order']+'</td>';
			html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result.data['category_id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';	
			html += "</tr>";
	
			$('#detail_data').prepend(html); 
			$('#create-form').modal('toggle');
				
	}
	window.edit_record = function edit_record(data,result){
			$('#edit-form').modal('toggle');
			var id = $("#dp_id").val();
			var editTr = $("#detail_data").find("tr[data-id="+id+"]");
			editTr.find("td:eq(1)").text($("#edit_name").val());
			editTr.find("td:eq(2)").text($("#edit_group_m option:selected").text());
			editTr.find("td:eq(3)").text($("#edit_display_order").val());
			
	}
	$("#save").click(function(){

		 	
            if(raiseValidateCreate() == false)
                  return false;
            var data = {};
            data.id = $("#create_id").val();
            data.name 			= $("#create_name").val();
            data.display_order  = $("#create_display_order").val();
            data.group_m 		= $("#group_m").val();
            data.name_group_m 		= $("#group_m option:selected").text();
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
	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;

            var data = {};
            data.id = $("#dp_id").val();
            data.name 			= $("#edit_name").val();
            data.display_order  = $("#edit_display_order").val();
            data.group_m 		= $("#edit_group_m").val();
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
		var name =$(this).parent().parent().find("td:eq(1)").text().trim();
		var name_group_m =$(this).parent().parent().find("td:eq(2)").text().trim();
		var display_order =$(this).parent().parent().find("td:eq(3)").text().trim();
        $("#dp_id").val(id);
        $("#edit_name").val(name);
        $("#edit_display_order").val(display_order);
		$('select#edit_group_m option').each(function () {
		    if ($(this).text().toLowerCase() == name_group_m.toLowerCase()) {
		        $(this).prop('selected','selected');
		        return;
		    }
		});
    })
	
	$("#edit_form").validate({
            rules : {
            	edit_name:{
            		required:true,
            	},
            	edit_display_order:VALIDATION_POSITIVE
            	
            },
            tooltip_options: {  // <- totally invalid option
		        edit_name: {
		            placement: 'bottom'
		        },
		        edit_display_order: {
		            placement: 'bottom'
		        }
			}
      });

	$("#form").validate({
            rules : {
            	create_name:{
            		required:true
            	},

            	create_id:VALIDATION_ID,
            	create_display_order:VALIDATION_POSITIVE
            },
            tooltip_options: {  // <- totally invalid option
		        create_name: {
		            placement: 'bottom'
		        },
		        create_id: {
		            placement: 'top',html:true
		        },
		        create_display_order: {
		            placement: 'bottom',html:true
		        }
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
		var cat_id = $("#cat_id").val();
		var cat_name = $("#cat_name").val();
	  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
	      $.ajax({
	              url:catViewUrl,
				  data:{cat_id: cat_id,cat_name:cat_name, start_index:start_index},
	              type: 'GET',
	              dataType:'json',
	              success: function(result) {
		              if(result.length>0){
			              for(var i=0; i<result.length; i++){
							var html = '<tr data-id='+result[i]['id'] +'>';
							html += '<td>'+(result[i]['id'] == null ? "" : result[i]['id'] )+'</td>';
							html += '<td>'+(result[i]['name'] == null ? "" : result[i]['name'] )+'</td>';
							html += '<td>'+(result[i]['name_group_m'] == null ? "" : result[i]['name_group_m'] )+'</td>';
							html += '<td>'+(result[i]['display_order'] == null ? "" : result[i]['display_order'] )+'</td>';
							html += '<td ><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';
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