// render
$(document).ready(function() {

    jQuery('#shipment_date').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#delivery_date');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');;

	jQuery('#delivery_date').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#shipment_date');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');;
    
    // Set Date
    $('#shipment_date').datepicker('setDate', 'today');
    $('#delivery_date').datepicker('setDate', 'today');



    // Get Customer
    setListCustomer(); 
});

// Ajax select
$(document).ready(function(){ 
    getCustomerByShipping();
});

// Get Customer by sipping
function getCustomerByShipping(){
    // Get Customer
    var classification = $("#shipping_category").find('option:selected').val();
    if(classification == '' || classification == null){
        return;
    }

    $.ajax({
        url:getCustomerByClassification,
        data:{classification_id:classification},
        dataType:'json',
        method:'GET',
        success:function(result){
            var option = '';
            var optionSelect = '<option value=""></option>';
            if(result != null){
                for(var i=0;i<result.length;i++){
                    option += '<option value="'+result[i]['customer_id']+'">'+result[i]['customer_shipment_name']+'</option>';
                    optionSelect += '<option value="'+result[i]['customer_id']+'">'+result[i]['customer_shipment_name']+'</option>';
                }
            }
            $("select.select_customer").html(optionSelect);
            $('select.select_customer').selectpicker('refresh');
        }
    });

    // Customer search
    var optionsCustomer = {
        ajax          : {
            url     : getCustomerByClassification,
            type    : 'GET',
            dataType: 'json',
            data    : { classification_id:classification,name: '{{{q}}}',start_index:0,number:10}
        },
        locale        : {statusInitialized: ''},
        log           : 0,
        cache: false,
        clearOnEmpty: false,
        preserveSelected: false,
        emptyRequest:true,
        preprocessData: function (data) {
            var i, l = data.length, array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text : data[i].customer_shipment_name,
                        value: data[i].customer_id,
                        disabled: false
                    }));
                }
            }
            return array;
        }
    };

    var xyz = $('select.select_customer').selectpicker().ajaxSelectPicker(optionsCustomer);
    xyz.trigger('change').data('AjaxBootstrapSelect').list.cache = {};
}

// Get customer by delivery classification
$(document).on("focusin","#shipping_category", function(){
    $(this).data('previous', $(this).val());
});
$(document).on("change","#shipping_category", function(){
    // check value
    var id_shipping = $(this).val();
    var id_shipping_previous = $(this).data("previous");
    var customer = $('select.select_customer option:selected');
    if(id_shipping != id_shipping_previous) {
        if(id_shipping_previous != null && id_shipping_previous != "") {
            if(customer.length == 1 && customer.val() == "") {
                setListCustomer();
                getCustomerByShipping();
            } else {
                $(this).helloWorld(message_add_detail_change_shipping,null,null,{
                    cancel_callback_function: 'cancel_shipping_click',
                    success_callback_function: 'ok_shipping_click',
                    not_ajax: true,
                    is_master: true
                });
            }
        }
    }
});

$(document).ready(function(){
    window.ok_shipping_click = function ok_shipping_click(){
        $("#add-shipment-table > tbody > tr:not(.sum-col) ").each(function(){
			$(this).remove();
        });
        
        setListCustomer();
    }
    window.cancel_shipping_click = function cancel_customer_click(){
        var id_shipping_previous = $("#shipping_category").data("previous");
        $("#shipping_category").val(id_shipping_previous);
    }
});

// Get department by customer
$(document).on("change","#customer", function(){
    setListDepartment();
    setListSetProduct();
});

// change shipment date
$(document).on('change', '#shipment_date', function(){
    var dateChange = $("#shipment_date").val();
    var dateOld = $.datepicker.formatDate("yy/mm/dd", $("#shipment_date").datepicker('getDate'));
    if(dateChange != '') {
        var arrDateChange = dateChange.split(' ');
        if(arrDateChange.length > 0 && arrDateChange[0] != dateOld) {
            $(this).datepicker('setDate', 'today');
        }
    }

    //Show loading display here
    var form = $("#add_form_shipment");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }
});

// change delivery date
$(document).on('change', '#delivery_date', function(){
    var dateChange = $("#delivery_date").val();
    var dateOld = $.datepicker.formatDate("yy/mm/dd", $("#delivery_date").datepicker('getDate'));
    if(dateChange != '') {
        var arrDateChange = dateChange.split(' ');
        if(arrDateChange.length > 0 && arrDateChange[0] != dateOld) {
            $(this).datepicker('setDate', 'today');
        }
    }

    //Show loading display here
    var form = $("#add_form_shipment");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }
});

