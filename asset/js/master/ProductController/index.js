var called_index = 0;
$(document).ready(function(){
	LoadData();
});
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


// Load Data
function LoadData(){
	var product_id = $("#product_id").val();
	var product_name = $("#product_name").val();
	$.ajax({
		url:productViewUrl,
		data:{product_id:product_id,product_name:product_name,start_index:0},
		dataType:'json',
		method:'GET',
		success:function(result){
			//temp
			$("#product-table").css("display","block");
			var tables = $.fn.dataTable.fnTables(true);

			$(tables).each(function () {
				$(this).dataTable().fnDestroy();
			});
			//$("#table_header").parent().parent().parent().attr("id","product-table");
			
			var html = '';
			for(var i=0; i<result.length; i++){
				html += '<tr>';
				html += '<td>'+result[i]['id']+'</td>';
				html += '<td>'+(result[i]['buy_product_id'] == null ?'' :result[i]['buy_product_id'] )+'</td>';
				html += '<td>'+(result[i]['buy_product_name'] == null ?'' :result[i]['buy_product_name']) +'</td>';
				html += '<td>'+(result[i]['sell_product_id'] == null ?'' :result[i]['sell_product_id']) +'</td>';
				html += '<td>'+(result[i]['sell_product_name'] == null ?'' :result[i]['sell_product_name']) +'</td>';
				html += '<td>'+(result[i]['product_standard'] == null ?'' :result[i]['product_standard']) +'</td>';
				html += '<td>'+(result[i]['color'] == null ?'' :result[i]['color']) +'</td>';
				html += '<td><a href='+ edit_productUrl + '?id='+result[i]['id'] +'><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['id']+'" class="delete"  href="#"><img src='+assetImgUrl+'del.png></a></td>';
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
            html = '<tr class="odd row-empty"><td valign="top" colspan="8" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            $("#price-product-export tbody").html(html);
		},
	});
}


 function renewScroll(){
	 $('#product-table .dataTables_scrollBody').on('scroll', function() {
	  //Return number tr row in tbody

		var start_index = $('#detail_data tr').length;
		var product_id = $("#product_id").val();
		var product_name = $("#product_name").val();
		  if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
		  $.ajax({
				  url : productViewUrl,
				  data:{product_id:product_id,product_name: product_name, start_index:start_index},
				  type: 'GET',
				  dataType:'json',
				  success: function(result) {
					  if(result.length>0){
						  for(var i=0; i<result.length; i++){
							var html = '<tr>';
							html += '<td>'+result[i]['id']+'</td>';
							html += '<td>'+(result[i]['buy_product_id'] == null ?'' :result[i]['buy_product_id'] )+'</td>';
							html += '<td>'+(result[i]['buy_product_name'] == null ?'' :result[i]['buy_product_name']) +'</td>';
							html += '<td>'+(result[i]['sell_product_id'] == null ?'' :result[i]['sell_product_id']) +'</td>';
							html += '<td>'+(result[i]['sell_product_name'] == null ?'' :result[i]['sell_product_name']) +'</td>';
							html += '<td>'+(result[i]['product_standard'] == null ?'' :result[i]['product_standard']) +'</td>';
							html += '<td>'+(result[i]['color'] == null ?'' :result[i]['color']) +'</td>';
							html += '<td ><a href='+ edit_productUrl + '?id='+result[i]['id'] +'><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['id']+'" class="delete"  href="#"><img src='+assetImgUrl+'del.png></a></td>';
							html += '</tr>';
							$('#detail_data').append(html);
						}
						// Adjust
						var table = $('#product-table table').DataTable();
						table.columns.adjust();
					  }
				  }
		   });
		};
	});
 }