// render
$(document).ready(function() {

    jQuery('#order_from').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#order_to');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#order_to').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#order_from');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');
    
    jQuery('#delivery_from').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#delivery_to');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#delivery_to').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#delivery_from');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
	}).attr('readonly','readonly');

    FuncCheckList(false,false);
});

// Click customer
$(document).on("change","#customer", function(){
    var val = $(this).val();
    if(val == '' || val == null){
        $('#department').val("");
        loadCustomer("","");
    }
    var valDep = $('#department').val();
		$("#department").html("");
    $.ajax({
        url:customerDepartmentUrl,
        data:{customer_id:val},
        dataType:'json',
        method:'GET',
        success:function(result){
            var option = '<option value=""></option>';
				if(result != null){
					for(var i=0;i<result.length;i++){
						if(valDep != "" && valDep == result[i]['department_code']){
							option += '<option selected value="'+result[i]['department_code']+'">'+result[i]['department']+'</option>';
						}else{
							option += '<option value="'+result[i]['department_code']+'">'+result[i]['department']+'</option>';
						}
						
					}
				}
            $("#department").html(option);
        }
    })
});

$('#department').change(function(){
    var val = $(this).val();
    var valCus = $('#customer option:selected').val();
    if(valCus == "") {
        loadCustomer(val,valCus);
    }
});

function loadCustomer(val,valCus){
    $("#customer").html("");
        $.ajax({
            url:departmentCustomerUrl,
            data:{department_id:val},
            dataType:'json',
            method:'GET',
            success:function(result){
                var option = '<option value=""></option>';
                if(result != null){
                    for(var i=0;i<result.length;i++){
                        if(valCus != "" && valCus == result[i]['customer_id']){
                            option += '<option selected value="'+result[i]['customer_id']+'">'+result[i]['customer_name']+'</option>';
                        }else{
                            option += '<option value="'+result[i]['customer_id']+'">'+result[i]['customer_name']+'</option>';
                        }
                        
                    }
                }
                $("#customer").html(option);
            }
        });
}

// Click search
$(document).on("click","#search", function(){
    FuncCheckList(false,false);
});

// Print checklist
$(document).on("click","#check_list", function(){
    FuncCheckList(true, true);
});

// Save
$(document).on("click","#save_checklist", function(){
    var data = [];
    var id_order = [];
    var date_update = [];
    $("#detail_delivery").find("input:checked").each(function(item){
        data.push($(this).data("id"));
        date_update.push($(this).data("date"));
        id_order.push($(this).data("order"));
    })

    // Data
    if(data.length > 0){ 
        $(this).helloWorld(message_title_confirm_checklist,viewcheckListUrl,null,{
            url:checkListUrl,
            data:{data:data,date_update:date_update,id_order:id_order},
            error_message:errorAjax,
            ok_text: 'OK',
            cancel_text: 'キャンセル'
        });
    }
    else{
        $(this).helloWorld(notCheckData,null);
    }

    return false;
});