// change customer
$(document).on('change', 'select.select_customer', function(){
    //Show loading display here
    var form = $("#add_form_shipment");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }
});

// CHange deparment
$(document).on('change', 'select.select_department', function(){
    //Show loading display here
    var form = $("#add_form_shipment");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }
});

// Set Customer
function setListCustomer(){
    var val = $("#shipping_category").find('option:selected').val();
    if(val == '' || val == null){
        $("#shipment_customer").html("");
        return;
    }

    $.ajax({
        url:getCustomerByClassification,
        data:{classification_id:val},
        dataType:'json',
        method:'GET',
        success:function(result){
            var option = '';
            var optionSelect = '<option value=""></option>';
            if(result != null){
                for(var i=0;i<result.length;i++){
                    option += '<option value="'+result[i]['customer_id']+'">'+result[i]['customer_shipment_name']+'</option>';
                    optionSelect += '<option value="'+result[i]['customer_id']+'">'+result[i]['customer_shipment_name']+'</option>';
                }
            }
            $("#shipment_customer").html(option);

            // Set Department
            setListDepartment();
            setListSetProduct();
        }
    });
}

// Set Department
function setListDepartment(){
    var val = $("#shipment_customer").find('option:selected').val();
    if(val == '' || val == null){
        $("#shipment_department").html("");
        return;
    }
    $.ajax({
        url:getDepartmentByCustomer,
        data:{customer_id:val},
        dataType:'json',
        method:'GET',
        success:function(result){
            var option = '<option value=""></option>';
            if(result != null){
                for(var i=0;i<result.length;i++){
                    option += '<option value="'+result[i]['department_id']+'">'+result[i]['department']+'</option>';
                }
            }
            $("#shipment_department").html(option);
        }
    });
}

// Set Product
function setListSetProduct(){
    var val = $("#shipment_customer").find('option:selected').val();
    if(val == '' || val == null){
        $("#shipment_set_product").html("");
        return;
    }
    $.ajax({
        url:getSetProduct,
        data:{customer_id:val},
        dataType:'json',
        method:'GET',
        success:function(result){
            var option = '<option value="0"></option>';
            if(result != null){
                for(var i=0;i<result.length;i++){
                    option += '<option value="'+result[i]['set_id']+'">'+result[i]['set_name']+'</option>';
                }
            }
            $("#shipment_set_product").html(option);
        }
    });
}

// My One Touch
function setMyOneTouch(){
    var val = $("#shipping_category").find('option:selected').val();
    var customer = $("#shipment_customer").find('option:selected').val();
    var department = $("#shipment_department").find('option:selected').val();
    if(val == '' || val == null || customer == '' || customer == null || department == '' || department == null){
        $("#my_one_touch").html("");
        return;
    }
    $.ajax({
        url:getMyOneTouch,
        data:{delivery_classifition_id:val,customer_id:customer,department_id:department},
        dataType:'json',
        method:'GET',
        success:function(result){
            var option = '<option value=""></option>';
            if(result != null){
                for(var i=0;i<result.length;i++){
                    option += '<option value="'+result[i]['mot_id']+'">'+result[i]['mot_name']+'</option>';
                }
            }
            $("#my_one_touch").html(option);
        }
    });
}

