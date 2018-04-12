var called_index = 0;
$(document).ready(function(){
	$(document).on("click",".delete-cat",function(){
		var id = $(this).data("id");
		var data = {id:id}
		$(this).parent().parent().attr("data-delete","1");
		$(this).parent().parent().siblings().attr("data-delete","0");
		$(this).helloWorld('注文伝票（新規）を保存します。よろしいですか？',null,null,{url:delUrl,data:data,error_message:'',success_callback_function:"remove_record"});
	});
	window.remove_record = function remove_record(){
		$("#detail_data").find("tr[data-delete=1]").remove();
	}

	$("#save").click(function(){
            if(raiseValidateCreate() == false)
                  return false;

            var data = {};
            data.name = $("#create_name").val();
            $.ajax({
            	url:createUrl,
            	data:data,
            	method:"POST",
            	dataType:"json",
            	success:function(result){
            		$('#create-form').modal('toggle');
            		if(result.success == true){
            			var html = "<tr data-id="+result.data['category_id'] +">";
            			html += '<td>'+result.data['category_id']+'</td>';
						html += '<td>'+result.data['category_name']+'</td>';
						html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a><a data-id="'+result.data['category_id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';	
            			html += "</tr>";
            			$('#detail_data').append(html); 
            		}
            		$('#save').helloWorld(result.message,null);
            	},
            	error:function(error){
            		$('#create-form').modal('toggle');
            		$('#save').helloWorld("dupplicate id",null);
            	}
            });
    })

    function raiseValidateCreate(){
            if($('#form').valid() && $('#form').data("validator")){
                  return true;
            }
            return false;
      }
    function raiseValidateEdit(){
            if($('#form').valid() && $('#edit_form').data("validator")){
                  return true;
            }
            return false;
      }

	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;

            var data = {};
            data.id = $("#dp_id").val();
            data.name = $("#edit_name").val();
            $.ajax({
            	url:edit_CatUrl,
            	data:data,
            	method:"POST",
            	dataType:"json",
            	success:function(result){
            		$('#edit-form').modal('toggle');
            		if(result.success == true){
            			var id = $("#dp_id").val();
						var editTr = $("#detail_data").find("tr[data-id="+id+"]");
						editTr.find("td:eq(1)").text($("#edit_name").val());
            		}
            		$('#save').helloWorld(result.message,null);
            	},
            	error:function(error){
            		$('#edit-form').modal('toggle');
            		$('#save').helloWorld("dupplicate id",null);
            	}
            });
      });

	$(document).on("click",".edit",function(){
		var id =$(this).parent().parent().find("td:eq(0)").text().trim();
		var name =$(this).parent().parent().find("td:eq(1)").text().trim();
        $("#dp_id").val(id);
        $("#edit_name").val(name);
    })

	$("#edit_form").validate({  
            rules : {
            	edit_name:{
            		required:true,
            	}
            },
            tooltip_options: {  // <- totally invalid option
		        edit_name: {
		            placement: 'top',html:true
		        }
			}
      });
	$("#search").click(function(){
		showList();
	});
	

	  function renewScroll(){
	 	$('#cat-table .dataTables_scrollBody').on('scroll', function() {
		  //Return number tr row in tbody

			  var start_index = $('#cat-table tbody tr').length;
			  if(start_index != 0){
			  	
			  	if(start_index == 1){

			  		if($('#cat-table tbody tr > td').attr("class") == "dataTables_empty" )
			  			return;
			  	}
			  	start_index -= 1;
			  	
			  }else{
			  	return;
			  }
			
			var cat_name = $("#cat_name").val();
		  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
			 	if(called_index == start_index)
			 		return;
			 	called_index = start_index;
		      $.ajax({
		              url:catViewUrl,
					  data:{cat_name:cat_name, start_index:start_index},
		              type: 'GET',
		              dataType:'json',
		              success: function(result) {
			              if(result.length>0){
				              for(var i=0; i<result.length; i++){
								var html = '<tr>';
								html += '<tr data-id='+result[i]['category_id'] +'>';
								html += '<td>'+result[i]['category_name']+'</td>';
								html += '<td ><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a><a data-id="'+result[i]['category_id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';
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


});


function showList(val_async) {
	// value for async
    if(val_async == "" || val_async == null) {
        val_async = true;
    } else {
        val_async = false;
	}
	
	var cat_name = $("#cat_name").val();
		$.ajax({
			url:catViewUrl,
			data:{cat_name:cat_name, start_index:0},
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
					html += '<tr data-id='+result[i]['category_id'] +'>';
					html += '<td>'+result[i]['category_id']+'</td>';
					html += '<td>'+result[i]['category_name']+'</td>';
					html += '<td ><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a><a data-id="'+result[i]['category_id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';
                	html += '</tr>';
				}

				$("#detail_data").html(html);
				$('.datatable').DataTable( {
				        "scrollY":        "360px",
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
