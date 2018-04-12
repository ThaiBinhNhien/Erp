// render
$(document).ready(function() {
    $('.datepicker_delivery_plan, .datepicker_delivery').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy年mm月dd日 (DD)',
        dayNames: ['日', '月', '火', '水', '水', '金', '土']
    }).attr('readonly','readonly');

    $('.datepicker_delivery_ship').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy年mm月dd日 (DD)',
        dayNames: ['日', '月', '火', '水', '水', '金', '土'],
        minDate: dateOrder.replace('日(', '日 ('),
    }).attr('readonly','readonly');

    var date_delivery = $('#set_delivery_date').val();
    if(date_delivery != '') {
        $('.datepicker_delivery_ship').datepicker('setDate', date_delivery.replace('日(', '日 ('));
    }
    else {
        $('.datepicker_delivery_ship').datepicker('setDate', $('.datepicker_delivery_plan').val().replace('日(', '日 ('));
    }

    //$('.datepicker_delivery_ship').datepicker('minDate', "2018-01-17");
    
});

// on change
$(document).on('change', '#get_delivery_date', function(){
    var dateChange = $("#get_delivery_date").val();
    var dateOld = $.datepicker.formatDate("yy年mm月dd日", $("#get_delivery_date").datepicker('getDate'));
    if(dateChange != '') {
        var arrDateChange = dateChange.split(' ');
        if(arrDateChange.length > 0 && arrDateChange[0] != dateOld) {
            $(this).datepicker('setDate', 'today');
        }
    }

    //Show loading display here
    var form = $("#form_delivery_edit");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }
})

// Save
$(document).on('click', '#save-delivery', function() { 
    if(count_checklist == sum_checklist) {
		$(this).helloWorld(message_not_redirect_to_delivery);
	} else {
        // Setting validation
        $("#form_delivery_edit").validate({ 
            invalidHandler: function(form, validator) {
                if (!validator.numberOfInvalids())
                    return;

                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top - 50
                }, 800);
            }
        });

        $('#get_delivery_date').rules('add', {
            required: true
        });
        $('#get_delivery_date').tooltip({
            trigger: 'manual',
            placement:'bottom'
        });

        $('.valid_positive_number').each(function() {
            $(this).rules('add', {
                number: true,
                min: 0
            });
            $(this).tooltip({
                trigger: 'manual',
                placement:'left'
            }); 
        });
        //get_product_price
        $('.get_product_price').each(function() {
            var number_quantity = $(this).parent().parent().find('.get_product_quantity').val();
            if(number_quantity != '' && number_quantity > 0) {
                $(this).rules('add', {
                    required: true,
                    number: true,
                    min: 0
                });
                $(this).tooltip({
                    trigger: 'manual',
                    placement:'left'
                }); 
            }
        });

        //get_product_price_gaichyu
        $('.get_product_price_gaichyu').each(function() {
            var number_quantity = $(this).parent().parent().find('.get_product_quantity').val();
            if(number_quantity != '' && number_quantity > 0) {
                $(this).rules('add', {
                    required: true,
                    number: true,
                    min: 0
                });
                $(this).tooltip({
                    trigger: 'manual',
                    placement:'bottom'
                }); 
            }
        });

        //Show loading display here
        var form = $("#form_delivery_edit");

        // Validation
        var validator = form.data("validator");
        if (!validator || !form.valid()) {
            return false;
        }

        var detail_data = [];
        $("#get_table_delivery > tbody > tr:not(.sum-col)").each(function(index){
            var item ={
                'order_id' : $(this).find('td').find('.get_order_id').val(),
                'product_id' : $(this).find('td').find('.get_product_id').val(),
                'product_name' : $(this).find('td').find('.value_product_name').val(),
                'quantity_old' : $(this).find('td').find('.get_product_quantity').data('old'),
                'quantity' : $(this).find('td').find('.get_product_quantity').val(),
                'quantity_order' : $(this).find('td.copy').html(),
                'price' : $(this).find('td').find('.get_product_price').val(),
                'price_gaichyu' : $(this).find('td').find('.get_product_price_gaichyu').val(),
                'amount' : $(this).find('td').find('.get_amount').val(),
                'check' : $(this).find('td').find('.get_check').val(),
                'special' : $(this).find('td').find('.get_special').val(),
            };
            detail_data.push(item);
        });

        var date_delivery = $.datepicker.formatDate("yy-mm-dd", $("#get_delivery_date").datepicker('getDate'));
        var data = { id_order: $('#get_order_code').val(),date_update:date_update,delivery_date: date_delivery,note: $('#get_delivery_note').val(), detail: detail_data };
        var url = editUrl;
        var error_message = message_error_ajax;

        $(this).helloWorld(message_fix_confirm_delivery, receivedUrl, null, {
            url: url,
            data: data,
            error_message: error_message
        });
    }

});