// One Touch
var demTouch = 1;
$(document).on("click","#btn_one_touch", function(){
    var set_product = $("#shipment_set_product").find('option:selected').val();
    var my_one_touch = $("#my_one_touch").find('option:selected').val();
    var customer = $("#shipment_customer").find('option:selected').val();
    var department = $("#shipment_department").find('option:selected').val();
    var classification = $("#shipping_category").find('option:selected').val();
    if((set_product == '' || set_product == '0') && my_one_touch == '') {
        $(this).helloWorld(message_not_select_set_error);
        return;
    }
    if(set_product == '' || set_product == '0') {
        set_product = '';
    }
    $.ajax({
        url:getDetailSetAndOntouch,
        data:{classification:classification,set_product:set_product,my_one_touch:my_one_touch,customer:customer,department:department},
        dataType:'json',
        method:'GET',
        success:function(result){
            if(demTouch == 0) {
                $('#add-shipment-table tbody').html('');
            }
            var html ='';
            if(result != null){
                if(result['product'] != null && result['product'].length > 0){
                    result['product'].forEach(function(value_product) {
                        var container1 = (!isNaN(value_product['container1']) && value_product['container1'] != null) ? value_product['container1'] :'0';
                        var container2 = (!isNaN(value_product['container2']) && value_product['container2'] != null) ? value_product['container2'] :'0';
                        var comment = (value_product['comment'] != null) ? value_product['comment'] :'';
                        var quantity = (!isNaN(value_product['product_quantity']) && value_product['product_quantity'] != null) ? value_product['product_quantity'] :'0';
                        var format = (value_product['product_format'] != null) ? value_product['product_format'] :'';
                        var color = (value_product['product_color'] != null) ? value_product['product_color'] :'';
                        var product_name = (value_product['product_name'] != null) ? value_product['product_name'] :'';
                        html += '<tr class="tr-customer-'+demTouch+'">';
                        html += '<td><select class="span2 selectpicker select_customer" data-live-search="true" title="" data-live-search-placeholder="Search">';
                        result['list_customer'].forEach(function(item_customer) {
                            var selectcustomer = '';
                            if(item_customer['customer_id'] == customer) {
                                selectcustomer = 'selected';
                            }
                            html += '<option value="'+item_customer['customer_id']+'" '+selectcustomer+'>'+item_customer['customer_shipment_name']+'</option>';
                        });
                        html += '</select><input type="hidden" class="shipment_product_weight" value="'+value_product['product_weight']+'" /></td>';
                        html += '<td><select class="span2 selectpicker select_department" data-live-search="true" title="" data-live-search-placeholder="Search">';
                        result['list_department'].forEach(function(item_department) {
                            var selectdepartment = '';
                            if(item_department['department_id'] == department) { 
                                selectdepartment = 'selected';
                            }
                            html += '<option value="'+item_department['department_id']+'" '+selectdepartment+'>'+item_department['department']+'</option>';
                        });
                        html += '</select></td>';
                        html += '<td><input class="form-control select_product_code" value="'+value_product['product_id']+'" /></td>';
                        html += '<td><span class="shipment_product_name">'+product_name+'</span></td>';
                        html += '<td><span class="shipment_product_style">'+format+'</span></td>';
                        html += '<td><span class="shipment_product_color">'+color+'</span></td>';
                        html += '<td><input type="hidden" class="shipment_product_value_unit" value="'+value_product['product_value_unit']+'" /><input class="product_quantity_order" value="'+quantity+'"/></td>';
                        html += '<td><span class="product_quantity_change"><input type="hidden" class="shipment_product_quantity_change" value="0" /></span></td>';
                        html += '<td><span class="product_quantity_delivery"></span></td>';
                        html += '<td><input class="product_container_1" value="'+container1+'"/></td>';
                        html += '<td><input class="product_container_2" value="'+container2+'"/></td>';
                        html += '<td><input class="product_comment" value="'+comment+'"/></td>';
                        html += '</tr>';
                    });
                } else {
                    $(this).helloWorld(message_shipment_error_product_setproduct);
                }

                $('#add-shipment-table tbody').append(html);
                $('.selectpicker').selectpicker('refresh');

                // Customer search
                var optionsCustomer = {
                    ajax          : {
                        url     : getCustomerByClassification,
                        type    : 'GET',
                        dataType: 'json',
                        data    : { classification_id:classification,name: '{{{q}}}',start_index:0,number:10}
                    },
                    locale        : {statusInitialized: ''},
                    log           : 0,
                    cache: false,
                    clearOnEmpty: false,
                    preserveSelected: false,
                    emptyRequest:true,
                    preprocessData: function (data) {
                        var i, l = data.length, array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text : data[i].customer_shipment_name,
                                    value: data[i].customer_id,
                                    disabled: false
                                }));
                            }
                        }
                        return array;
                    }
                };

                $('select.select_customer').selectpicker().ajaxSelectPicker(optionsCustomer);

                $('.tr-customer-'+demTouch+' .select_product_code').inputpicker({
                    width:'250px',
                    url: get_product_selectbox,
                    urlParam : {"type_product":2,"customer_shipment":customer},
                    fields:[{"name":"販売商品コード", "text":"売上商品コード"}, {"name":"販売商品名", "text":"売上商品名"}],
                    fieldText:'販売商品コード',
                    fieldValue:'商品ID',
                    filterOpen: true,
                    autoOpen: true,
                    headShow: true,
                    pagination: true,   // false: no
                    pageMode: '',  // '' or 'scroll'
                    pageField: 'p',
                    pageLimitField: 'per_page',
                    limit: PAGE_SIZE_SELECTBOX,
                    pageCurrent: 1,
                });

                demTouch++;
            }
        }
    });

});

