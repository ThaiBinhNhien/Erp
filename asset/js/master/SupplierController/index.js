var called_index = 0;
$(document).ready(function(){
	LoadData();
}); 
function LoadData(){
		var sup_id 			 = $("#sup_id").val();
		var sup_company_name = $("#sup_company_name").val();
		var sup_phone_number = $("#sup_phone_number").val();
		var sup_contact_name = $("#sup_contact_name").val();
		var sup_fax_number 	 = $("#sup_fax_number").val();
		var sup_address 	 = $("#sup_address").val();
		var sup_postal_code  = $("#sup_postal_code").val();
		$.ajax({
			url:supplierViewUrl,
			data:{sup_id : sup_id, sup_company_name:sup_company_name,sup_phone_number:sup_phone_number,sup_contact_name:sup_contact_name,sup_fax_number:sup_fax_number,
				sup_address:sup_address,sup_postal_code:sup_postal_code, start_index:0},
			dataType:'json',
			method:'GET',
			success:function(result){
				//temp
				$("#supplier-table").css("display","block");
				var tables = $.fn.dataTable.fnTables(true);

				$(tables).each(function () {
				    $(this).dataTable().fnDestroy();
				});
				//$("#table_header").parent().parent().parent().attr("id","product-table");
				var html = '';
				for(var i=0; i<result.length; i++){
					html += '<tr>';
					html += '<td>'+(result[i]['supplier_id'] == null ? "" : result[i]['supplier_id']) +'</td>';
					html += '<td>'+(result[i]['sup_company_name'] == null ? "" : result[i]['sup_company_name']) +'</td>';
					html += '<td>'+(result[i]['sup_postal_code'] == null ? "" : result[i]['sup_postal_code']) +'</td>';
					html += '<td>'+(result[i]['sup_address_1'] == null ? "" : result[i]['sup_address_1']) +'</td>';
					html += '<td>'+(result[i]['sup_address_2'] == null ? "" : result[i]['sup_address_2']) +'</td>';
					html += '<td><a href='+ edit_supplierUrl + '?id='+result[i]['supplier_id'] +'><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['supplier_id']+'" class="delete-supplier" href="#"><img src='+assetImgUrl+'del.png></a></td>';
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
            },
		})
}
$(document).ready(function(){

	$(document).on("click",".delete-supplier",function(){
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

	
	$("#search").click(function(){
		LoadData();
		
	});
	
});

  function renewScroll(){
 	$('#supplier-table .dataTables_scrollBody').on('scroll', function() {
	  //Return number tr row in tbody
		var start_index = $('#supplier-table tbody tr').length;
		var sup_id 			 = $("#sup_id").val(); 
		var sup_company_name = $("#sup_company_name").val();
		var sup_phone_number = $("#sup_phone_number").val();
		var sup_contact_name = $("#sup_contact_name").val();
		var sup_fax_number 	 = $("#sup_fax_number").val();
		var sup_address 	 = $("#sup_address").val();
		var sup_postal_code  = $("#sup_postal_code").val();
	  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
	      $.ajax({
	              url:supplierViewUrl,
				  data:{sup_id: sup_id, sup_company_name:sup_company_name,sup_phone_number:sup_phone_number,sup_contact_name:sup_contact_name,sup_fax_number:sup_fax_number,
						sup_address:sup_address,sup_postal_code:sup_postal_code, start_index:start_index},
	              type: 'GET',
	              dataType:'json',
	              success: function(result) {
		              if(result.length>0){
			              for(var i=0; i<result.length; i++){
							var html = '<tr>';
							html += '<td>'+(result[i]['supplier_id'] == null ? "" : result[i]['supplier_id']) +'</td>';
							html += '<td>'+(result[i]['sup_company_name'] == null ? "" : result[i]['sup_company_name']) +'</td>';
							html += '<td>'+(result[i]['sup_postal_code'] == null ? "" : result[i]['sup_postal_code']) +'</td>';
							html += '<td>'+(result[i]['sup_address_1'] == null ? "" : result[i]['sup_address_1']) +'</td>';
							html += '<td>'+(result[i]['sup_address_2'] == null ? "" : result[i]['sup_address_2']) +'</td>';
							html += '<td><a href='+ edit_supplierUrl + '?id='+result[i]['supplier_id'] +'><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['supplier_id']+'" class="delete-supplier" href="#"><img src='+assetImgUrl+'del.png></a></td>';
		                	html += '</tr>';
		                	$('#detail_data').append(html);
						}
						// Adjust
						var table = $('#supplier-table table').DataTable();
						table.columns.adjust();
		              
		              }
	              }
	       });
	    };
	});
 }
