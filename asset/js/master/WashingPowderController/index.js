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
		    url : powderViewUrl,
                data: {id:id,name:name},
                async:val_async,
		    type: 'GET',
		    dataType:'json',
		    success: function(result) {
                      var tables = $.fn.dataTable.fnTables(true);

                      $(tables).each(function () {
                          $(this).dataTable().fnDestroy();
                      });
			    if(result.length>0){
			    	var html = '';
				    for(var i=0; i<result.length; i++){
						html += '<tr data-id="'+result[i]['id']+'">';
						html += '<td>'+result[i]['id']+'</td>';
			                	html += '<td>'+(result[i]['name']==null?'':result[i]['name'])+'</td>';
                                    html += '<td>'+(result[i]['name']==null?'':result[i]['price'])+'</td>';
			                	html += '<td><a  href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="'+imgUrl+'edit.png"/></a> ';
			                	html += '<a href="#" class="delete" data-id="'+result[i]['id']+'"><img src="'+imgUrl+'del.png"/></a></td>';
				        html += '</tr>';
				        
					}
			       $('#detail_data').html(html);       
			    }else{
			    	$('#detail_data').html(''); 
			    }
                      $('.datatable').DataTable({
                              "sScrollY" : "360px",
                              "scrollCollapse": true,
                              "paging":         false,
                              "responsive": true,
                              "searching": false, 
                              "ordering": false,
                              "info":     false,
                              "destroy": true,
                              "oLanguage": {
                                  "sEmptyTable": message_empty_data
                              }
                        });
		    }
            });
            
}

$(document).ready(function(){
	$("#search").click(function(){
            
		
	});
	$(document).on("click",".delete",function(){
		var id = $(this).data("id");
		var data = {id:id}
		$(this).parent().parent().attr("data-delete","1");
		$(this).parent().parent().siblings().attr("data-delete","0");
            var msg = String.format(message_confirm_delete_field, "???ID : "+ id);
		$(this).helloWorld(msg,null,null,{url:delUrl,data:data,error_message:'',success_callback_function:"remove_record"});
	});
	window.remove_record = function remove_record(){
		$("#detail_data").find("tr[data-delete=1]").remove();
	}
      window.add_record = function add_record(data,result){
            // reset data list
            $('form')[0].reset();
            showList("false");
            $("tr[data-id="+result.data['id'] +"]").remove();

             $('#create-form').modal('toggle');
             var html = "<tr data-id="+result.data['id'] +">";
            html += "<td>"+result.data['id']+"</td>";
            html += "<td>"+result.data['name']+"</td>";
            html += "<td>"+result.data['price']+"</td>";
            html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="'+imgUrl+'edit.png"/></a>';
            html += '<a href="#" class="delete" data-id="'+result.data['id']+'"><img src="'+imgUrl+'del.png"/></a></td>';
            html += "</tr>";

            $('#detail_data').html(html+$('#detail_data').html());
      
      }
	$("#save").click(function(){
            if(raiseValidateCreate() == false)
                  return false;

            var data = {};
            data.name = $("#create_name").val();
            data.price = $("#create_price").val();
            data.id = $("#create_id").val();
            $("#save").helloWorld(message_confirm_save_field ,null,null,{url:createUrl,data:data,error_message:'',success_callback_function:"add_record", is_master: true});
      
      })
      $("#create").click(function(){
            $("#create_id").val('');
            $("#create_name").val('');
            $("#create_code").val('');
            $("#create_price").val('');
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
            var id = $("#edit_id").val();
            var editTr = $("#detail_data").find("tr[data-id="+id+"]");
            editTr.find("td:eq(0)").text($("#change_id").val());
            editTr.find("td:eq(1)").text($("#edit_name").val());
            editTr.find("td:eq(2)").text($("#edit_price").val());
                  
      }
	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;

            var data = {};
            data.id = $("#edit_id").val();
            data.id_change = $("#change_id").val();
            data.name = $("#edit_name").val();
            data.price = $("#edit_price").val();
            $("#save").helloWorld(message_confirm_save_field ,null,null,{url:editUrl,data:data,error_message:'',success_callback_function:"edit_record", is_master: true});
            
      });
	
	$(document).on("click",".edit",function(){
		var id =$(this).parent().parent().find("td:eq(0)").text().trim();
		var name =$(this).parent().parent().find("td:eq(1)").text().trim();
            var price =$(this).parent().parent().find("td:eq(2)").text().trim();
        $("#edit_id").val(id);
        $("#change_id").val(id);
        $("#edit_name").val(name);
        $("#edit_price").val(price);
      })
	$("#form").validate({
            rules : {
              create_price:{
                required:true,
                number:true,
                min:1
              },
            	create_name:{
            		required:true,
            	},
                  create_id:VALIDATION_ID
            },
            tooltip_options: {  // <- totally invalid option
		        create_name: {
		            placement: 'bottom',html:true
		        },
                    create_id:{
                        placement: 'top',html:true
                    }
		    }
      });
	$("#edit_form").validate({
            rules : {
              create_price:{
                required:true,
                number:true,
                min:1
              },
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
            "sScrollY" : "360px",
            "scrollCollapse": false,
            "paging":         false,
            "responsive": true,
            "searching": false, 
            "ordering": false,
            "info":     false,
            "destroy": true,
            "oLanguage": {
                  "sEmptyTable": message_empty_data
            }
      });
	
})