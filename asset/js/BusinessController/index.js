// Document ready
$(document).ready(function(){

	jQuery('#dateFrom').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#dateTo');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
            $('#select_type_time').val("");
        }
	}).attr('readonly','readonly');;

	jQuery('#dateTo').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#dateFrom');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
            $('#select_type_time').val("");
        }
    }).attr('readonly','readonly');
    
    /*$('#select_product').inputpicker({
        width:'250px',
        url: get_product_selectbox,
        urlParam : {"type_product":3},
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
    });*/
});

$(document).on("click","#btnPreview", function(){
    pdf_management_sales(false);
}); 
$(document).on("click","#btnPrint", function(){ 
    pdf_management_sales(true);
}); 
$(document).on("click","#btnPrintCsv", function(){ 
    pdf_management_sales("",true);
}); 

function pdf_management_sales(print, csv){
    if (!csv) {
        csv = false;
    }
    var value = $("input:radio[name=m-radio]:checked").val();
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    if(value == null) {
        $(this).helloWorld(message_error_not_select_report);
    }
    else {
        if(value == 1) {
            var checkDaily = $("input:radio[name=radio-1]:checked").val();
            if(checkDaily == null) {
                $(this).helloWorld(message_error_not_select_report);
            } else {
                if(checkDaily == 1) {
                    var getUrl = scheduleDailyA.split("?")[0];
                    getUrl = getUrl + '?from=' + dateFrom + '&to=' + dateTo + '&print=' + print + '&csv=' + csv;
                    window.open(getUrl, '_blank');
                } else if(checkDaily == 2) {
                    var getUrl = scheduleDailyB.split("?")[0];
                    getUrl = getUrl + '?from=' + dateFrom + '&to=' + dateTo + '&print=' + print + '&csv=' + csv;
                    window.open(getUrl, '_blank');
                }
            } 
        } else if(value == 2) {
            var checkDaily = $("input:radio[name=radio-2]:checked").val();
            var getTypeTime = $("#select_type_time").find(":selected").val();
            var getCustomer = $("#select_customer").find(":selected").val();
            var getProduct = $("#select_product").val();
            if(checkDaily == null) {
                $(this).helloWorld(message_error_not_select_report);
            } else {
                if((dateFrom == "" || dateTo == "") && getTypeTime == "") {
                    $(this).helloWorld(message_error_not_select_time_exp);
                }
                else {
                    if(checkDaily == 1) {
                        var getUrl = pdfSalesScore.split("?")[0];
                        getUrl = getUrl + '?from=' + dateFrom + '&to=' + dateTo + '&date_report=' + getTypeTime + '&print=' + print + '&csv=' + csv;
                        window.open(getUrl, '_blank');
                    } else if(checkDaily == 2) {
                        var getUrl = pdfSalesCustomer.split("?")[0];
                        getUrl = getUrl + '?from=' + dateFrom + '&to=' + dateTo + '&date_report=' + getTypeTime + '&customer=' + getCustomer + '&print=' + print + '&csv=' + csv;
                        window.open(getUrl, '_blank');
                    } else if(checkDaily == 3) {
                        var getUrl = pdfSalesProduct.split("?")[0];
                        getUrl = getUrl + '?from=' + dateFrom + '&to=' + dateTo + '&date_report=' + getTypeTime + '&product=' + getProduct + '&print=' + print + '&csv=' + csv;
                        window.open(getUrl, '_blank');
                    }
                }
            }
        }
    }
}

$(document).on("change","#dateFrom", function(){
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    $('#select_type_time option').removeAttr('selected');
    if(dateFrom != "" || dateTo != "") {
        $('#select_type_time').prop('disabled', 'disabled');
    } else if(dateFrom == "" && dateTo == "") {
        $("#select_type_time").prop("disabled", false);
    }
});

$(document).on("change","#dateTo", function(){
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    $('#select_type_time option').removeAttr('selected');
    if(dateFrom != "" || dateTo != "") {
        $('#select_type_time').prop('disabled', 'disabled');
    } else if(dateFrom == "" && dateTo == "") {
        $("#select_type_time").prop("disabled", false);
    }
});

// render
$(document).ready(function() {
    $('#select_type_time').prop('disabled', 'disabled');
});

$(document).on("change","input:radio[name=m-radio]", function(){
    var value = $("input:radio[name=m-radio]:checked").val();
    if(value == 1) {
        $('#select_type_time').prop('disabled', 'disabled');
    }else if(value == 2) {
        $('#select_type_time').prop('disabled', false);
    }
});

// Ajax select
$(document).ready(function(){

    // Customer search
    /*var optionsCustomer = {
        ajax          : {
            url     : customerSearchUrl,
            type    : 'GET',
            dataType: 'json',
            data    : { name: '{{{q}}}',start_index:0,number:20}
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
                        text : data[i].name,
                        value: data[i].id,
                        disabled: false
                    }));
                }
            }
            return array;
        }
    };

    var xyz = $('select#select_customer').selectpicker().ajaxSelectPicker(optionsCustomer);
    xyz.trigger('change').data('AjaxBootstrapSelect').list.cache = {};*/
});

// select box
$(document).on("change","#select_type_time", function(){
    var value_time = $(this).val();
    if(value_time != "" && value_time != null) {
        var $dates = $('#dateFrom, #dateTo').datepicker();
        $dates.datepicker('setDate', null);
        $dates.datepicker('option', 'minDate', null);
        $dates.datepicker('option', 'maxDate', null);
    }
});

// 商品別
$(document).on("click","input[name=radio-2]", function(){
    if($(this).is(':checked')) {
        var value = $(this).val();
        if(value == 3) {
            $('#select_product').removeAttr('disabled');
            $('#select_product').inputpicker({
                width:'250px',
                url: get_product_selectbox,
                urlParam : {"type_product":3},
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
            $('#box-product-select').html('<input class="form-control"  disabled="disabled"  name="select-product" id="select_product" style="width: 150px;" ></div>')
        }
        
        if(value == 2){
            $('#select_customer').removeAttr('disabled','disabled');
        } else {
            $('#select_customer').attr('disabled','disabled');
        }
    }
});

$(document).on("click","input[name=m-radio]", function(){
    if($(this).is(':checked')) {
        var value = $(this).val();
        if(value == 1) {
            $('#select_customer').attr('disabled','disabled');
            $('#box-product-select').html('<input class="form-control"  disabled="disabled"  name="select-product" id="select_product" style="width: 150px;" ></div>')
        }
    }
});