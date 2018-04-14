$(document).on("click","#btnPreview", function(){
    pdf_management_inventory(false);
});
$(document).on("click","#btnPrint", function(){
    pdf_management_inventory(true);
});
$(document).on("click","#btnPrintCsv", function(){ 
    pdf_management_inventory("",true);
}); 
function pdf_management_inventory(print, csv){
    if (!csv) {
        csv = false;
    }
    var value = $("input:radio[name=produce]:checked").val();
    if(value == null) {
        $(this).helloWorld(message_error_not_select_report);
    }
    else {
        if(value == 1) {
            var getValueStock = $("#select_place_stock").find(":selected").val();
            var getTypeProduct = $("#select_detergent_buy").find(":selected").val();
            var dateExp = $("#value_date_expiration").val();
            var checkTypeReport = $("#select_type_report").find(":selected").val();
            if(checkTypeReport == null) {
                $(this).helloWorld(message_error_not_select_report);
            } else {
                var getUrl = url_inventory_type1.split("?")[0];
                getUrl = getUrl + '?stock=' + getValueStock + '&type=' + getTypeProduct + '&report=' + checkTypeReport + '&date=' + dateExp + '&print=' +  print + '&csv=' + csv;
                window.open(getUrl, '_blank');
            }
        }
        else if(value == 2){
            var dateExpFrom = $("#delivery_achienvement_from").val();
            var dateExpTo = $("#delivery_achienvement_to").val();
            var dataProduct = $("#delivery_achienvement_product").val();
            if(dateExpFrom == '' || dateExpTo == '') {
                $(this).helloWorld(message_error_not_select_date_report);
            } else {
                var getUrl = url_delivery_achievement_rate.split("?")[0];
                getUrl = getUrl + '?from=' + dateExpFrom + '&to=' + dateExpTo + '&product=' + dataProduct + '&print=' +  print + '&csv=' + csv;
                window.open(getUrl, '_blank');
            }
            
        }
        else if(value == 3){
            var dateExpFrom = $("#initial_inventory_date_from").val();
            var dateExpTo = $("#initial_inventory_date_to").val();
            var dataBaseCode = $("#initial_inventory_base").val();
            var dataTypeProduct = $("#initial_inventory_type_product").val();
            if(dateExpFrom == '' || dateExpTo == '') {
                $(this).helloWorld(message_error_not_select_date_report);
            } else {
                var getUrl = url_pdf_initial_inventory.split("?")[0];
                getUrl = getUrl + '?from=' + dateExpFrom+ '&to=' + dateExpTo + '&type_product=' + dataTypeProduct + '&base_code=' + dataBaseCode + '&print=' +  print + '&csv=' + csv;
                window.open(getUrl, '_blank');
            }
        }
        else if(value==4) {
            var dateExpFrom = $("#exp_from_warehouse_status").val();
            var dateExpTo = $("#exp_to_warehouse_status").val();
            var getValueProduct = $("#product_warehouse_status").val();
            var getTypeProduct = $("#product_type_warehouse_status").val();
            if(dateExpFrom == '' || dateExpTo == '') {
                $(this).helloWorld(message_error_not_select_date_report);
            } else {
                var getUrl = url_warehouse_status.split("?")[0];
                getUrl = getUrl + '?product=' + getValueProduct + '&type=' + getTypeProduct + '&exp_from=' + dateExpFrom + '&exp_to=' + dateExpTo + '&print=' +  print + '&csv=' + csv;
                window.open(getUrl, '_blank');
            }
        }
        else if(value==5) { 
            var dateExpFrom = $("#purchase_ledger_date_from").val();
            var dateExpTo = $("#purchase_ledger_date_to").val();
            var getProductType = $("#purchase_ledger_report_type").find(":selected").val();
            var getReportType = $("#purchase_ledger_form_report").find(":selected").val();
            var getPlaceBuy = $("#purchase_ledger_place_buy").find(":selected").val();
            var getPlaceSale = $("#purchase_ledger_place_sales").find(":selected").val();
            var getImportExport = $("#purchase_ledger_import_export").find(":selected").val();
            if(dateExpFrom == '' || dateExpTo == '') {
                $(this).helloWorld(message_error_not_select_date_report);
            } else {
                if(getImportExport == 2 && getReportType == 1) {
                    var getUrl = url_pdf_purchase_ledger.split("?")[0];
                    getUrl = getUrl + '?date_from=' + dateExpFrom + '&date_to=' + dateExpTo + '&product_type=' + getProductType + 
                    '&place_buy=' + getPlaceBuy + '&place_sale=' + getPlaceSale + '&import_export=' + getImportExport + '&type_report=' + getReportType + '&type_export=1&print=' +  print + '&csv=' + csv;
                    var getUrl1 = url_pdf_purchase_ledger.split("?")[0];
                    getUrl1 = getUrl1 + '?date_from=' + dateExpFrom + '&date_to=' + dateExpTo + '&product_type=' + getProductType + 
                    '&place_buy=' + getPlaceBuy + '&place_sale=' + getPlaceSale + '&import_export=' + getImportExport + '&type_report=' + getReportType + '&type_export=2&print=' +  print + '&csv=' + csv;
                    var getUrl2 = url_pdf_purchase_ledger.split("?")[0];
                    getUrl2 = getUrl2 + '?date_from=' + dateExpFrom + '&date_to=' + dateExpTo + '&product_type=' + getProductType + 
                    '&place_buy=' + getPlaceBuy + '&place_sale=' + getPlaceSale + '&import_export=' + getImportExport + '&type_report=' + getReportType + '&type_export=3&print=' +  print + '&csv=' + csv;
                    window.open(getUrl, '_blank');
                    window.open(getUrl1, '_blank');
                    window.open(getUrl2, '_blank');
                }
                else {
                    var getUrl = url_pdf_purchase_ledger.split("?")[0];
                    getUrl = getUrl + '?date_from=' + dateExpFrom + '&date_to=' + dateExpTo + '&product_type=' + getProductType + 
                    '&place_buy=' + getPlaceBuy + '&place_sale=' + getPlaceSale + '&import_export=' + getImportExport + '&type_report=' + getReportType + '&type_export=&print=' +  print + '&csv=' + csv;
                    window.open(getUrl, '_blank');
                }
            }
        }
        else if(value==6) {
            var startDate = $("#startDate").val();
            if(startDate == '') {
                $(this).helloWorld(message_error_not_select_date_report);
            } else {
                var getUrl = url_detergent_condition.split("?")[0];
                getUrl = getUrl + '?date=' + startDate + '&print=' +  print + '&csv=' + csv;
                window.open(getUrl, '_blank');
            }
        }
        else if(value==7) {
            var dateExpFrom = $("#purchase_amount_date_from").val();
            var dateExpTo = $("#purchase_amount_date_to").val();
            var getProductType = $("#purchase_amount_date_type").find(":selected").val();
            var getReportType = $("#purchase_amount_report").find(":selected").val();
            if(dateExpFrom == '' || dateExpTo == '') {
                $(this).helloWorld(message_error_not_select_date_report);
            } else {
                var getUrl = url_pdf_details_buy.split("?")[0];
                getUrl = getUrl + '?date_from=' + dateExpFrom + '&date_to=' + dateExpTo + '&product_type=' + getProductType + '&report=' + getReportType + '&print=' +  print + '&csv=' + csv;
                window.open(getUrl, '_blank');
            }
        }
    }
}

