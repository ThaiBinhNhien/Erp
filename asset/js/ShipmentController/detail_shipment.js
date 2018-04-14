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

$(document).on("click","#btnExportCsv", function(){
	var TotalContainer = $('#shipmentTotal').val();
	var Weight = $('#shipmentWeight').val();
	var truck = $('#shipmentTruck_Main').val();
	var Nonsense = $('#shipmentTruck_Aid').val();
	var getUrl = urlExportCsvDetail.split("?")[0];
	getUrl = getUrl + '?id=' + id_export_detail + '&csv=true&TotalContainer=' + 
	TotalContainer + '&Weight=' + Weight + '&truck=' + truck + '&Nonsense=' + 
	Nonsense;
	window.open(getUrl, '_blank');
});

$(document).on("click","#print-set-container",function(){
	 
	var input_set_container = $('#input-set-container').val();
	var is_only_input = false;
	// Count container
	var arrContainer = [];
	$('.box_container').each(function (index, value) {
		var container = $(this).html();
		arrContainer.push(container);
	});
	console.log(arrContainer);
	// Check set container
	if(input_set_container != '') {
		var arrSet = input_set_container.split(",");
		if(arrSet.length > 1) {is_only_input=true;}
		for (var i = 0; i < arrSet.length; i++) {
			var arrValue = arrSet[i].split("-"); 
			if(arrValue.length > 1) {
				is_only_input=true;
                for (var j=0; j < arrValue.length; j++) { 
                	if(!isNumeric(arrValue[j])) {
                		$(this).helloWorld(message_not_no_container);
	                    return false;
					}
					if ( $.inArray( arrValue[j], arrContainer ) <= -1 ) {
						$(this).helloWorld(message_not_exits_container);
	                    return false;
					}
                }
            } else {
                if(!isNumeric(arrSet[i])) {
                	$(this).helloWorld(message_not_no_container);
                    return false;
				}
				if ( $.inArray( arrSet[i], arrContainer ) <= -1 ) {
					$(this).helloWorld(message_not_exits_container);
					return false;
				}
            }
		}
	}
	
	$('#form-set-container').submit();
});

function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
  }