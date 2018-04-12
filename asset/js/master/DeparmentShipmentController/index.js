function showList(val_async){
	// value for async
	if(val_async == "" || val_async == null) {
		val_async = true;
	  } else {
		val_async = false;
	  }

	var id = $("#id").val();
		var name = $("#name").val();
		$.ajax({
			url : departmentViewUrl,
		    data: {id: id, name:name},
		    async:val_async,
		    type: 'GET',
		    dataType:'json',
		    success: function(result) {
                        $(".dataTables_scrollHeadInner").css("width","unset");
			    if(result.length>0){
			    	var html = '';
				    for(var i=0; i<result.length; i++){
						html += '<tr data-id="'+result[i]['id']+'">';
						html += '<td>'+result[i]['id']+'</td>';
			                	html += '<td>'+(result[i]['name']==null?'':result[i]['name'])+'</td>';
			                	html += '<td><a  href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="'+imgUrl+'edit.png"/></a> ';
			                	html += '<a href="#" class="delete" data-id="'+result[i]['id']+'"><img src="'+imgUrl+'del.png"/></a></td>';
				        html += '</tr>';
				        
					}
			        $('#detail_data').html(html); 
			    }else{
			    	$('#detail_data').html(''); 
			    }
                      if(result.length < 9){
                        $(".dataTables_scrollHeadInner").css("width","100%");
                        $(".dataTables_scrollHeadInner>table ").css("width","100%");
                      }
		    }
		});
}

$(document).ready(function(){

	$("#search").click(function(){
            showList();
		
	});
      $("#create").click(function(){
            $("#create_id").val('');
            $("#create_name").val('');
      })
	$(document).on("click",".delete",function(){
		var id = $(this).data("id");
		var data = {id:id}
		$(this).parent().parent().attr("data-delete","1");
		$(this).parent().parent().siblings().attr("data-delete","0");
            var msg = String.format(message_confirm_delete_field, $('table thead tr th:first').html()+" : "+ id);
		$(this).helloWorld(msg,null,null,{url:delUrl,data:data,error_message:'',success_callback_function:"remove_record"});
	});
	window.remove_record = function remove_record(){
		$("#detail_data").find("tr[data-delete=1]").remove();
	}
	$("#save").click(function(){
            if(raiseValidateCreate() == false)
                  return false;

            var data = {};
            data.id = $("#create_id").val();
            data.name = $("#create_name").val();
            
		// Ajax Add-Popup
		$(this).helloWorld(message_confirm_save_field ,null,null,
			{
			url:createUrl,
			data:data,
			error_message:message_error_ajax,
			success_callback_function:"add_record", 
			is_master: true
			}
		);
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
            data.id_change = $("#edit_id").val();
            data.name = $("#edit_name").val();
           
		// Ajax Edit-Popup
		$(this).helloWorld(message_confirm_save_field ,null,null,
			{
			url:editUrl,
			data:data,
			error_message:message_error_ajax,
			success_callback_function:"edit_record", 
			is_master: true
			}
		);
      });

	$(document).on("click",".edit",function(){
		var id =$(this).parent().parent().find("td:eq(0)").text().trim();
		var name =$(this).parent().parent().find("td:eq(1)").text().trim();
        $("#dp_id").val(id);
        $("#edit_id").val(id);
        $("#edit_name").val(name);
      })
	$("#form").validate({
            rules : {
                  create_id: VALIDATION_ID,
            	create_name:VALID_DEPARTMENT_CREATE_NAME,
            	// create_code:{
            	// 	required:true
            	// }
            },
            tooltip_options: {  // <- totally invalid option
		        create_name: {
		            placement: 'right',html:true
		        },
		      //   create_code: {
		      //       placement: 'bottom'
			//   },
			  create_id: {
		            placement: 'top'
		        }
		    }
      });
	$("#edit_form").validate({
            rules : {
            	edit_name:{
            		required:true,
            	},
            	edit_code:{
            		required:true
            	}
            },
            tooltip_options: {  // <- totally invalid option
		        edit_name: {
		            placement: 'top',html:true
		        },
		        edit_code: {
		            placement: 'top'
		        }
		    }
      });
	$('.datatable').DataTable({
            "sScrollY" : "360px",
            "scrollCollapse": true,
            "paging":         false,
            "responsive": true,
            "searching": false, 
            "ordering": false,
            "info":     false,
            "destroy": true
      });
	
});

$(document).ready(function(){
	window.add_record = function add_record(data,result){
        if(result.success == true) {
		  // reset data list
		  $('form')[0].reset();
		  showList("false");

		  
            var id = $("#create_id").val();
            var name = $("#create_name").val();
            $("tr[data-id="+id+"]").remove();
            var html = "<tr data-id="+id +">";
			html += '<td>'+id+'</td>';
			html += '<td>'+name+'</td>';
			html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="'+imgUrl+'edit.png"/></a> ';
			html += '<a href="#" class="delete" data-id="'+id+'"><img src="'+imgUrl+'del.png"/></a></td>';
			html += "</tr>";
			$('#detail_data').prepend(html); 
			$('#create-form').modal('toggle');
        }
	}
	window.edit_record = function edit_record(data,result){ 
			$('#edit-form').modal('toggle');
            var id = $("#edit_id").val();
            var name = $("#edit_name").val();
			var editTr = $("#detail_data").find("tr[data-id="+id+"]");
			editTr.find("td:eq(0)").text(id);
			editTr.find("td:eq(1)").text(name);
    }
});