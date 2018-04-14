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
	
	var item_name = $("#item_name").val();
	var id = $("#id").val();
		$.ajax({
			url:catViewUrl,
			data:{id: id,item_name:item_name, start_index:0},
			async:val_async,
			dataType:'json',
			method:'GET',
			success:function(result){
				$("#washing-table").css("display","block");
				var tables = $.fn.dataTable.fnTables(true);

				$(tables).each(function () {
				    $(this).dataTable().fnDestroy();
				});
				//$("#table_header").parent().parent().parent().attr("id","product-table");
				var html = '';
				for(var i=0; i<result.length; i++){
					html += '<tr data-id='+result[i]['id'] +'>';
					html += '<td>'+(result[i]['id'] == null? "" : result[i]['id'])+'</td>';
					html += '<td>'+(result[i]['item_name_1'] == null? "" : result[i]['item_name_1'])+'</td>';
					html += '<td>'+(result[i]['item_name_2'] == null? "" : result[i]['item_name_2'])+'</td>';
					html += '<td>'+(result[i]['weight'] == null? "" : result[i]['weight'])+'</td>';
					html += '<td>'+(result[i]['temperature'] == null? "" : result[i]['temperature'])+'</td>';
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
	        }
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
		$("tr[data-id="+result.data['id']+"]").remove();
		
		var html = "<tr data-id="+result.data['id'] +">";
		html += '<td>'+result.data['id']+'</td>';
		html += '<td>'+result.data['item_name_1']+'</td>';
		html += '<td>'+result.data['item_name_2']+'</td>';
		html += '<td>'+result.data['weight']+'</td>';
		html += '<td>'+result.data['temperature']+'</td>';
		html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a><a data-id="'+result.data['id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';	
		html += "</tr>";
		$('#detail_data').prepend(html); 
		$('#create-form').modal('toggle');
				
	}
	$("#save").click(function(){
            if(raiseValidateCreate() == false)
                  return false;
            var data = {};
            data.id = $("#create_id").val();
            data.item_name_1 = $("#create_item_name_1").val();
            data.item_name_2 = $("#create_item_name_2").val();
            data.weight 	 = $("#create_weight").val();
            data.temperature = $("#create_temperature").val();
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
		var id = $("#dp_id").val();
		var editTr = $("#detail_data").find("tr[data-id="+id+"]");
		editTr.find("td:eq(1)").text($("#edit_item_name_1").val());
		editTr.find("td:eq(2)").text($("#edit_item_name_2").val());
		editTr.find("td:eq(3)").text($("#edit_weight").val());
		editTr.find("td:eq(4)").text($("#edit_temperature").val());
			
	}  
	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;

            var data = {};
            data.id = $("#dp_id").val();
            data.item_name_1 = $("#edit_item_name_1").val();
            data.item_name_2 = $("#edit_item_name_2").val();
            data.weight 	 = $("#edit_weight").val();
            data.temperature = $("#edit_temperature").val();
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
		var item_name_1 =$(this).parent().parent().find("td:eq(1)").text().trim();
		var item_name_2 =$(this).parent().parent().find("td:eq(2)").text().trim();
		var weight =$(this).parent().parent().find("td:eq(3)").text().trim();
		var temperature =$(this).parent().parent().find("td:eq(4)").text().trim();
        $("#dp_id").val(id);
        $("#edit_item_name_1").val(item_name_1);
        $("#edit_item_name_2").val(item_name_2);
        $("#edit_weight").val(weight);
        $("#edit_temperature").val(temperature);
    })

	$("#edit_form").validate({
            rules : {
            	edit_item_name_1:{
            		required:true,
            	},
            	// edit_item_name_2:{
            	// 	required:true,
            	// },
            	edit_weight:{
            		required: true,
            		number: true, 
				    min: 0,
				    max: 2147483647,
            	},
            	edit_temperature:{
            		required: true,
            		number: true, 
				    min: 0,
				    max: 2147483647,
            	}
            },
            tooltip_options: {  // <- totally invalid option
		        edit_item_name_1: {
		            placement: 'right'
		        },
		        // edit_item_name_2: {
		        //     placement: 'bottom'
		        // },
		        edit_weight: {
		            placement: 'top'
		        },
		        edit_temperature: {
		            placement: 'bottom'
		        }
			}
      });

	$("#form").validate({
            rules : {
            	create_item_name_1:{
            		required:true,
            	},
            	// create_item_name_2:{
            	// 	required:true,
            	// },
            	create_weight:{
            		required: true,
            		number: true, 
				    min: 0,
				    max: 2147483647,
            	},
            	create_temperature:{
            		 required: true,
            		number: true, 
				    min: 0,
				    max: 2147483647,
            	},
            	create_id:VALIDATION_ID

            },
            tooltip_options: {  // <- totally invalid option
		        create_item_name_1: {
		            placement: 'right'
		        },
		        // create_item_name_2: {
		        //     placement: 'bottom'
		        // },
		        create_weight: {
		            placement: 'right'
		        },
		        create_temperature: {
		            placement: 'bottom'
		        },
		        create_id: {
		            placement: 'top',html:true
		        }
			}
    });
	$("#search").click(function(){
		LoadData();
	});

});
	

  function renewScroll(){
 	$('#washing-table .dataTables_scrollBody').on('scroll', function() {
	  //Return number tr row in tbody

		var start_index = $('#washing-table tbody tr').length;
		
		var item_name = $("#item_name").val();
		var id = $("#id").val();
	  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
	      $.ajax({
	              url:catViewUrl,
				  data:{id: id, item_name:item_name, start_index:start_index},
	              type: 'GET',
	              dataType:'json',
	              success: function(result) {
		              if(result.length>0){
			              for(var i=0; i<result.length; i++){
							var html = '<tr data-id='+result[i]['id'] +'>';
							html += '<td>'+(result[i]['id'] == null? "" : result[i]['id'])+'</td>';
							html += '<td>'+(result[i]['item_name_1'] == null? "" : result[i]['item_name_1'])+'</td>';
							html += '<td>'+(result[i]['item_name_2'] == null? "" : result[i]['item_name_2'])+'</td>';
							html += '<td>'+(result[i]['weight'] == null? "" : result[i]['weight'])+'</td>';
							html += '<td>'+(result[i]['temperature'] == null? "" : result[i]['temperature'])+'</td>';
							html += '<td ><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';	
		                	html += '</tr>';
		                	$('#detail_data').append(html);
						}
						
						// Adjust
						var table = $('#washing-table table').DataTable();
						table.columns.adjust();
		              
		              }
	              }
	       });
	    };
	});
 }

