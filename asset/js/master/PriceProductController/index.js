// Ajax select
var called_index = 0; 
$(document).ready(function(){
    var input_search = $('#inputLabel4').val();
    if(type_list == 1 || type_list == "1") {
        FuncPriceSale(input_search);
    } else if(type_list == 2 || type_list == "2") {
        FuncPriceImport(input_search);
    } else if(type_list == 3 || type_list == "3") {
        FuncPriceExport(input_search);
    } else {
        FuncPriceSale("");
    }
}); 

$(document).on("change","input[name=type]",function(){
    var value_type = $(this).val();
    window.location = urlIndex + "?type="+value_type;
});

// customer
$(document).on("change","#sale_customer",function(){
    $('#sale_price_user').val("");
    var val_customer = $(this).val();
    $.ajax({
        url:get_infor_customer,
        data:{customer:val_customer},
        dataType:'json',
        method:'GET',
        success:function(result){
            if(result != null) {

                // BASE
                var option = '<option value=""></option>';
				if(result != null){
					for(var i=0;i<result.length;i++){
						option += '<option data-username="'+result[i]['username']+'" data-gaichyu="'+result[i]['flg_gaichyu']+'" value="'+result[i]['basecode']+'">'+result[i]['basename']+'</option>';
					}
                }
                
                $('#sale_base').each(function() {
                   $(this).html(option); 
                   $(this).val("");
                   $(this).prop('disabled', false);
                });

                //$('.flag-base').show();
                $('#addRowSale').show();
            }
        }
    });
});

// base code
$(document).on("change","#sale_base",function(){
    var val_gaichyu = $(this).find("option:selected").data('gaichyu');
    var username =  $(this).find("option:selected").data('username');
    var varThis = $(this);
    $('#sale_price_user').val("");
    $('#sale_price_user').val(username);
    if(val_gaichyu == 1) {
        varThis.parent().parent().parent().parent().find('.sale_price').val("");
        varThis.parent().parent().parent().parent().find('.sale_price').prop('disabled', false);
        varThis.parent().parent().parent().parent().find('.sale_price_gaichyu').val("");
        varThis.parent().parent().parent().parent().find('.sale_price_gaichyu').prop('disabled', false);

        varThis.parent().parent().parent().parent().find('.flag-to').hide();
        varThis.parent().parent().parent().parent().find('.flag-gaichyn').show();
    } else {
        varThis.parent().parent().parent().parent().find('.sale_price').val("");
        varThis.parent().parent().parent().parent().find('.sale_price').prop('disabled', false);
        varThis.parent().parent().parent().parent().find('.sale_price_gaichyu').val("");
        varThis.parent().parent().parent().parent().find('.sale_price_gaichyu').prop('disabled', true);

        varThis.parent().parent().parent().parent().find('.flag-gaichyn').hide();
        varThis.parent().parent().parent().parent().find('.flag-to').show();
    }


});

// Search
$(document).on("click","#btnSearch", function(){
    var input_search = $('#inputLabel4').val();
    var value_type = $('input[name=type]:checked').val();
    if(value_type == 1) {
        var input_search_base = $('#inputLabelBase').val();
        var input_search_product = $('#inputLabelProduct').val();
        var input_search_customer = $('#inputLabelCustomer').val();
        FuncPriceSale(input_search_base,input_search_product,input_search_customer);
    } else if(value_type == 2) {
        FuncPriceImport(input_search);
    } else if(value_type == 3) {
        FuncPriceExport(input_search);
    }
});

// Function Price for Sale
function FuncPriceSale(input_search_base,input_search_product,input_search_customer){
    $.ajax({
        url:priceProductSale,
        data:{input_search_base:input_search_base,input_search_product:input_search_product,input_search_customer:input_search_customer},
        dataType:'json',
        method:'GET',
        success:function(result){

            var tables = $.fn.dataTable.fnTables(true);

            $(tables).each(function () {
                $(this).dataTable().fnDestroy();
            });
            var html = '';
            for(var i=0; i<result.length; i++){
                var amount = parseFloat(result[i]['price']);
                var amountGaichyu = parseFloat(result[i]['price_gaichyu']);

                html += '<tr>';
                html += '<td>'+result[i]['id']+'</td>';
                html += '<td>'+result[i]['product_code']+'</td>';
                html += '<td>'+result[i]['product_name']+'</td>';
                html += '<td>'+result[i]['basecode_name']+'</td>';
                html += '<td>'+result[i]['customer_name']+'</td>';
                html += '<td>'+formatMoney(amount.toFixed(2))+'</td>';
                if(result[i]['gaichyu_flag'] == 1 || result[i]['gaichyu_flag'] == "1") {
                    if(result[i]['price_gaichyu'] != "" && result[i]['price_gaichyu'] != null) {
                        html += '<td>'+formatMoney(amountGaichyu.toFixed(2))+'</td>';
                    } else {
                        html += '<td></td>';
                    }
                } else {
                    html += '<td></td>';
                }
                html += '<td><a data-type="1" data-username="'+result[i]['username']+'" data-gaichyu="'+result[i]['gaichyu_flag']+'" data-pricegaichyu="'+result[i]['price_gaichyu']+'" data-price="'+result[i]['price']+'" data-customer="'+result[i]['customer_name']+'" data-base="'+result[i]['basecode_name']+'" data-productcode="'+result[i]['product_code']+'" data-product="'+result[i]['product_name']+'" data-id="'+result[i]['id']+'" class="btnEditPrice"><img src="'+urlImage+'edit.png"/></a>  <a data-type="1" data-id="'+result[i]['id']+'" class="btnDeletePrice"><img src="'+urlImage+'del.png"/></a></td>';
                html += '</tr>';
            }

            var isDatatable = true;
            if(html == ''){
                isDatatable = false;
                html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            }
            
            $("#price-product-sale tbody").html(html);

            if(isDatatable == true) {
                $("#price-product-sale table").DataTable( {
                    "scrollY":        "360px",
                    "scrollCollapse": true,
                    "paging":         false,
                    responsive: true,
                    searching: false, paging: false,
                    "ordering": false,
                    "info":     false
                });
                called_index = 0;
                renewScrollSale(1);
            }
        },
        error:function(result) {
            var html = '';
            html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            $("#price-product-sale tbody").html(html);
        }
    });
} 