$(document).on("change","#purchase_ledger_report_type", function(){
    $("#purchase_ledger_form_report").val("1");
    var value_report_type = $(this).find(":selected").val();
    if(value_report_type == 2) {
        $("#purchase_ledger_form_report option[value=2]").hide();
    } else {
        $("#purchase_ledger_form_report option[value=2]").show();
    }
});

$(document).on("change","#purchase_ledger_import_export", function(){
    $("#purchase_ledger_form_report").val("1");
    var value_report_type = $(this).find(":selected").val();
    if(value_report_type == 2) {
        $("#purchase_ledger_form_report option[value=2]").show();
    } else {
        $("#purchase_ledger_form_report option[value=2]").hide();
    }
});

// Ajax select
$(document).ready(function(){
    // product search
    // var optionsProduct = {
    //     ajax          : {
    //         url     : productSearchUrl,
    //         type    : 'GET',
    //         dataType: 'json',
    //         data    : { name: '{{{q}}}',start_index:0,number:20}
    //     },
    //     locale        : {statusInitialized: ''},
    //     log           : 0,
    //     cache: false,
    //     clearOnEmpty: false,
    //     preserveSelected: false,
    //     emptyRequest:true,
    //     preprocessData: function (data) {
    //         var i, l = data.length, array = [];
    //         if (l) {
    //             for (i = 0; i < l; i++) {
    //                 array.push($.extend(true, data[i], {
    //                     text : data[i].name,
    //                     value: data[i].id,
    //                     disabled: false
    //                 }));
    //             }
    //         }
    //         return array;
    //     }
    // };

    // var xyz = $('select#delivery_achienvement_product, select#product_warehouse_status').selectpicker().ajaxSelectPicker(optionsProduct);
    // xyz.trigger('change').data('AjaxBootstrapSelect').list.cache = {};

});