// Click Product
$(document).on("change",".select_product_code", function(){
    var product_id = $(this).val();
    if(product_id == '' || product_id == null){
        return;
    }
    var thisClick = $(this);
    $.ajax({
        url:getDetailProduct,
        data:{product_id:product_id},
        dataType:'json',
        method:'GET',
        success:function(result){
            if(result != null && result != '') {
                thisClick.parent().parent().find(".shipment_product_name").html(result['product_name']);
                thisClick.parent().parent().find(".shipment_product_style").html(result['product_format']);
                thisClick.parent().parent().find(".shipment_product_color").html(result['product_color']);
                thisClick.parent().parent().find(".shipment_product_name").attr('title', "1コンテナ上限搭載量 : "+result['product_container']);
                thisClick.parent().parent().find(".shipment_product_value_unit").val(result['product_value_unit']);
            }
        }
    });
});


// Click Product
$(document).on("change","select.select_customer", function(){
    var myThis = $(this);
    // Reset
    myThis.parent().parent().parent().find(".select_product_code").val("");
    myThis.parent().parent().parent().find(".shipment_product_name").html("");
    myThis.parent().parent().parent().find(".shipment_product_style").html("");
    myThis.parent().parent().parent().find(".shipment_product_color").html("");
    myThis.parent().parent().parent().find(".shipment_product_value_unit").val("");
    myThis.parent().parent().parent().find(".shipment_product_name").attr('title', "");

    var customer_id = $(this).find("option:selected").val();
    if(customer_id == '' || customer_id == null){ 
        return;
    }

    $.ajax({
        url:getDepartmentByCustomer,
        data:{customer_id:customer_id},
        dataType:'json',
        method:'GET',
        success:function(result){
            var option = '';
            if(result != null){
                for(var i=0;i<result.length;i++){
                    option += '<option value="'+result[i]['department_id']+'">'+result[i]['department']+'</option>';
                }
            }
            myThis.parent().parent().parent().find("select.select_department").html(option);
            myThis.parent().parent().parent().find("select.select_department").selectpicker('refresh');
        }
    });

    myThis.parent().parent().parent().find("input.select_product_code").inputpicker({
        width:'250px',
        url: get_product_selectbox,
        urlParam : {"type_product":2,"customer_shipment":customer_id},
        fields:[{"name":"販売商品コード", "text":"売上商品コード"}, {"name":"販売商品名", "text":"売上商品名"}],
        fieldText:'販売商品コード',
        fieldValue:'商品ID',
        filterOpen: true,
        autoOpen: true,
        headShow: true,
        pagination: true,   // false: no
        pageMode: '',  // '' or 'scroll'
        pageField: 'p',
        pageLimitField: 'per_page',
        limit: PAGE_SIZE_SELECTBOX,
        pageCurrent: 1,
    });
    
});

// Save Item
$(document).on("click","#save_temp_shipment", function(){
    FormOrderShipment(1);
});

// Save
$(document).on("click","#save_order_shipment", function(){
    FormOrderShipment(2);
});

// confirm
$(document).on("click","#open_popup_confirm", function(){
    var value = $(this).data("value");
    FormOrderShipment(value,true);
    $('#dialog-form').remove();
	$('#cover').remove();
});