// Function price for import
function FuncPriceImport(input_search) {
    $.ajax({
        url:priceProductImport,
        data:{input_search:input_search},
        dataType:'json',
        method:'GET',
        success:function(result){
            var tables = $.fn.dataTable.fnTables(true);

            $(tables).each(function () {
                $(this).dataTable().fnDestroy();
            });
            var html = '';
            for(var i=0; i<result.length; i++){
                var amount = parseFloat(result[i]['price']);
                html += '<tr>';
                html += '<td>'+result[i]['id']+'</td>';
                html += '<td>'+result[i]['place_buy_name']+'</td>';
                html += '<td>'+result[i]['product_code']+'</td>';
                html += '<td>'+result[i]['product_name']+'</td>';
                html += '<td>'+formatMoney(amount.toFixed(2))+'</td>';
                if(result[i]['note'] != null && result[i]['note'] != "") {
                    html += '<td>'+result[i]['note']+'</td>';
                } else {
                    html += '<td></td>';
                }
                html += '<td><a data-type="2" data-note="'+result[i]['note']+'" data-price="'+result[i]['price']+'" data-place="'+result[i]['place_buy_name']+'" data-product="'+result[i]['product_name']+'" data-id="'+result[i]['id']+'" class="btnEditPrice"><img src="'+urlImage+'edit.png"/></a>  <a data-type="2" data-id="'+result[i]['id']+'" class="btnDeletePrice"><img src="'+urlImage+'del.png"/></a></td>';
                html += '</tr>';
            }

            var isDatatable = true;
            if(html == ''){
                isDatatable = false;
                html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            }
            
            $("#price-product-import tbody").html(html);

            if(isDatatable == true) {
                $("#price-product-import table").DataTable( {
                    "scrollY":        "360px",
                    "scrollCollapse": true,
                    "paging":         false,
                    responsive: true,
                    searching: false, paging: false,
                    "ordering": false,
                    "info":     false
                });
                
                renewScrollSale(2);
            }
        },
        error:function(result) {
            var html = '';
            html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            $("#price-product-import tbody").html(html);
        }
    });
}

// Function price for export
function FuncPriceExport(input_search) {
    $.ajax({
        url:priceProductExport,
        data:{input_search:input_search},
        dataType:'json',
        method:'GET',
        success:function(result){
            var tables = $.fn.dataTable.fnTables(true);

            $(tables).each(function () {
                $(this).dataTable().fnDestroy();
            });
            var html = '';
            for(var i=0; i<result.length; i++){
                var amount = parseFloat(result[i]['price']);
                html += '<tr>';
                html += '<td>'+result[i]['id']+'</td>';
                html += '<td>'+result[i]['place_sale_name']+'</td>';
                html += '<td>'+result[i]['product_code']+'</td>';
                html += '<td>'+result[i]['product_name']+'</td>';
                html += '<td>'+formatMoney(amount.toFixed(2))+'</td>';
                if(result[i]['note'] != null && result[i]['note'] != "") {
                    html += '<td>'+result[i]['note']+'</td>';
                } else {
                    html += '<td></td>';
                }
                html += '<td><a data-type="3" data-note="'+result[i]['note']+'" data-price="'+result[i]['price']+'" data-place="'+result[i]['place_sale_name']+'" data-product="'+result[i]['product_name']+'" data-id="'+result[i]['id']+'" class="btnEditPrice"><img src="'+urlImage+'edit.png"/></a>  <a data-type="3" data-id="'+result[i]['id']+'" class="btnDeletePrice"><img src="'+urlImage+'del.png"/></a></td>';
                html += '</tr>';
            }

            var isDatatable = true;
            if(html == ''){
                isDatatable = false;
                html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            }
            
            $("#price-product-export tbody").html(html);

            if(isDatatable == true) {
                $("#price-product-export table").DataTable( {
                    "scrollY":        "360px",
                    "scrollCollapse": true,
                    "paging":         false,
                    responsive: true,
                    searching: false, paging: false,
                    "ordering": false,
                    "info":     false
                });
                renewScrollSale(3);
            }
        },
        error:function(result) {
            var html = '';
            html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            $("#price-product-export tbody").html(html);
        }
    });
}