// Select date form, to
$(document).ready(function(){
	jQuery('#delivery_achienvement_from').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#delivery_achienvement_to');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#delivery_achienvement_to').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#delivery_achienvement_from');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');


    jQuery('#purchase_amount_date_from').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#purchase_amount_date_to');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#purchase_amount_date_to').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#purchase_amount_date_from');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');

    jQuery('#purchase_ledger_date_from').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#purchase_ledger_date_to');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#purchase_ledger_date_to').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#purchase_ledger_date_from');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');

    jQuery('#exp_from_warehouse_status').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#exp_to_warehouse_status');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#exp_to_warehouse_status').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#exp_from_warehouse_status');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');

    jQuery('#initial_inventory_date_from').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#initial_inventory_date_to');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#initial_inventory_date_to').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#initial_inventory_date_from');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');

});

$(document).on("click","#btnPreviewinitial_inventory", function(){
    var dateExpFrom = $("#initial_inventory_date_from").val();
    var dateExpTo = $("#initial_inventory_date_to").val();
    var dataBaseCode = $("#initial_inventory_base").val();
    var dataTypeProduct = $("#initial_inventory_type_product").val();
    if(dateExpFrom == '' || dateExpTo == '') {
        $(this).helloWorld(message_error_not_select_date_report);
    } else {
        var getUrl = url_pdf_initial_inventory.split("?")[0];
        getUrl = getUrl + '?from=' + dateExpFrom+ '&to=' + dateExpTo + '&type_product=' + dataTypeProduct + '&base_code=' + dataBaseCode + '&review=true';
        window.open(getUrl, '_blank');
    }
}); 

$(document).on("click","input[name=produce]", function(){
    if($(this).is(':checked')) {
        var value = $(this).val();
        if(value == 2) {
            $('#delivery_achienvement_product').removeAttr('disabled');
            // Shipment
            $('#delivery_achienvement_product').inputpicker({
                width:'250px',
                url: get_product_selectbox,
                urlParam : {"type_product":2},
                fields:[{"name":"販売商品コード", "text":"売上商品コード"}, {"name":"販売商品名", "text":"売上商品名"}, {"name":"色調", "text":"色調"}],
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
        } else {
            $('#box-product-select').html('<input class="form-control"  disabled="disabled"  name="delivery_achienvement_product" id="delivery_achienvement_product" style="    width: 150px;" >')
        }

        if(value == 4) {
            $('#product_warehouse_status').removeAttr('disabled');
            // nhập, xuất
            $('#product_warehouse_status').inputpicker({
                width:'250px',
                url: get_product_selectbox,
                urlParam : {"type_product":1},
                fields:[{"name":"仕入商品コード", "text":"仕入商品コード"}, {"name":"仕入商品名", "text":"仕入商品名"}, {"name":"色調", "text":"色調"}],
                fieldText:'仕入商品コード',
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
        } else {
            $('#box-product-select2').html('<input class="form-control"  disabled="disabled"  name="product_warehouse_status" id="product_warehouse_status" style="    width: 150px;" >')
        }
    }
});