// Function Form Submit
function FormOrderShipment(status, confirm_ok){
    if(confirm_ok == "" || confirm_ok == null || confirm_ok === undefined) {
		confirm_ok = false;
    }
    
    // Setting validation
    $("#add_form_shipment").validate(
        {
            invalidHandler: function(form, validator) {
				if (!validator.numberOfInvalids())
					return;

				$('html, body').animate({
					scrollTop: $(validator.errorList[0].element).offset().top - 50
				}, 800);
			}
        }
    );

    $('#shipment_date').rules('add', { required: true });
    $('#delivery_date').rules('add', { required: true });
    $('#shipping_category').rules('add', { required: true });
    $('#shipment_date').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#delivery_date').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    // Table
    $('select.select_customer').each(function() {
        $(this).rules('add', {
            required: true
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });
    $('select.select_department').each(function() {
        $(this).rules('add', {
            required: true
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });
    
    $('.product_quantity_order').each(function() {
        $(this).rules('add', {
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'right'
        }); 
    });
    $('.product_container_1').each(function() {
        $(this).rules('add', {
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });
    $('.product_container_2').each(function() {
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
    var form = $("#add_form_shipment");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Validation sản phẩm
    var statusProduct = true;
    var is_error_mod_value = false;
    var value_error_mod_product_name = "";
    var value_error_mod_product_unit = "";
    $('input.select_product_code').each(function() {
        var valueProduct = $(this).val();
        var valueNameProduct = $(this).parent().parent().find('.shipment_product_name').html();
        if(valueProduct == null || valueProduct == "") {
            $(this).helloWorld("商品は必須です。ご入力ください。");
            statusProduct = false;
            return false;
        }

        // valid value unit
        if(confirm_ok == false) {
            var value_unit = $(this).parent().parent().find('.shipment_product_value_unit').val();
            var value_quantity = $(this).parent().parent().find('.product_quantity_order').val();
            if(value_unit != "" && value_unit != null && value_unit > 0) {
                if(value_quantity != "" && value_quantity != null && value_quantity > 0) {
                    var mod_value = value_quantity % value_unit;
                    if(mod_value != 0) {
                        value_error_mod_product_name += valueNameProduct + ",";
                        value_error_mod_product_unit += value_unit + ",";
                        is_error_mod_value = true;
                    }
                } 
            } 
        } 
    });

    // Show Error
    if(is_error_mod_value == true) {
        value_error_mod_product_unit = value_error_mod_product_unit.substring(0, value_error_mod_product_unit.length - 1);
        value_error_mod_product_name = value_error_mod_product_name.substring(0, value_error_mod_product_name.length - 1);
        var message_error_unit = String.format(message_error_multiples_product, value_error_mod_product_name, value_error_mod_product_unit);
        $(this).helloWorldOpenConfirm(message_error_unit, status);
        statusProduct = false;
        return false;
    }

    if(statusProduct == true) {
        var detail_data = [];
        $("#add-shipment-table > tbody > tr:not(.sum-col)").each(function(index){
            var item ={
                'customer' : $(this).find('td').find('select.select_customer option:selected').val(),
                'customer_name' : $(this).find('td').find('select.select_customer option:selected').text(),
                'department' : $(this).find('td').find('select.select_department option:selected').val(),
                'department_name' : $(this).find('td').find('select.select_department option:selected').text(),
                'product_id' : $(this).find('td').find('input.select_product_code').val(),
                'product_weight' : $(this).find('td').find('.shipment_product_weight').val(),
                'quantity' : $(this).find('td').find('.product_quantity_order').val(),
                'quantity_change' : $(this).find('td').find('.shipment_product_quantity_change').val(),
                'container1' : $(this).find('td').find('.product_container_1').val(),
                'container2' : $(this).find('td').find('.product_container_2').val(),
                'comment' : $(this).find('td').find('.product_comment').val(),
            };
            detail_data.push(item);
        });
        ContainerTruck(detail_data,status);
    }
};


// Container && Track
function ContainerTruck(detail_data, status){
    var ContInTruck = $("#shipping_category").find('option:selected').data('container');
    var WeightInTruck = $("#shipping_category").find('option:selected').data('maxtruck');
    var Truck = $("#shipping_category").find('option:selected').data('truck');

    $.ajax({
        url:getContainerShipment,
        data:{ContInTruck:ContInTruck,WeightInTruck:WeightInTruck,Truck:Truck,detail:detail_data},
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

                    // Creater order
                    if(status != 3 && status != '3') {
                        var data_meta = {
                            'OS_DELIVERY_CLASSIFICATION' : $("#shipping_category").find('option:selected').val(),
                            'OS_DELIVERY_DATE' : $("#delivery_date").val(),
                            'OS_NOTE' : $("#shipment_note").val(),
                            'OS_SHIPMENT_DECISION_DATETIME' : $("#shipment_date").val(),
                            'OS_TOTAL_NUMBER_CONTAINERS' : result['lblTotal'],
                            'OS_GROSS_WEIGHT' : result['lblWeight'],
                            'OS_NUMBER_TRUCKS' : result['lblTruckMain'],
                            'OS_NUMBER_TRAIN' : result['lblTruckAid']
                        };
                        
                        var data = { data_meta:data_meta,data_detail:detail_data, data_status:status };
                        var url = addShipmentPost;
                        var error_message = errorAjax;
                        var titleAjax = '出荷情報を一時保存します。よろしいですか？'
                        if(status == 2 || status == '2') {
                            titleAjax = '発注確定します。よろしいですか？';
                        }
                        
                        $(this).helloWorld(titleAjax, urlShipmentIndex, null, {
                            url: url,
                            data: data,
                            error_message: error_message
                        });
                    }

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

// add row
var getHtmlRow = $('#add-shipment-table tbody tr:eq(0)').html();
var countLoadCombo = 0;
var countLoadClick = 0;
$(document).on("click","#insert-shipment-row", function(){
    if(countLoadClick==countLoadCombo) {
        countLoadClick++;

        $('#add-shipment-table tbody tr').removeClass('del-row');
        // getHtmlRow
        var selected_row = $("#add-shipment-table > tbody > tr.del").length;
		if(selected_row > 0) {
			$("#add-shipment-table > tbody > tr.del").after('<tr class="del-row">'+getHtmlRow+'</tr>');
		} else {
            $('#add-shipment-table tbody').append('<tr class="del-row">'+getHtmlRow+'</tr>');
        }

        // Re name
        $('#add-shipment-table tbody').find('tr').each(function (index, value) {
            $(this).find('select[name$=select_customer]').attr('name', 'select_customer' + index);
            $(this).find('select[name$=select_department]').attr('name', 'select_department' + index);
            $(this).find('input[name$=select_product_code]').attr('name', 'select_product_code' + index);

            $(this).find('input[name$=product_quantity_order]').attr('name', 'product_quantity_order' + index);
            $(this).find('input[name$=product_container_1]').attr('name', 'product_container_1' + index);
            $(this).find('input[name$=product_container_2]').attr('name', 'product_container_2' + index);
        });

        // Get Customer
        var val = $("#shipping_category").find('option:selected').val();
        if(val == '' || val == null){
            return;
        }

        $.ajax({
            url:getCustomerByClassification,
            data:{classification_id:val},
            dataType:'json',
            method:'GET',
            success:function(result){
                var option = '';
                var optionSelect = '<option value=""></option>';
                if(result != null){
                    for(var i=0;i<result.length;i++){
                        option += '<option value="'+result[i]['customer_id']+'">'+result[i]['customer_shipment_name']+'</option>';
                        optionSelect += '<option value="'+result[i]['customer_id']+'">'+result[i]['customer_shipment_name']+'</option>';
                    }
                }
                $(".del-row select.select_customer").html(optionSelect);
                $('.del-row select.select_customer').selectpicker('refresh');
                countLoadCombo++;
            }
        });

        // Customer search
        var classification = $("#shipping_category").find('option:selected').val();
        var optionsCustomer = {
            ajax          : {
                url     : getCustomerByClassification,
                type    : 'GET',
                dataType: 'json',
                data    : { classification_id:classification,name: '{{{q}}}',start_index:0,number:10}
            },
            locale        : {statusInitialized: ''},
            log           : 0,
            cache: false,
            clearOnEmpty: false,
            preserveSelected: false,
            emptyRequest:true,
            preprocessData: function (data) {
                var i, l = data.length, array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text : data[i].customer_shipment_name,
                            value: data[i].customer_id,
                            disabled: false
                        }));
                    }
                }
                return array;
            }
        };

        $('select.select_customer').selectpicker().ajaxSelectPicker(optionsCustomer);
    }
});

// remove row
$(document).on("click","#remove-shipment-row", function(){ 
    var numItems = $('.del-row').length;
    var numContent = $('#add-shipment-table tbody tr').length;
    if(numItems == 0) {
        $(this).helloWorld(message_not_select_row);
        return;
    }
    else{
        if(numContent > 1) {
            $('.del-row').remove();
        }
    }
}); 

// click row
$(document).on("click","#add-shipment-table tbody tr", function(){
    $('#add-shipment-table tbody tr').removeClass('del-row');
    $(this).addClass('del-row');
});

// autoUpdateContainerShipment
$(document).on("click","#autoUpdateContainerShipment", function(){
    FormOrderShipment(3);
});

// chọn customer
$(document).on("change","#shipment_customer", function(){
    // department
    setListDepartment();

    // set product
    setListSetProduct();
});

// chọn department
$(document).on("change","#shipment_department", function(){
    // My one touch
    setMyOneTouch();
});

$(document).on("keyup","#add-shipment-table > tbody > tr input",function(e){
	if (e.which === 13) {
		$('#insert-shipment-row').click();
	}
});