// Function Check List
function FuncCheckList(pdf_export, viewError){
    if(pdf_export == "" || pdf_export == null) {
		pdf_export = false;
    }
    if(viewError == "" || viewError == null) {
		viewError = false;
	}
    var user = $("#user").val();
    var customer = $("#customer").val();
    var order_from = $("#order_from").val();
    var order_to = $("#order_to").val();
    var delivery_from = $("#delivery_from").val();
    var delivery_to  = $("#delivery_to").val();
    var department = $("#department").val();
    var order_no = $("#order_no").val();

    var tables = $.fn.dataTable.fnTables(true);

    $(tables).each(function () {
        $(this).dataTable().fnDestroy();
    });

    $.ajax({
        url:checklistViewUrl,
        data:{user:user,customer:customer,order_from:order_from,order_to:order_to,delivery_from:delivery_from,delivery_to:delivery_to,department:department,order_no:order_no},
        dataType:'json',
        method:'GET',
        success:function(result){
            var html = '';
            var total = 0.0;
            // Show message
            if(result.count_search > 0) {
                if(pdf_export == true) {
                    var getUrl = url_export_checklist.split("?")[0];
                    getUrl = getUrl + '?user=' + user + '&customer=' + customer + '&order_from=' + 
                    order_from + '&order_to=' + order_to + '&delivery_from=' + delivery_from + '&delivery_to=' + 
                    delivery_to + '&department=' + department + '&order_no=' + order_no + '&print=true';

                    if(result.count_default != result.count_search) {
                        $(this).helloWorldOpenWindow(message_success_checklist_diff_search,getUrl);
                    } else {
                        window.open(getUrl, '_blank');
                    }
                } else {
                    if(result.count_default != result.count_search) {
                        $(this).helloWorld(message_success_checklist_diff_search,null);
                    }
                }
            } else {
                if(viewError == true) {
                    $(this).helloWorld(message_error_not_data_checked,null);
                }
            }

            // Order
            if(result.order.length > 0) {
                result.order.forEach(function(value) {
                    var amount = 0.0;
                    if(result.detail.length > 0){
                        result.detail.forEach(function(value_delivery) {
                            if(value['order_id'] == value_delivery['order_id']) {
                                var money = parseFloat(value_delivery['amount']);
                                if(value_delivery['quantity_order_change'] == "" || value_delivery['quantity_order_change'] == null) {
                                    value_delivery['quantity_order_change'] = 0;
                                }
                                var value_quantity_order = parseFloat(value_delivery['quantity_order'])+parseFloat(value_delivery['quantity_order_change']);
                                var value_quantity_delivery = parseFloat(value_delivery['quantity_delivery']);
                                var style_red = "";
                                if(value_quantity_delivery < value_quantity_order) {
                                    style_red = "color:red;";
                                }
                                html += '<tr>';
                                html += '<td><a href="'+editDeliveryUrl+'?id='+value_delivery['order_id']+'">'+value_delivery['order_id']+'</a></td>';
                                html += '<td>'+formatDate(value_delivery['date_delivery'])+'</td>';
                                html += '<td>'+value_delivery['customer_name']+'</td>';
                                html += '<td>'+value_delivery['department_name']+'</td>';
                                //html += '<td>'+value_delivery['product_code_sale']+'</td>';
                                if(value_delivery['product_code_sale'] == "" || value_delivery['product_code_sale'] == null) {
                                    html += '<td class="field_delete">'+message_delete_product+'</td>';
                                } else {
                                    html += '<td>'+value_delivery['product_code_sale']+'</td>';
                                }
                                
                                html += '<td>'+value_delivery['product_name_sale']+'</td>';
                                if(value_delivery['product_special'] == 1 || value_delivery['product_special'] == "1") {
                                    html += '<td></td>';
                                    html += '<td></td>';
                                    html += '<td></td>';
                                } else {
                                    html += '<td>'+formatMoney(parseFloat(value_quantity_order).toFixed(0))+'</td>';
                                    html += '<td style="'+style_red+'">'+formatMoney(parseFloat(value_quantity_delivery).toFixed(0))+'</td>';
                                    html += '<td>'+formatMoney(parseFloat(value_delivery['price']).toFixed(2)) + '</td>';
                                }
                                 
                                html += '<td>'+(isNaN(money)?'':formatMoney(money.toFixed(2)))+'</td>';
                                if(value_delivery['checklist'] == 0 || value_delivery['checklist'] == '0') {
                                    html += '<td><input type="checkbox" data-fullcheck="0" data-order="'+value_delivery['order_id']+'" data-date="'+value_delivery['date_update']+'" data-id="'+value_delivery['id']+'" /></td>';
                                } else {
                                    html += '<td></td>';
                                }
                                html += '</tr>';
                                if(!isNaN(money)){
                                    amount += money;
                                    total += money;
                                }
                            }
                        });
                    }
                    if(amount > 0) {
                        html += '<tr class="sum-col">';
                        html += '<td class="no-borderR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderL sum">小計</td>';
                        html += '<td>'+formatMoney(amount.toFixed(2))+'</td>';
                        html += '<td>&nbsp;</td>';
                        html += '</tr>';
                    }
                });
                if(total > 0) {
                    html += '<tr class="sum-col">';
                        html += '<td class="no-borderR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderLR">&nbsp;</td>';
                        html += '<td class="no-borderL sum">合計</td>';
                    html += '<td>'+formatMoney(total.toFixed(2))+'</td>';
                    html += '<td>&nbsp;</td>';
                    html += '</tr>';
                }
            }

            $("#detail_delivery").html(html);

            //if(isDatatable == true) {
                $('#checklist-table').DataTable({
                    "scrollY":        "360px",
                    "scrollCollapse": true,
                    "paging":         false,
                    responsive: false,
                    searching: false, 
                    paging: false,
                    "ordering": false,
                    "info":     false
                });
           // }
        },
        error:function(result) {
            var html = '';
            html = '<tr class="odd row-empty"><td valign="top" colspan="11" class="dataTables_empty">'+message_empty_data+'</td></tr>';
            $("#detail_delivery").html(html);
        }
    });
}

// Check all
$(document).on("click","#checkAll",function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});

// Format Date
function formatDate(date) {
	var dataDate = date.split(" ");
	var dateStringInRange = dataDate[0];
    var isoExp = /^\s*(\d{4})-(\d\d)-(\d\d)\s*$/,
        date = new Date(NaN), month,
        parts = isoExp.exec(dateStringInRange);

    if(parts) {
      month = +parts[2];
      date.setFullYear(parts[1], month - 1, parts[3]);
      if(month != date.getMonth() + 1) {
        date.setTime(NaN);
      }
	}
	
	var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
		year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

	return [year, month, day].join('/');

  }