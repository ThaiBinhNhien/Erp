$(document).ready(function(){
	$("#search").click(function(){
		var id = $("#id").val();
		var name = $("#name").val();
		var display_name = $("#name").val();
		$.ajax({
			url : groupViewUrl,
		    data: {id:id,display_name:display_name,name:name},
		    type: 'GET',
		    dataType:'json',
		    success: function(result) {
		    	var tables = $.fn.dataTable.fnTables(true);

                $(tables).each(function () {
                    $(this).dataTable().fnDestroy();
                });
			    if(result.length>0){
			    	var html = "";
				    for(var i=0; i<result.length; i++){
						html += '<tr>';
						html += '<td>'+result[i]['id']+'</td>';
			            html += '<td>'+(result[i]['name']==null?'':result[i]['name'])+'</td>';
			            html += '<td>'+(result[i]['display_name']==null?'':result[i]['display_name'])+'</td>';
			            html += '<td>'+(result[i]['address']==null?'':result[i]['address'])+'</td>';
			            html += '<td>'+(result[i]['discount']==null?'':result[i]['discount'])+'</td>';
			            html += '<td>'+(result[i]['environment_fee']==null?'':result[i]['environment_fee'])+'</td>';
			            html += '<td>'+(result[i]['fixed_amount']==null?'':result[i]['fixed_amount'])+'</td>';
			            html += '<td>';
			            html += '<a href="'+editUrl+'?id='+result[i]['id']+'"><img src="'+imgUrl+'edit.png"/></a> ';
			            html += '<a href="#" class="delete" data-id="'+result[i]['id']+'"><img src="'+imgUrl+'del.png"/></a>';
			            html +='</td>';
				        html += '</tr>';
				        
					}
			       $('#detail_data').html(html);       
			    }else{
			    	$('#detail_data').html(''); 
			    	$('#search').helloWorld(message_empty_data,null);
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
		
	});
	$("#btnImport2").click(function(){
		var val = $("#get_type_csv").val();
		if(val == 1){
			url_import = url_import_master;	
		}else{
			url_import = url_import_detail;
		}
	})

	$("#btnExport").click(function(){
		var val = $("#get_type_csv").val();
		if(val == 1){
			url_export = url_export_master;	
		}else{
			url_export = url_export_detail;
		}
		
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
	 	

		$('.datatable').DataTable( {
			"sScrollY" : "360px",
			"scrollCollapse": true,
            "paging":         false,
            "responsive": true,
            "searching": false, 
            "ordering": false,
            "info":     false,
            "destroy": true
		} );
})