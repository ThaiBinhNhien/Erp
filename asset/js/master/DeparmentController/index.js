function showList(val_async){

    // value for async
    if(val_async == "" || val_async == null) {
        val_async = true;
    } else {
        val_async = false;
    }

    var id = $("#id").val();
		var name = $("#name").val();
		var code = $("#code").val();
		$.ajax({
			url : departmentViewUrl,
            data: {id: id, name:name,code:code},
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
						html += '<tr>';
						html += '<td>'+result[i]['id']+'</td>';
			                	html += '<td>'+(result[i]['name']==null?'':result[i]['name'])+'</td>';
						    html += '<td>'+(result[i]['code']==null?'':result[i]['code'])+'</td>';
						    html += '<td>'+(result[i]['name_code']==null?'':result[i]['name_code'])+'</td>';
			                	html += '<td><a  href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="'+imgUrl+'edit.png"/></a> ';
			                	html += '<a href="#" class="delete" data-id="'+result[i]['id']+'"><img src="'+imgUrl+'del.png"/></a></td>';
				        html += '</tr>';
				        
					}
			        $('#detail_data').html(html); 
			    }else{
			    	$('#detail_data').html(''); 
                    /*$('#search').helloWorld(message_empty_data,null);*/
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
        showList();
	});
      $("#create").click(function(){
            $("#create_id").val('');
            $("#create_name").val('');
            $("#create_code").val('').change();
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
    window.add_record = function add_record(data,result){
        // reset data list
        $('form')[0].reset();
        showList("false");
        $("tr[data-id="+result.data['id']+"]").remove();

        var html = '<tr data-id="'+result.data['id']+'">';
        html += "<td>"+result.data['id']+"</td>";
        html += "<td>"+result.data['name']+"</td>";
        html += "<td>"+result.data['code']+"</td>";
        html += '<td>'+result.data['name_code']+'</td>';
        html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="'+imgUrl+'edit.png"/></a> ';
        html += '<a href="#" class="delete" data-id="'+result.data['id']+'"><img src="'+imgUrl+'del.png"/></a></td>';
        html += "</tr>";
        $('#detail_data').html(html+$('#detail_data').html());   
       // $('#detail_data').prepend(html); 
        $('#create-form').modal('toggle');
                
    }
	$("#save").click(function(){
            if(raiseValidateCreate() == false)
                  return false;

            var data = {};
            data.id = $("#create_id").val();
            data.name = $("#create_name").val();
		    data.code = $("#create_code").val();
		    data.name_code = $('#create_code').inputpicker('element', $("#create_code").val())['グループ'];
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
            editTr.find("td:eq(0)").text($("#edit_id").val());
            editTr.find("td:eq(1)").text($("#edit_name").val());
            editTr.find("td:eq(2)").text($("#edit_code").val()); 
            editTr.find("td:eq(3)").text($('#edit_code').inputpicker('element', $("#edit_code").val())['グループ']);
            
    }
	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;

            var data = {};
            data.id = $("#dp_id").val();
            data.id_change = $("#edit_id").val();
            data.name = $("#edit_name").val();
            data.code = $("#edit_code").val();
            $("#save").helloWorld(message_confirm_save_field ,null,null,{url:editUrl,data:data,error_message:'',success_callback_function:"edit_record", is_master: true});
            
      });
	
      $("#create_code").inputpicker({
        data:dpData,
        fields:[{name:"グループコード",value:"グループコード"},
                {name:"グループ",value:"グループ"}],
        fieldValue:"グループコード",
        fieldText:"グループコード",
        filterOpen: true,
        autoOpen: true,
        headShow: true,
        pagination: false
      });

      $("#edit_code").inputpicker({
        data:dpData,
        fields:[{name:"グループコード",value:"グループコード"},
                {name:"グループ",value:"グループ"}],
        fieldValue:"グループコード",
        fieldText:"グループコード",
        filterOpen: true,
        autoOpen: true,
        headShow: true,
        pagination: false,  
      });

	$(document).on("click",".edit",function(){
		var id =$(this).parent().parent().find("td:eq(0)").text().trim();
		var name =$(this).parent().parent().find("td:eq(1)").text().trim();
		var code =$(this).parent().parent().find("td:eq(2)").text().trim();
        $("#dp_id").val(id);
        $("#edit_id").val(id);
        $("#edit_name").val(name);
        $("#edit_code").val(code);
        $("#edit_code").inputpicker({
        data:dpData,
        fields:[{name:"グループコード",value:"グループコード"},
                {name:"グループ",value:"グループ"}],
        fieldValue:"グループコード",
        fieldText:"グループコード",
        filterOpen: false,
        autoOpen: true,
        headShow: true,
        pagination: false,  
      });
      })
	$("#form").validate({
            rules : {
                  create_id: VALIDATION_ID,
            	create_name:VALID_DEPARTMENT_CREATE_NAME,
                create_code:{
                    required:true
                }
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
            	},
                create_code:{
                    create_code:true
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
	
})