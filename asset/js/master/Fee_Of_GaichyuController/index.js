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
	
	var gaichyu_customer  = $("#gaichyu_customer").val();
	var gaichyu_base 	  = $("#gaichyu_base").val();
	var gaichyu_user      = $("#gaichyu_user").val();
	//alert("s="+gaichyu_user);
	var deparment         = $("#deparment").val();
		$.ajax({
			url:catViewUrl,
			data:{gaichyu_customer: gaichyu_customer,gaichyu_base : gaichyu_base, gaichyu_user: gaichyu_user, deparment : deparment, start_index:0},
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
					html += '<td>'+(result[i]['gaichyu_customer_name'] == null ? "" : result[i]['gaichyu_customer_name'] )+'</td>';
					html += '<td>'+(result[i]['gaichyu_base_name'] == null ? "" : result[i]['gaichyu_base_name'] )+'</td>';
					html += '<td>'+(result[i]['contact_user_name'] == null ? "" : result[i]['contact_user_name'] )+'</td>';
					html += '<td>'+(result[i]['tolinen_fee'] == null ? "" : result[i]['tolinen_fee'] )+'</td>';
					html += '<td>'+(result[i]['enviroment_fee'] == null ? "" : result[i]['enviroment_fee'] )+'</td>';
					html += '<td>'+(result[i]['laundry_fee'] == null ? "" : result[i]['laundry_fee'] )+'</td>';
					html += '<td>'+(result[i]['department_name'] == null ? "" : result[i]['department_name'] )+'</td>';
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
	            html = '<tr class="odd row-empty"><td valign="top" colspan="9" class="dataTables_empty">'+message_empty_data+'</td></tr>';
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
	$(document).on("change","#create_gaichyu_customer",function(){

	    var val_customer = $(this).val();
	    var val_base = $(this).find('option:selected').data('base');
	    var username =  $(this).find('option:selected').data('username');
	    $('#create_gaichyu_base').val(val_base);
	    $('#create_gaichyu_user').val(username);
	 
	});
	window.add_record = function add_record(data,result){
		// reset data list
		$('form')[0].reset();
		LoadData("false");
		$("tr[data-id="+result.data['id']+"]").remove();
		
		var html = "<tr data-id="+result.data['id'] +">";
		html += '<td>'+result.data['id']+'</td>';
		html += '<td>'+result.data['gaichyu_customer_name']+'</td>';
		html += '<td>'+result.data['gaichyu_base_name']+'</td>';
		html += '<td>'+result.data['contact_user_name']+'</td>';
		html += '<td>'+result.data['tolinen_fee']+'</td>';
		html += '<td>'+result.data['enviroment_fee']+'</td>';
		html += '<td>'+result.data['laundry_fee']+'</td>';
		html += '<td>'+result.data['department_name']+'</td>';
		html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result.data['category_id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';	
		html += "</tr>";
		$('#detail_data').prepend(html);
		$('#create-form').modal('toggle');
				
	}
	$("#save").click(function(){
            if(raiseValidateCreate() == false)
                  return false;

             
            var data = {};
            data.gaichyu_customer 		= $("#create_gaichyu_customer").val();
            data.name_gaichyu_customer 	= $("#create_gaichyu_customer option:selected").text();
			data.gaichyu_base 			= $("#create_gaichyu_base").val();
			data.name_gaichyu_base		= $("#create_gaichyu_base option:selected").text();
			data.gaichyu_user    		= $("#create_gaichyu_user").val();
			data.name_gaichyu_user		= $("#create_gaichyu_user option:selected").text();
			data.deparment 				= $("#create_deparment").val();
			data.name_deparment			= $("#create_deparment option:selected").text();
			data.tolinen_fee 			= $("#create_tolinen_fee").val();
			data.enviroment_fee 		= $("#create_enviroment_fee").val();
			data.laundry_fee 			= $("#create_laundry_fee").val();
			//check input 1 in 3 field
            if(data.tolinen_fee == "" && data.laundry_fee =="" &&  data.enviroment_fee =="" ){
            	$(this).helloWorld("いずれかのﾝｻﾌﾟﾗｲ売上、ﾘﾈﾝ補充費、ｸﾘｰﾆﾝｸﾞ他売上を入力してください。");
            	return;
            }
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
		//editTr.find("td:eq(1)").text($("#edit_gaichyu_customer").val());
		//editTr.find("td:eq(2)").text($("#edit_gaichyu_base").val());
		//editTr.find("td:eq(3)").text($("#edit_gaichyu_user").val());
		editTr.find("td:eq(4)").text($("#edit_tolinen_fee").val());
		editTr.find("td:eq(5)").text($("#edit_enviroment_fee").val());
		editTr.find("td:eq(6)").text($("#edit_laundry_fee").val());
		editTr.find("td:eq(7)").text($("#edit_deparment option:selected").text());
			
	}  
	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;

            var data = {};
            data.id 				    = $("#dp_id").val();
			data.deparment 				= $("#edit_deparment").val();
			//data.name_deparment			= $("#edit_deparment option:selected").text();
			data.tolinen_fee 			= $("#edit_tolinen_fee").val();
			data.enviroment_fee 		= $("#edit_enviroment_fee").val();
			data.laundry_fee 			= $("#edit_laundry_fee").val();

			if(data.tolinen_fee == "" && data.laundry_fee =="" &&  data.enviroment_fee =="" ){
            	$(this).helloWorld("いずれかのﾝｻﾌﾟﾗｲ売上、ﾘﾈﾝ補充費、ｸﾘｰﾆﾝｸﾞ他売上を入力してください。");
            	return;
            }
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
		var gaichyu_customer_name =$(this).parent().parent().find("td:eq(1)").text().trim();
		var gaichyu_base_name =$(this).parent().parent().find("td:eq(2)").text().trim();
		var contact_user_name =$(this).parent().parent().find("td:eq(3)").text().trim();
		var tolinen_fee =$(this).parent().parent().find("td:eq(4)").text().trim();
		var enviroment_fee =$(this).parent().parent().find("td:eq(5)").text().trim();
		var laundry_fee =$(this).parent().parent().find("td:eq(6)").text().trim();
		var department_name =$(this).parent().parent().find("td:eq(7)").text().trim();
        $("#dp_id").val(id);
        $("#edit_tolinen_fee").val(tolinen_fee);
        $("#edit_enviroment_fee").val(enviroment_fee);
        $("#edit_laundry_fee").val(laundry_fee);
        $("#edit_gaichyu_customer").val(gaichyu_customer_name);
        $("#edit_gaichyu_base").val(gaichyu_base_name);
        $("#edit_gaichyu_user").val(contact_user_name);
		
		$('select#edit_deparment option').each(function () {
		    if ($(this).text().toLowerCase() == department_name.toLowerCase()) {
		        $(this).prop('selected','selected');
		        return;
		    }
		});
    })

	$("#edit_form").validate({
            rules : {
            	edit_gaichyu_customer:{
            		required:true
            	},
            	edit_gaichyu_base:{
            		required:true,
            	},
            	edit_gaichyu_user:{
            		required:true
            	},
            	edit_tolinen_fee:VALIDATION_POSITIVE,
            	edit_enviroment_fee:VALIDATION_POSITIVE,
            	edit_laundry_fee:VALIDATION_POSITIVE
            },
            tooltip_options: {  // <- totally invalid option
		       edit_gaichyu_customer: {
		            placement: 'top'
		        },
		        edit_gaichyu_base: {
		            placement: 'top',html:true
		        },
		        edit_gaichyu_user: {
		            placement: 'bottom'
		        },
		        edit_tolinen_fee: {
		            placement: 'top'
		        },
		       edit_enviroment_fee: {
		            placement: 'top',html:true
		        },
		        edit_laundry_fee: {
		            placement: 'bottom'
		        },
			}
      });

	$("#form").validate({
            rules : {
            	create_gaichyu_customer:{
            		required:true
            	},
            	create_gaichyu_base:{
            		required:true,
            	},
            	create_gaichyu_user:{
            		required:true
            	},
            	create_tolinen_fee:VALIDATION_POSITIVE,
            	create_enviroment_fee:VALIDATION_POSITIVE,
            	create_laundry_fee:VALIDATION_POSITIVE

            },
            tooltip_options: {  // <- totally invalid option
		        create_gaichyu_customer: {
		            placement: 'top'
		        },
		        create_gaichyu_base: {
		            placement: 'top',html:true
		        },
		        create_gaichyu_user: {
		            placement: 'bottom'
		        },
		        create_tolinen_fee: {
		            placement: 'top'
		        },
		        create_enviroment_fee: {
		            placement: 'top',html:true
		        },
		        create_laundry_fee: {
		            placement: 'bottom'
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
		var gaichyu_customer  = $("#gaichyu_customer").val();
		var gaichyu_base 	  = $("#gaichyu_base").val();
		var gaichyu_user      = $("#gaichyu_user").val();
		var deparment         = $("#deparment").val();
	  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
	      $.ajax({
	              url:catViewUrl,
				  data:{gaichyu_customer: gaichyu_customer,gaichyu_base : gaichyu_base, gaichyu_user: gaichyu_user, deparment : deparment, start_index:start_index},
	              type: 'GET',
	              dataType:'json',
	              success: function(result) {
		              if(result.length>0){
			              for(var i=0; i<result.length; i++){
							var html = '<tr data-id='+result[i]['id'] +'>';
							html += '<td>'+(result[i]['id'] == null ? "" : result[i]['id'] )+'</td>';
							html += '<td>'+(result[i]['gaichyu_customer_name'] == null ? "" : result[i]['gaichyu_customer_name'] )+'</td>';
							html += '<td>'+(result[i]['gaichyu_base_name'] == null ? "" : result[i]['gaichyu_base_name'] )+'</td>';
							html += '<td>'+(result[i]['contact_user_name'] == null ? "" : result[i]['contact_user_name'] )+'</td>';
							html += '<td>'+(result[i]['tolinen_fee'] == null ? "" : result[i]['tolinen_fee'] )+'</td>';
							html += '<td>'+(result[i]['enviroment_fee'] == null ? "" : result[i]['enviroment_fee'] )+'</td>';
							html += '<td>'+(result[i]['laundry_fee'] == null ? "" : result[i]['laundry_fee'] )+'</td>';
							html += '<td>'+(result[i]['department_name'] == null ? "" : result[i]['department_name'] )+'</td>';
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