// Onchange quantity
$(document).on('change','.get_product_quantity', function(){
    var quantity = $(this).val();
    var price = $(this).parent().parent().find('.get_product_price').val();
    var price_gaichyu = $(this).parent().parent().find('.get_product_price_gaichyu').val();
      if(parseFloat(quantity) > 0 || parseFloat(price) > 0 || parseFloat(price_gaichyu) > 0) {
        if(quantity == '') {
            quantity = 0;
        }
        if(price == '') {
            price = 0;
        }
        if(price_gaichyu == '') {
            price_gaichyu = 0;
        }
        var amount = parseFloat(quantity) * parseFloat(price);
        var amount_gaichyu = parseFloat(quantity) * parseFloat(price_gaichyu);

        $(this).parent().parent().find('.get_amount').val(amount.toFixed(2));
        $(this).parent().parent().find('.get_amount_gaichyu').val(amount_gaichyu.toFixed(2));
      }
      setTotalAmountDelivery();
});

// Onchange amount
$(document).on('change','.get_amount', function(){
      setTotalAmountDelivery();
});

// Onchange price
$(document).on('change','.get_product_price', function(){
    var price = $(this).val();
    var quantity = $(this).parent().parent().find('.get_product_quantity').val();
      if(parseFloat(quantity) > 0 || parseFloat(price) > 0) {
        if(quantity == '') {
            quantity = 0;
        }
        if(price == '') {
            price = 0;
        }
        var amount = parseFloat(quantity) * parseFloat(price);
        $(this).parent().parent().find('.get_amount').val(amount.toFixed(2))
      }
      setTotalAmountDelivery();
});

// Onchange price for gaichyu
$(document).on('change','.get_product_price_gaichyu', function(){
    var price = $(this).val();
    var quantity = $(this).parent().parent().find('.get_product_price_gaichyu').val();
      if(parseFloat(quantity) > 0 || parseFloat(price) > 0) {
        if(quantity == '') {
            quantity = 0;
        }
        if(price == '') {
            price = 0;
        }
        var amount = parseFloat(quantity) * parseFloat(price);
        $(this).parent().parent().find('.get_amount_gaichyu').val(amount.toFixed(2))
      }
      setTotalAmountDelivery();
});

// delivery_total_amount
function setTotalAmountDelivery(){ 
    var totalAmount = 0;
    var totalAmountGaichyu = 0;
    $("#get_table_delivery > tbody > tr:not(.sum-col)").each(function(index){ 
        var get_amount = $(this).find('td').find('.get_amount').val();
        var get_amount_gaichyu = $(this).find('td').find('.get_amount_gaichyu').val();
        if(parseFloat(get_amount) > 0 || parseFloat(get_amount_gaichyu) > 0) {
            totalAmount += parseFloat(get_amount);
            totalAmountGaichyu += parseFloat(get_amount_gaichyu);
        }
      });

    $('#delivery_total_amount').html(formatMoney(totalAmount.toFixed(2)));
    $('#delivery_total_amount_gaichyu').html(formatMoney(totalAmountGaichyu.toFixed(2)));
}

$(document).on("change",".get_product_price", function(){
    var value_price = $(this).val();
    var value_price_gaichyu = $(this).parent().parent().find('.get_product_price_gaichyu').val();
    
    if(value_price != "" && value_price_gaichyu != "") {
        if(parseFloat(value_price) < parseFloat(value_price_gaichyu)) {
            $(this).helloWorld(message_add_error_price_gaichyn);
        }
    }

});

$(document).on("change",".get_product_price_gaichyu", function(){
    var value_price_gaichyu = $(this).val();
    var value_price = $(this).parent().parent().find('.get_product_price').val();

    if(value_price != "" && value_price_gaichyu != "") {
        if(parseFloat(value_price) < parseFloat(value_price_gaichyu)) {
            $(this).helloWorld(message_add_error_price_gaichyn);
        }
    }

});