// Scroll sale
function renewScrollSale(type){
    if(type == 1) {
        $('#price-product-sale .dataTables_scrollBody').on('scroll', function() {
            var start_index = $('#price-product-sale tbody tr').length;

            var input_search_base = $('#inputLabelBase').val();
            var input_search_product = $('#inputLabelProduct').val();
            var input_search_customer = $('#inputLabelCustomer').val();
    
            if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
                if(called_index == start_index)
                    return;
                called_index = start_index;
                $.ajax({
                    url:priceProductSale,
                    data:{input_search_base:input_search_base,input_search_product:input_search_product,input_search_customer:input_search_customer,start_index:start_index},
                    dataType:'json',
                    method:'GET',
                    success:function(result){
    
                    var html = '';
                    for(var i=0; i<result.length; i++){
                        var amount = parseFloat(result[i]['price']);
                        var amountGaichyu = parseFloat(result[i]['price_gaichyu']);
                        html += '<tr>';
                        html += '<td>'+result[i]['id']+'</td>';
                        html += '<td>'+result[i]['product_code']+'</td>';
                        html += '<td>'+result[i]['product_name']+'</td>';
                        html += '<td>'+result[i]['basecode_name']+'</td>';
                        html += '<td>'+result[i]['customer_name']+'</td>';
                        html += '<td>'+formatMoney(amount.toFixed(2))+'</td>';
                        if(result[i]['gaichyu_flag'] == 1 || result[i]['gaichyu_flag'] == "1") {
                            if(result[i]['price_gaichyu'] != "" && result[i]['price_gaichyu'] != null) {
                                html += '<td>'+formatMoney(amountGaichyu.toFixed(2))+'</td>';
                            } else {
                                html += '<td></td>';
                            }
                        } else {
                            html += '<td></td>';
                        }
                        html += '<td><a data-type="1" data-username="'+result[i]['username']+'" data-gaichyu="'+result[i]['gaichyu_flag']+'" data-pricegaichyu="'+result[i]['price_gaichyu']+'" data-price="'+result[i]['price']+'" data-customer="'+result[i]['customer_name']+'" data-base="'+result[i]['basecode_name']+'" data-productcode="'+result[i]['product_code']+'" data-product="'+result[i]['product_name']+'" data-id="'+result[i]['id']+'" class="btnEditPrice"><img src="'+urlImage+'edit.png"/></a>  <a data-type="1" data-id="'+result[i]['id']+'" class="btnDeletePrice"><img src="'+urlImage+'del.png"/></a></td>';
                        html += '</tr>';
                    }
                        
                    $("#price-product-sale tbody").append(html);
                    // Adjust
                    var table = $('#price-product-sale table').DataTable();
                    table.columns.adjust();
                    }
                });
            }
        });
    } else if(type == 2) {
        $('#price-product-import .dataTables_scrollBody').on('scroll', function() {
            var start_index = $('#price-product-import tbody tr').length;
    
            var input_search = $('#inputLabel4').val();
    
            if($(this)[0].scrollHeight - $(this).scrollTop() === $(this).outerHeight()) {
                $.ajax({
                    url:priceProductImport,
                    data:{input_search:input_search,start_index:start_index},
                    dataType:'json',
                    method:'GET',
                    success:function(result){
    
                        var html = '';
                        for(var i=0; i<result.length; i++){
                            var amount = parseFloat(result[i]['price']);
                            html += '<tr>';
                            html += '<td>'+result[i]['id']+'</td>';
                            html += '<td>'+result[i]['place_buy_name']+'</td>';
                            html += '<td>'+result[i]['product_code']+'</td>';
                            html += '<td>'+result[i]['product_name']+'</td>';
                            html += '<td>'+formatMoney(amount.toFixed(2))+'</td>';
                            if(result[i]['note'] != null && result[i]['note'] != "") {
                                html += '<td>'+result[i]['note']+'</td>';
                            } else {
                                html += '<td></td>';
                            }
                            html += '<td><a data-type="2" data-note="'+result[i]['note']+'" data-price="'+result[i]['price']+'" data-place="'+result[i]['place_buy_name']+'" data-product="'+result[i]['product_name']+'" data-id="'+result[i]['id']+'" class="btnEditPrice"><img src="'+urlImage+'edit.png"/></a>  <a data-type="2" data-id="'+result[i]['id']+'" class="btnDeletePrice"><img src="'+urlImage+'del.png"/></a></td>';
                            html += '</tr>';
                        }
                        
                    $("#price-product-import tbody").append(html);
    
                    }
                });
            }
        });
    } else if(type == 3) {
        $('#price-product-export .dataTables_scrollBody').on('scroll', function() {
            var start_index = $('#price-product-export tbody tr').length;
    
            var input_search = $('#inputLabel4').val();
    
            if($(this)[0].scrollHeight - $(this).scrollTop() === $(this).outerHeight()) {
                $.ajax({
                    url:priceProductExport,
                    data:{input_search:input_search,start_index:start_index},
                    dataType:'json',
                    method:'GET',
                    success:function(result){
    
                        var html = '';
                        for(var i=0; i<result.length; i++){
                            var amount = parseFloat(result[i]['price']);
                            html += '<tr>';
                            html += '<td>'+result[i]['id']+'</td>';
                            html += '<td>'+result[i]['place_sale_name']+'</td>';
                            html += '<td>'+result[i]['product_code']+'</td>';
                            html += '<td>'+result[i]['product_name']+'</td>';
                            html += '<td>'+formatMoney(amount.toFixed(2))+'</td>';
                            if(result[i]['note'] != null && result[i]['note'] != "") {
                                html += '<td>'+result[i]['note']+'</td>';
                            } else {
                                html += '<td></td>';
                            }
                            html += '<td><a data-type="3" data-note="'+result[i]['note']+'" data-price="'+result[i]['price']+'" data-place="'+result[i]['place_sale_name']+'" data-product="'+result[i]['product_name']+'" data-id="'+result[i]['id']+'" class="btnEditPrice"><img src="'+urlImage+'edit.png"/></a>  <a data-type="3" data-id="'+result[i]['id']+'" class="btnDeletePrice"><img src="'+urlImage+'del.png"/></a></td>';
                            html += '</tr>';
                        }
                        
                    $("#price-product-export tbody").append(html);
    
                    }
                });
            }
        });
    }
    
}

