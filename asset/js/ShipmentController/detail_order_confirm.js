// Update container
$(document).on('click','#shipment_update_container', function(){
	var detail_data = [];
    $("#edit_shipment_confirm > tbody > tr:not(.sum-col)").each(function(index){
        var item ={
            'customer' : $(this).find('td').find('.product_customer').val(),
            'customer_name' : $(this).find('td').find('.product_customer_name').val(),
            'department' : $(this).find('td').find('.product_derpartment').val(),
            'department_name' : $(this).find('td').find('.product_derpartment_name').val(),
            'product_id' : $(this).find('td').find('.product_code').val(),
            'product_weight' : $(this).find('td').find('.shipment_product_weight').val(),
            'quantity' : $(this).find('td').find('.product_quantity_order').val(),
            'quantity_change' : $(this).find('td').find('.product_quantity_change').val(),
            'quantity_delivery' : $(this).find('td').find('.product_quantity_delivery').val(),
            'container1' : $(this).find('td').find('.product_quantity_container1').val(),
            'container2' : $(this).find('td').find('.product_quantity_container2').val(),
            'comment' : $(this).find('td').find('.product_shipment_comment').val(),
        };
        detail_data.push(item); 
    });

    // Validation
    ValidationFormShipment();

    // Update Container
    UpdateContainerShipment(detail_data);
});

// Update container
$(document).on('click','#shipmentConfirmRequest', function(){
    var detail_data = [];
    $("#edit_shipment_confirm > tbody > tr:not(.sum-col)").each(function(index){
        var item ={
            'customer' : $(this).find('td').find('.product_customer').val(),
            'customer_name' : $(this).find('td').find('.product_customer_name').val(),
            'department' : $(this).find('td').find('.product_derpartment').val(),
            'product_id' : $(this).find('td').find('.product_code').val(),
            'product_weight' : $(this).find('td').find('.shipment_product_weight').val(),
            'quantity' : $(this).find('td').find('.product_quantity_order').val(),
            'quantity_change' : $(this).find('td').find('.product_quantity_change').val(),
            'quantity_delivery' : $(this).find('td').find('.product_quantity_delivery').val(),
            'container1' : $(this).find('td').find('.product_quantity_container1').val(),
            'container2' : $(this).find('td').find('.product_quantity_container2').val(),
            'comment' : $(this).find('td').find('.product_shipment_comment').val(),
        };
        detail_data.push(item);
    });

    // Validation
    ValidationFormShipment();

    // Update Container
    UpdateContainerShipment(detail_data);

    // Save confirm
    SaveConfirmShipment(detail_data);
});

// Function Form Submit
function ValidationFormShipment(){
	// Setting validation
    $("#edit_form_shipment").validate({
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 50
            }, 800);
        }
    });

    $('.product_quantity_delivery').each(function() {
        $(this).rules('add', {
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'right'
        }); 
    });
    $('.product_quantity_container1').each(function() {
        $(this).rules('add', {
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });
    $('.product_quantity_container2').each(function() {
        $(this).rules('add', {
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });

    //Show loading display here
    var form = $("#edit_form_shipment");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }
}

// Function Update Container
function UpdateContainerShipment(detail_data){
    var ContInTruck = $("#shipmentContInTruck").val();
    var WeightInTruck = $("#shipmentWeightInTruck").val();
    var Truck = $("#shipmentTruck").val();

    $.ajax({
        url:getContainerShipment,
        data:{ContInTruck:ContInTruck,WeightInTruck:WeightInTruck,Truck:Truck,detail:detail_data,type_delivery:true},
        dataType:'json',
        method:'POST',
        success:function(result){
            if(result != null && result != '') {
                if(result.success == true) {
                    $('#shipmentTotal').val(result['lblTotal']);
                    $('#shipmentWeight').val(result['lblWeight'] + ' kg');
                    $('#shipmentWeight').data('weight',result['lblWeight']);
                    $('#shipmentTruck_Main').val(result['lblTruckMain']);
                    $('#shipmentTruck_Aid').val(result['lblTruckAid']);

                    // container
                    for (var i = 0; i <= 14; i++) {
                        if(result['detailContainer'] != null && (jQuery.type(result['detailContainer'][i]) !== "undefined")) {
                            $('#keyContainer'+(i+1)).html(result['detailContainer'][i]['container']);
                            $('#valueContainer'+(i+1)).html(result['detailContainer'][i]['num']);
                        }
                        else {
                            $('#keyContainer'+(i+1)).html('');
                            $('#valueContainer'+(i+1)).html('');
                        }
                    }
                    
                }
                else {
                    $(this).helloWorld(result.message);
                }
            }
        }
    });
}

// Function Save
function SaveConfirmShipment(detail_data){ 
    var data_meta = {
        'OS_TOTAL_NUMBER_CONTAINERS' : $('#shipmentTotal').val(),
        'OS_GROSS_WEIGHT' : $('#shipmentWeight').data('weight'),
        'OS_NUMBER_TRUCKS' : $('#shipmentTruck_Main').val(),
        'OS_NUMBER_TRAIN' : $('#shipmentTruck_Aid').val(),
        'OS_UPDATE_DATE' : date_update
    };
    var status = 5; 

    var data = { id_order:order_id,data_meta:data_meta,data_detail:detail_data, data_status:status };
    var url = urlShipmentConfirm;
    var error_message = errorAjax;
    
    $(this).helloWorld(titleAjax, urlShipmentIndex, null, {
        url: url,
        data: data,
        error_message: error_message
    });
}