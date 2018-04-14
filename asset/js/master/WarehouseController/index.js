$(document).ready(function(){
	$("#search").click(function(){
		var name = $("#name").val();
		$.ajax({
			url : warehouseViewUrl,
		    data: {name:name},
		    type: 'GET',
		    dataType:'json',
		    success: function(result) {
			    if(result.length>0){
			    	var html = '';
				    for(var i=0; i<result.length; i++){
						html += '<tr data-id="'+result[i]['id']+'">';
						html += '<td>'+result[i]['id']+'</td>';
			                	html += '<td>'+result[i]['name']+'</td>';
			                	html += '<td><a  href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="'+imgUrl+'edit.png"/></a>';
			                	html += '<a href="#" class="delete" data-id="'+result[i]['id']+'"><img src="'+imgUrl+'del.png"/></a></td>';
				        html += '</tr>';
				        
					}
			       $('#detail_data').html(html);       
			    }else{
			    	$('#detail_data').html(''); 
			    }
		    }
		});
		
	});
	$(document).on("click",".delete",function(){
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
            			var html = "<tr>";
            			html += "<td>"+result.data['id']+"</td>";
            			html += "<td>"+result.data['name']+"</td>";
            			html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="'+imgUrl+'edit.png"/></a></td>';
                    	html += '<td><a href="#" class="delete" data-id="'+result.data['id']+'"><img src="'+imgUrl+'del.png"/></a></td>';
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
            data.id = $("#edit_id").val();
            data.name = $("#edit_name").val();
            $.ajax({
            	url:editUrl,
            	data:data,
            	method:"POST",
            	dataType:"json",
            	success:function(result){
            		 $('#edit-form').modal('toggle');
            		if(result.success == true){
            			var id = $("#edit_id").val();
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
	window.edit_record = function edit_record(){
		
	}
	$(document).on("click",".edit",function(){
		var id =$(this).parent().parent().find("td:eq(0)").text().trim();
		var name =$(this).parent().parent().find("td:eq(1)").text().trim();
        $("#edit_id").val(id);
        $("#edit_name").val(name);
      })
	$("#form").validate({
            rules : {
            	create_name:{
            		required:true,
            	}
            },
            tooltip_options: {  // <- totally invalid option
		        create_name: {
		            placement: 'top',html:true
		        }
		    }
      });
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
	$('.datatable').DataTable({
            "scrollCollapse": true,
            "paging":         false,
            "responsive": true,
            "searching": true, 
            "ordering": false,
            "info":     false,
            "destroy": true
      });
	
})