// Click to delete
$(document).on("click",".btnDeletePrice",function(){
    var value_id = $(this).data("id");
    var value_type = $(this).data("type");
    var msg = String.format(message_confirm_delete_field, $('table thead tr th:first').html()+" : "+ value_id);
    $(this).parent().parent().attr("data-delete","1");
	$(this).parent().parent().siblings().attr("data-delete","0"); 
    $(this).helloWorld(msg, null, null, {
        url: deletePostPriceProductSale,
        data:{type:value_type,price_id:value_id},
        error_message: errorAjax,
        success_callback_function:"remove_record"
    }); 
});
window.remove_record = function remove_record(){
    $("table tbody").find("tr[data-delete=1]").remove();
}

// Click to delete
$(document).on("click","#btnInsert",function(){
    $("form .tooltip").remove();
    $("form")[0].reset();

    var getUrl = addPriceProductSale.split("?")[0];
    var value_type = $('input[name=type]:checked').val();

    if(value_type == 1) {
        $('.label-base').show();
        $('.label-base-to').hide();
        $('.label-base-gaichyu').hide();

        $('.flag-gaichyn,.flag-to').hide();
        $('#sale_product').val("");
        $('#sale_product').prop('disabled', false);
        $('#sale_product').show();
        $('#sale_product').parent().find(".inputpicker-overflow-hidden").show();
        $('#sale_product').parent().find('span').html("");
        //$('#sale_product').inputpicker('destroy');
        $('#sale_base').val("");
        $('#sale_base').prop('disabled', true);
        $('#sale_base').show();
        $('.flag-base').hide();
        $('#sale_base').parent().find('span').html("");

        $('#sale_customer').val("");
        $('#sale_customer').prop('disabled', false);
        $('#sale_customer').show();
        $('#sale_customer').parent().find(".inputpicker-overflow-hidden").show();
        $('#sale_customer').parent().find('span').html("");
        //$('#sale_customer').inputpicker('destroy');
        $('#sale_price').val("");
        $('#sale_price').prop('disabled', true);
        $('#sale_price_gaichyu').val("");
        $('#sale_price_gaichyu').prop('disabled', true);
        $('#sale_base_gaichyn').val("");
        $('#sale_base_gaichyn').prop('disabled', true);
        $('#sale_base_gaichyn').show();
        $('#sale_base_gaichyn').parent().find('span').html("");

        $('#myModalSale .modal-title-edit').hide();
        $('#myModalSale .print-edit').hide();
        $('#myModalSale .modal-title-add').show();
        $('#myModalSale .print-add').show();

        $('#sale_customer').inputpicker({
            width:'300px',
            url: get_customer_selectbox,
            fields:[{"name":CUS_ID, "text":"得意先ID"}, {"name":CUS_CUSTOMER_NAME, "text":"得意先名"}],
            fieldText:CUS_CUSTOMER_NAME,
            fieldValue:CUS_ID,
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
        $('#sale_product').inputpicker({
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

        $('#setBoxRowSale').html("");
        $('.sale_product_add').val("");
        $('#sale_base').val("");
        $('.product_sale_name').val("");
        $('.sale_price').val("");
        $('.sale_price_gaichyu').val("");
        $('.sale_price_user').val("");
        $('#addRowSale').hide();       
        $('#myModalSale').modal("show");
    } else if(value_type == 2) {
        $('#import_product').val("");
        $('#import_product').prop('disabled', false);
        $('#import_product').show();
        $('#import_product').parent().find('span').html("");
        $('#import_place_buy').val("");
        $('#import_place_buy').prop('disabled', false);
        $('#import_place_buy').show();
        $('#import_place_buy').parent().find('span').html("");
        $('#import_price').val("");
        $('#import_note').val("");
        $('#myModalImport .modal-title-edit').hide();
        $('#myModalImport .print-edit').hide();
        $('#myModalImport .modal-title-add').show();
        $('#myModalImport .print-add').show();

        $('#setBoxRowImport').html("");
        $('input.import_product').val("");
        $('input.import_price').val("");
        $('input.import_note').val("");
        $('#myModalImport').modal("show");
    } else if(value_type == 3) {
        $('#export_product').val("");
        $('#export_product').prop('disabled', false);
        $('#export_product').show();
        $('#export_product').parent().find('span').html("");
        $('#export_place_sale').val("");
        $('#export_place_sale').prop('disabled', false);
        $('#export_place_sale').show();
        $('#export_place_sale').parent().find('span').html("");
        $('#export_price').val("");
        $('#export_note').val("");
        $('#myModalExport .modal-title-edit').hide();
        $('#myModalExport .print-edit').hide();
        $('#myModalExport .modal-title-add').show();
        $('#myModalExport .print-add').show();

        $('#setBoxRow').html("");
        $('input.export_product').val("");
        $('input.export_price').val("");
        $('input.export_note').val("");
        $('#myModalExport').modal("show");
    }
});

// Click to edit
$(document).on("click",".btnEditPrice",function(){
    $("form .tooltip").remove();
    $("form")[0].reset();
    
    var value_id = $(this).data("id");
    var value_type = $(this).data("type");
    if(value_type == 1) {
        var product_code_sell = $(this).data("productcode");
        var product_code = $(this).data("product");
        var base_code = $(this).data("base");
        var customer_code = $(this).data("customer");
        var product_price = $(this).data("price");
        var product_price_gaichyu = $(this).data("pricegaichyu");
        var val_gaichyu = $(this).data("gaichyu");
        var username = $(this).data("username");

        $('.flag-base').show();
        if(val_gaichyu == 1) {
            $('.label-base').hide();
            $('.label-base-to').hide();
            $('.label-base-gaichyu').show();

            // gaichyu
            $('#sale_base_edit').val(base_code);
            $('#sale_base_edit').prop('disabled', true);
            $('#sale_base_edit').hide();
            $('#sale_base_edit').parent().find('span').html('<label>'+base_code+'</label>');

            // price
            $('#sale_price_edit').val(product_price);
            $('#sale_price_edit').prop('disabled', false);
            $('#sale_price_gaichyu_edit').val(product_price_gaichyu);
            $('#sale_price_gaichyu_edit').prop('disabled', false);

            $('.flag-to').hide();
            $('.flag-gaichyn').show();

        } else {
            $('.label-base').hide();
            $('.label-base-to').show();
            $('.label-base-gaichyu').hide();

            // Base
            $('#sale_base_edit').val(base_code);
            $('#sale_base_edit').prop('disabled', true);
            $('#sale_base_edit').hide(); 
            $('#sale_base_edit').parent().find('span').html('<label>'+base_code+'</label>');

            // price
            $('#sale_price_edit').val(product_price);
            $('#sale_price_edit').prop('disabled', false);
            $('#sale_price_gaichyu_edit').val("0");
            $('#sale_price_gaichyu_edit').prop('disabled', true);

            $('.flag-gaichyn').hide();
            $('.flag-to').show();

        } 

        $('#sale_price_user_edit').html(username);
        $('#sale_id_price_edit').val(value_id);
        $('#sale_product_edit').val(product_code);
        $('#product_sale_code').val(product_code_sell);
        $('#sale_product_edit').prop('disabled', false);
        //$('#sale_product_edit').hide();
        //$('#sale_product_edit').parent().find(".inputpicker-overflow-hidden").hide();
        //$('#sale_product_edit').parent().find('span').html('<label>'+product_code+'</label>');
        
        $('#sale_customer_edit').val(customer_code);
        $('#sale_customer_edit').prop('disabled', true);
        $('#sale_customer_edit').hide();
        $('#sale_customer_edit').parent().find(".inputpicker-overflow-hidden").hide();
        $('#sale_customer_edit').parent().find('span').html('<label>'+customer_code+'</label>');


        $('#myModalSaleEdit .modal-title-add').hide();
        $('#myModalSaleEdit .print-add').hide();
        $('#myModalSaleEdit .modal-title-edit').show();
        $('#myModalSaleEdit .print-edit').show();
        $('#myModalSaleEdit').modal("show");
    } else if(value_type == 2) {
        var product_code = $(this).data("product");
        var place_buy = $(this).data("place");
        var note = $(this).data("note");
        var product_price = $(this).data("price");
        $('#import_id_price_edit').val(value_id);
        $('#import_product_edit').val(product_code);
        $('#import_product_edit').prop('disabled', true);
        $('#import_product_edit').hide();
        $('#import_product_edit').parent().find('span').html('<input class="form-control " value="'+product_code+'" disabled >');
        $('#import_place_buy_edit').val(place_buy);
        $('#import_place_buy_edit').prop('disabled', true);
        $('#import_place_buy_edit').hide();
        $('#import_place_buy_edit').parent().find('span').html('<input class="form-control " value="'+place_buy+'" disabled >');
        $('#import_price_edit').val(product_price);
        $('#import_note_edit').val(note);

        $('#myModalImportEdit .modal-title-add').hide();
        $('#myModalImportEdit .print-add').hide();
        $('#myModalImportEdit .modal-title-edit').show();
        $('#myModalImportEdit .print-edit').show();

        $('#myModalImportEdit').modal("show");
    } else if(value_type == 3) {
        var product_code = $(this).data("product");
        var place_sale = $(this).data("place");
        var note = $(this).data("note");
        var product_price = $(this).data("price");
        $('#export_id_price_edit').val(value_id);
        $('#export_product').val(product_code);
        $('#export_product').prop('disabled', true);
        $('#export_product').hide();
        $('#export_product').parent().find('span').html('<input class="form-control " value="'+product_code+'" disabled >');
        $('#export_place_sale_edit').val(place_sale);
        $('#export_place_sale_edit').prop('disabled', true);
        $('#export_place_sale_edit').hide();
        $('#export_place_sale_edit').parent().find('span').html('<input class="form-control " value="'+place_sale+'" disabled >');
        $('#export_price').val(product_price);
        $('#export_note').val(note);
        $('#myModalExportEdit .modal-title-add').hide();
        $('#myModalExportEdit .print-add').hide();
        $('#myModalExportEdit .modal-title-edit').show();
        $('#myModalExportEdit .print-edit').show();
        $('#myModalExportEdit').modal("show");
    }

});

// click to add for sale
$(document).on("click","#btnAddPriceSale", function(){

    // Replace name
    replaceNamePriceSale();

    var list_product = [];
    var list_product_select = [];
    $('input.sale_product_add[name*=sale_product_add]').each(function(i) {
        list_product.push($(this).val());
        if($(this).val() != "" && $(this).val() != null) {
            list_product_select.push($(this).val());
        }
    });

    // Validation
    var numItems = $('.btnDeleteBoxRowSale').length;
    if($("#sale_customer").val() == "" || $("#sale_customer").val() == null) {
        var message_error_requeird = String.format(message_error_requeird_value, "得意先");
        $(this).helloWorld(message_error_requeird);
        return false;
    }
    if(list_product_select.length != numItems) {
        var message_error_requeird2 = String.format(message_error_requeird_value, "商品");
        $(this).helloWorld(message_error_requeird2);
        return false;
    }

    // Setting validation
    $("#form_add_price_sale").validate();

    //$('#sale_customer').rules('add', { required: true });

    $('input.sale_product_add[name*=sale_product_add]').each(function() {
        $(this).rules('add', {
            required: true
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });

    $("#sale_base").rules('add', {
        required: true
    });
    $("#sale_base").tooltip({
        trigger: 'manual',
        placement:'bottom'
    }); 

    $('input.sale_price').each(function() {
        $(this).rules('add', {
            required: true,
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });

    $('input.product_sale_name').each(function() {
        $(this).rules('add', {
            required: true
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });

    $('input.sale_price_gaichyu').each(function() {
        $(this).rules('add', {
            required: true,
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });

    /*$('#sale_customer').tooltip({
        trigger: 'manual',
        placement:'top'
    });*/

    //Show loading display here
    var form = $("#form_add_price_sale");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var list_product = [];
    var list_product_name = [];
    var list_price = [];
    var list_price_gaichyu = [];
    $('input.sale_product_add[name*=sale_product_add]').each(function(i) {
        list_product.push($(this).val());
    });
    $('input.sale_price').each(function(i) {
        list_price.push($(this).val());
    });
    $('input.product_sale_name').each(function(i) {
        list_product_name.push($(this).val());
    });
    $('input.sale_price_gaichyu').each(function(i) {
        list_price_gaichyu.push($(this).val());
    });
    var product = list_product;
    var product_name = list_product_name;
    var basecode = $("#sale_base option:selected").val();
    var customer = $("#sale_customer").val();
    var price = list_price;
    var price_gaichyu = list_price_gaichyu;

    // Ajax Add-Popup
    $(this).helloWorld(message_confirm_save_field ,urlIndex + "?type="+type_list,null,
        {
            url:addPostPriceProductSale,
            data:{type:1,product:product,product_name:product_name,basecode:basecode,customer:customer,price:price,price_gaichyu:price_gaichyu,have:false},
            error_message:message_error_ajax,
            success_callback_function:"add_record_sale", 
            is_master: true
        }
    );

});

$(document).ready(function(){
	window.add_record_sale = function add_record_sale(data,result){
        var input_search = $('#inputLabel4').val();
        FuncPriceSale(input_search);
        $('#myModalSale').modal('toggle');
    }
    window.edit_record_sale = function edit_record_sale(data,result){
        var input_search = $('#inputLabel4').val();
        FuncPriceSale(input_search);
        $('#myModalSaleEdit').modal('toggle');
	}
});

// click to add for import
$(document).on("click","#btnAddPriceImport", function(){

    // Replace name
    replaceNamePriceImport();

    // Setting validation
    $("#form_add_price_import").validate();

    $('#import_place_buy').rules('add', { required: true });

    $('input.import_price').each(function() {
        $(this).rules('add', {
            required: true,
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });

    /*$('input.import_product[name*=import_product]').each(function() {
        $(this).rules('add', {
            required: true
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });*/

    $('#import_place_buy').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#form_add_price_import");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var list_product = [];
    var list_price = [];
    var list_note = [];
    var list_product_select = [];
    $('input.import_product[name*=import_product]').each(function(i) {
        list_product.push($(this).val());
        if($(this).val() != "" && $(this).val() != null) {
            list_product_select.push($(this).val());
        }
    });
    $('input.import_price').each(function(i) {
        list_price.push($(this).val());
    });
    $('input.import_note').each(function(i) {
        list_note.push($(this).val());
    });

    // Validation
    var numItems = $('.btnDeleteBoxRowImport').length;
    if(list_product_select.length != numItems) {
        var message_error_requeird2 = String.format(message_error_requeird_value, "商品");
        $(this).helloWorld(message_error_requeird2);
        return false;
    }

    var product = list_product;
    var place = $("#import_place_buy option:selected").val();
    var import_note =list_note;
    var price = list_price;

    // Ajax Add-Popup
    $(this).helloWorld(message_confirm_save_field ,urlIndex + "?type="+type_list,null,
        {
            url:addPostPriceProductSale,
            data:{type:2,product:product,place:place,note:import_note,price:price,have:false},
            error_message:message_error_ajax,
            success_callback_function:"add_record_price_import", 
            is_master: true
        }
    );
});

$(document).ready(function(){
	window.add_record_price_import = function add_record_price_import(data,result){
        var input_search = $('#inputLabel4').val();
        FuncPriceImport(input_search);
        $('#myModalImport').modal('toggle');
    }
    window.edit_record_price_import = function edit_record_price_import(data,result){
        var input_search = $('#inputLabel4').val();
        FuncPriceImport(input_search);
        $('#myModalImportEdit').modal('toggle');
	}
});

// click to add for export
$(document).on("click","#btnAddPriceExport", function(){

    // Replace name
    replaceNamePriceExport();

    // Setting validation
    $("#form_add_price_export").validate();

    $('#export_place_sale').rules('add', { required: true });

    $('input.export_price').each(function() {
        $(this).rules('add', {
            required: true,
            number: true,
            min: 0
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });

    /*$('input.export_product[name*=export_product]').each(function() {
        $(this).rules('add', {
            required: true
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });
*/
    $('#export_place_sale').tooltip({
        trigger: 'manual',
        placement:'top'
    });

    //Show loading display here
    var form = $("#form_add_price_export");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var list_product = [];
    var list_price = [];
    var list_note = [];
    var list_product_select = [];
    $('input.export_product[name*=export_product]').each(function(i) {
        list_product.push($(this).val());
        if($(this).val() != "" && $(this).val() != null) {
            list_product_select.push($(this).val());
        }
    });
    $('input.export_price').each(function(i) {
        list_price.push($(this).val());
    });
    $('input.export_note').each(function(i) {
        list_note.push($(this).val());
    });
    var product = list_product;
    var place = $("#export_place_sale option:selected").val();
    var export_note =list_note;
    var price = list_price;

    // Validation
    var numItems = $('.btnDeleteBoxRowExport').length;
    if(list_product_select.length != numItems) {
        var message_error_requeird2 = String.format(message_error_requeird_value, "商品");
        $(this).helloWorld(message_error_requeird2);
        return false;
    }

    // Ajax Add-Popup
    $(this).helloWorld(message_confirm_save_field ,urlIndex + "?type="+type_list,null,
        {
            url:addPostPriceProductSale,
            data:{type:3,product:product,place:place,note:export_note,price:price,have:false},
            error_message:message_error_ajax,
            success_callback_function:"add_record_price_export", 
            is_master: true
        }
    );

});

$(document).ready(function(){
	window.add_record_price_export = function add_record_price_export(data,result){
        var input_search = $('#inputLabel4').val();
        FuncPriceExport(input_search);
        $('#myModalExport').modal('toggle');
    }
    window.edit_record_price_export = function edit_record_price_export(data,result){
        var input_search = $('#inputLabel4').val();
        FuncPriceExport(input_search);
        $('#myModalExportEdit').modal('toggle');
	}
});

// click to edit for sale
$(document).on("click","#btnEditPriceSale", function(){

    // Setting validation
    $("#form_edit_price_sale").validate();

    $('#sale_price_edit').rules('add', { 
        required: true,
        number: true,
        min: 0 
    });
    $('#sale_price_gaichyu_edit').rules('add', { 
        required: true,
        number: true,
        min: 0 
    });
    $('#sale_product_edit').rules('add', { 
        required: true
    });

    $('#sale_product_edit').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#sale_price_edit').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#sale_price_gaichyu_edit').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    
    //Show loading display here
    var form = $("#form_edit_price_sale");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var price = $("#sale_price_edit").val();
    var price_gaichyn = $("#sale_price_gaichyu_edit").val();
    var price_id = $("#sale_id_price_edit").val();
    var product_name = $("#sale_product_edit").val();

    // Ajax Edit-Popup
    $(this).helloWorld(message_confirm_save_field ,urlIndex + "?type="+type_list,null,
        {
            url:editPostPriceProductSale,
            data:{type:1,price_gaichyn:price_gaichyn,price:price,price_id:price_id,product_name:product_name},
            error_message:message_error_ajax,
            success_callback_function:"edit_record_sale", 
            is_master: true
        }
    );
});

// click to edit for sale
$(document).on("click","#btnEditPriceImport", function(){

    // Setting validation
    $("#form_edit_price_import").validate();

    $('#import_price_edit').rules('add', { 
        required: true,
        number: true,
        min: 0 
    });

    $('#import_product_edit').rules('add', { required: true });
    $('#import_place_buy_edit').rules('add', { required: true });

    $('#import_price_edit').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#import_product_edit').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#import_place_buy_edit').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#form_edit_price_import");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var import_note =$("#import_note_edit").val();
    var price = $("#import_price_edit").val();
    var price_id = $("#import_id_price_edit").val();

    // Ajax Edit-Popup
    $(this).helloWorld(message_confirm_save_field ,urlIndex + "?type="+type_list,null,
        {
            url:editPostPriceProductSale,
            data:{type:2,note:import_note,price:price,price_id:price_id},
            error_message:message_error_ajax,
            success_callback_function:"edit_record_price_import", 
            is_master: true
        }
    );
});

// click to edit for sale
$(document).on("click","#btnEditPriceExport", function(){

    // Setting validation
    $("#form_edit_price_export").validate();

    $('#export_price').rules('add', { 
        required: true,
        number: true,
        min: 0 
    });

    $('#export_product').rules('add', { required: true });
    $('#export_place_sale_edit').rules('add', { required: true });

    $('#export_price').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#export_product').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#export_place_sale_edit').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#form_edit_price_export");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var product = $("#export_product option:selected").val();
    var place = $("#export_place_sale_edit option:selected").val();
    var export_note =$("#export_note").val();
    var price = $("#export_price").val();
    var price_id = $("#export_id_price_edit").val();

    // Ajax Edit-Popup
    $(this).helloWorld(message_confirm_save_field ,urlIndex + "?type="+type_list,null,
        {
            url:editPostPriceProductSale,
            data:{type:3,product:product,place:place,note:export_note,price:price,price_id:price_id},
            error_message:message_error_ajax,
            success_callback_function:"edit_record_price_export", 
            is_master: true
        }
    );
}); 

// Export
$(document).on("click", "#btnExportPrice", function(){
    var value_type = $('input[name=type]:checked').val();
    if(value_type == 1) {
        var getUrl = url_export_sale.split("?")[0];
        window.open(getUrl);
    } else if(value_type == 2) {
        var getUrl = url_export_import.split("?")[0];
        window.open(getUrl);
    } else if(value_type == 3) {
        var getUrl = url_export_export.split("?")[0];
        window.open(getUrl);
    }
});

// Import
$('#form_import_csv_price').on("submit", function(e){  
    e.preventDefault();

    var ext = $("#import_file").val().split(".").pop().toLowerCase(); 

	if($.inArray(ext, ["csv"]) == -1) {
		$(this).helloWorld(jquery_validation_extension);
		return false;
    }
    
    var value_type = $('input[name=type]:checked').val();
    var url_import = "";
    if(value_type == 1) {
        var url_import = url_import_sale;
    } else if(value_type == 2) {
        var url_import = url_import_import;
    } else if(value_type == 3) {
        var url_import = url_import_export;
    }

    $.ajax({  
         url:url_import,  
         method:"POST",  
         data:new FormData(this),  
         contentType:false,
         cache:false,
         processData:false, 
         success: function(data){  
            var result = JSON.parse(data);
            if(result.success == true) {
                $(this).helloWorld(result.message, urlIndex + "?type="+value_type);
            } else {
                $(this).helloWorld(result.message);
            }
         }
    });
});

$(document).ready(function() {
    $('#sale_customer,#inputLabelCustomer').inputpicker({
        width:'300px',
        url: get_customer_selectbox,
        fields:[{"name":CUS_ID, "text":"得意先ID"}, {"name":CUS_CUSTOMER_NAME, "text":"得意先名"}],
        fieldText:CUS_CUSTOMER_NAME,
        fieldValue:CUS_ID,
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
    $('input.sale_product_add,#sale_product,#inputLabelProduct').inputpicker({
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

    $('input.export_product, input.import_product').inputpicker({
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
    
});
 
// Chèn hàng cho giá xuất kho
var htmlPriceExport = $('#getBoxRow').html();
$('#addRow').click(function(){
    $('#setBoxRow').append(htmlPriceExport);

    $('input.export_product:last').inputpicker({
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
});

// Xóa hàng
$(document).on("click",".btnDeleteBoxRowSale", function(){
    var numItems = $('.btnDeleteBoxRowSale').length;
    if(numItems > 1) {
        $(this).parent().parent().remove();
    }
});
$(document).on("click",".btnDeleteBoxRowExport", function(){
    var numItems = $('.btnDeleteBoxRowExport').length;
    if(numItems > 1) {
        $(this).parent().parent().remove();
    }
});
$(document).on("click",".btnDeleteBoxRowImport", function(){
    var numItems = $('.btnDeleteBoxRowImport').length;
    if(numItems > 1) {
        $(this).parent().parent().remove();
    }
});

function replaceNamePriceExport(){
    $('input.export_product[name*=export_product]').each(function(i) {
        $(this).attr('name', $(this).attr('name') + i); 
    });

    $('input.export_price').each(function(i) {
        $(this).attr('name', $(this).attr('name') + i); 
    });
}

function replaceNamePriceImport(){
    $('input.import_product[name*=import_product]').each(function(i) {
        $(this).attr('name', $(this).attr('name') + i); 
    });

    $('input.import_price').each(function(i) {
        $(this).attr('name', $(this).attr('name') + i); 
    });
}

function replaceNamePriceSale(){
    $('input.sale_product_add[name*=sale_product_add]').each(function(i) {
        $(this).attr('name', $(this).attr('name') + i); 
    });

    $('input.import_price').each(function(i) {
        $(this).attr('name', $(this).attr('name') + i); 
    });

    $('input.sale_price').each(function(i) {
        $(this).attr('name', $(this).attr('name') + i); 
    });

    $('input.sale_price_gaichyu').each(function(i) {
        $(this).attr('name', $(this).attr('name') + i); 
    });
}

// Chèn hàng nhập kho
var htmlPriceImport = $('#getBoxRowImport').html();
$('#addRowImport').click(function(){
    $('#setBoxRowImport').append(htmlPriceImport);

    $('input.import_product:last').inputpicker({
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
});

// Chèn hàng giá bán khách sạn
var htmlPriceSale = $('#getBoxRowSale').html();
$(document).on("click","#addRowSale", function(){

    var gaichyu_value = $("#sale_base option:selected").data("gaichyu");
    var myThis = $(this);
            var $html = $('<div />',{html:htmlPriceSale});
            $html.find(".sale_price_user").val("");
            $html.find(".box_input_product").html('<input class="form-control sale_product_add" name="sale_product_add" value="" /><span></span>');
            if(gaichyu_value == 1 || gaichyu_value == "1") {
                $html.find(".box_input_product_price_gaichyu").html('<input class="form-control sale_price_gaichyu" name="sale_price_gaichyu" >');
            }
            $('#setBoxRowSale').append($html.html());

    $('input.sale_product_add:last').inputpicker({
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
});

//
$(document).on("change",".sale_product_add", function(){ 
    var varThis = $(this);
    var product_id = varThis.val();

    if(product_id == '' || product_id == null){ 
        //return;
    }

    $.ajax({
        url:getDetailProduct,
        data:{product_id:product_id,type:3},
        dataType:'json',
        method:'GET',
        success:function(result){
            if(result != null && result != '') {
                varThis.parent().parent().parent().parent().parent().find(".product_sale_name").val(result['product_name']);
                varThis.parent().parent().parent().parent().parent().find(".product_sale_name").prop('disabled', false);
            } else {
                varThis.parent().parent().parent().parent().parent().parent().parent().find(".product_sale_name").val("");
                varThis.parent().parent().parent().parent().parent().parent().parent().find(".product_sale_name").prop('disabled', true);
            }
        }
    });
});
