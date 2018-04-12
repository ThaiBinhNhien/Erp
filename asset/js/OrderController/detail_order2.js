$(document).ready(function(){


	$("#delete").click(function(){
		var id = $(this).data('id');
		var data = {id:id};
		var url = deleteUrl; 
		var error_message = "Cannot delete!";
		var msg = String.format(message_confirm_delete_field, "注文No : "+ id);
		$(this).helloWorld(msg,receivedUrl,null,{url:url,data:data,error_message:''});
	});
	$("#edit").click(function(){
		$(this).helloWorld("売上処理されているため、編集出来ません。",null);
	});
	$("#delete2").click(function(){
		$(this).helloWorld("売上処理されているため、編集出来ません。",null);
	});

	// Copy order to shipment
	$("#copyToShipment").click(function(){

		if(order_id == '' || order_id == null){
			return;
		}

		var data = {order_id:order_id,customer_id:customer_id};
		var url = copy_order_to_shipment;
		var error_message = message_copy_order_to_shipment_error;
		var msg = message_copy_order_to_shipment_title;
		var urlIndex= window.location.href;
		$(this).helloWorld(msg,urlIndex,null,{url:url,data:data,error_message:''});

	});
});

$("#pdf_output").click(function(){
		var urls = $(this).data("url");
		var arr = urls.split(';');
		if(arr == null || arr.length == 0){
			window.open(urls,'_blank');
			return;
		}else{
			for(var i=0; i<arr.length;i++){
				window.open(arr[i],'_blank');
			}
		}
	});

$(document).on("click","#btn_url_edit_delivery", function(){
	if(count_checklist == sum_checklist) {
		$(this).helloWorld(message_not_redirect_to_delivery);
	} else {
		window.open(url_edit_delivery,"_self");
	}
});