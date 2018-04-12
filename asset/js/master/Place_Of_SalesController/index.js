var called_index = 0;
$(document).ready(function(){
	LoadData();
}); 
function LoadData(){
	var distributor_id= $("#distributor_id").val();
var distributor_name = $("#distributor_name").val();
	var fax_number = $("#fax_number").val();
	var postal_code = $("#postal_code").val();
	var phone_number 	 = $("#phone_number").val();
	var address 	 = $("#address").val();
	$.ajax({
		url:viewUrl,
		data:{distributor_id: distributor_id,distributor_name:distributor_name,fax_number:fax_number,postal_code:postal_code,phone_number:phone_number,
			address:address, start_index:0},
		dataType:'json',
		method:'GET',
		success:function(result){
			//temp
			$("#place-sale-table").css("display","block");
			var tables = $.fn.dataTable.fnTables(true);

			$(tables).each(function () {
			    $(this).dataTable().fnDestroy();
			});
			//$("#table_header").parent().parent().parent().attr("id","product-table");
			var html = '';
			for(var i=0; i<result.length; i++){
				html += '<tr>';
				html += '<td>'+(result[i]['id'] == null ? "" : result[i]['id']) +'</td>';
				html += '<td>'+(result[i]['distributor_name'] == null ? "" : result[i]['distributor_name']) +'</td>';
				html += '<td>'+(result[i]['postal_code'] == null ? "" : result[i]['postal_code']) +'</td>';
				html += '<td>'+(result[i]['phone_number'] == null ? "" : result[i]['phone_number']) +'</td>';
				html += '<td>'+(result[i]['address_1'] == null ? "" : result[i]['address_1']) +'</td>';
				html += '<td>'+(result[i]['address_2'] == null ? "" : result[i]['address_2']) +'</td>';
				html += '<td><a href='+ edit_Url + '?id='+result[i]['id'] +'><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['id']+'" class="delete" href="#"><img src='+assetImgUrl+'del.png></a></td>';
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
		error: function(result){
            var html = '';
            html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            $("#price-product-export tbody").html(html);
        },
	})
}
$(document).ready(function(){

	$(document).on("click",".delete",function(){
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
 	$('#place-sale-table .dataTables_scrollBody').on('scroll', function() {
	  //Return number tr row in tbody

		var start_index = $('#place-sale-table tbody tr').length;
		var distributor_id = $("#distributor_id").val();
		var distributor_name = $("#distributor_name").val();
		var fax_number = $("#fax_number").val();
		var postal_code = $("#postal_code").val();
		var phone_number 	 = $("#phone_number").val();
		var address 	 = $("#address").val();
	  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
	      $.ajax({
	              url:viewUrl,
				  data:{distributor_id: distributor_id,distributor_name:distributor_name,fax_number:fax_number,postal_code:postal_code,phone_number:phone_number,
					address:address, start_index:start_index},
	              type: 'GET',
	              dataType:'json',
	              success: function(result) {
		              if(result.length>0){
			              for(var i=0; i<result.length; i++){
							var html = '<tr>';
							html += '<td>'+result[i]['id']+'</td>';
							html += '<td>'+result[i]['distributor_name']+'</td>';
							html += '<td>'+result[i]['postal_code']+'</td>';
							html += '<td>'+result[i]['phone_number']+'</td>';
							html += '<td>'+result[i]['address_1']+'</td>';
							html += '<td>'+result[i]['address_2']+'</td>';
							html += '<td><a href='+ edit_Url + '?id='+result[i]['id'] +'><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['id']+'" class="delete" href="#"><img src='+assetImgUrl+'del.png></a></td>';
		                	html += '</tr>';
		                	$('#detail_data').append(html);
						}
						// Adjust
						var table = $('#place-sale-table table').DataTable();
						table.columns.adjust();
		              
		              }
	              }
	       });
	    };
	});
 }
