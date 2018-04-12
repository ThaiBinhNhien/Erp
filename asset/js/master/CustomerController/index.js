var called_index = 0;
$(document).ready(function(){
	$("#search").click(function(){

		var name = $("#name").val();
		var fax = $("#fax").val();
		var address = $("#address").val();
		var phone_number = $("#phone_number").val();
		var id = $("#id").val();
		$.ajax({
			url : cusViewUrl,
		    data: {id:id,name:name,fax:fax,address:address,start_index:0},
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
			                	html += '<td>'+(result[i]['phone']==null?'':result[i]['phone'])+'</td>';
			                	html += '<td>'+(result[i]['address1']==null?'':result[i]['address1'])+'</td>';
			                	html += '<td>'+(result[i]['address2']==null?'':result[i]['address2'])+'</td>';
			                	html += '<td>';
			                	html += '<a href="'+editUrl+'?id='+result[i]['id']+'"><img src="'+imgUrl+'edit.png"/></a> ';
			                	html += '<a href="#" class="delete" data-id="'+result[i]['id']+'"><img src="'+imgUrl+'del.png"/></a>';
			                	html +='</td>';
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
				called_index = 0;
                renewScroll();
		    }
		});
		
	});

	$("#btnImport2").click(function(){
		var val = $("#get_type_csv").val();
		if(val == 1){
			url_import = url_import_master;	
		}else{
			url_import = url_import_detail_1;
		}
	})

	$("#btnExport").click(function(){
		var val = $("#get_type_csv").val();
		if(val == 1){
			url_export = url_export_master;	
		}else{
			url_export = url_export_detail_1;
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
	function renewScroll(){
	 	$('#cus-table .dataTables_scrollBody').on('scroll', function() {
		  //Return number tr row in tbody
			  var start_index = $('#detail_data tr').length;
			  if(start_index != 0){
			  	if(start_index == 1){
			  		if($('#detail_data tr > td').attr("class") == "dataTables_empty" )
			  			return;
			  	}
			  	start_index -= 1;
			  }else{
			  	return;
			  }
			  var id = $("#id").val();
			  
			  var name = $("#name").val();
			  var fax = $("#fax").val();
			  var address = $("#address").val();
			  var phone_number = $("#phone_number").val();
		  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	  if(called_index == start_index)
		 		return;
		 	  called_index = start_index;
		      $.ajax({
		              url : cusViewUrl,
		    		  data: {id:id,name:name,fax:fax,address:address,start_index:start_index},
		              type: 'GET',
		              dataType:'json',
		              success: function(result) {
			              if(result.length>0){
				              for(var i=0; i<result.length; i++){
				              	var html = '<tr>';
								html += '<td>'+result[i]['id']+'</td>';
			                	html += '<td>'+result[i]['name']+'</td>';
			                	html += '<td>'+result[i]['phone']+'</td>';
			                	html += '<td>'+result[i]['address1']+'</td>';
			                	html += '<td>'+result[i]['address2']+'</td>';
			                	html += '<td>';
			                	html += '<a href="'+editUrl+'?id='+result[i]['id']+'"><img src="'+imgUrl+'edit.png"/></a>';
			                	html += '<a href="#" class="delete" data-id="'+result[i]['id']+'"><img src="'+imgUrl+'del.png"/></a>';
			                	html +='</td>';
				        		html += '</tr>';
			                	$('#detail_data').append(html);
							}
							// Adjust
							var table = $('#cus-table table').DataTable();
							table.columns.adjust();
			              
			              }
		              }
		       });
		    };
		});
	 }

		$('.datatable').DataTable( {
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
		} );
	renewScroll();
})