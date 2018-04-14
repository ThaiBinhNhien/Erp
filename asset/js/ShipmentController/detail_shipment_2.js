$(document).on('click','#btnDeleteShipment', function(){
	var data = { id_order:order_id };
    var url = urlShipmentDelete;
    var error_message = errorAjax;
    
    $(this).helloWorld(titleAjax, urlShipmentIndex, null, {
        url: url,
        data: data,
        error_message: error_message
    });
});