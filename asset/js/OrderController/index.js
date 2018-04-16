// render
var called_index = 0;
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
});

// Func Get List
function getBySearch(){
	var user = $("#user").val();
		var customer = $("#customer").val();
		var order_from = $("#order_from").val();
		var order_to = $("#order_to").val();
		var delivery_from = $("#delivery_from").val();
		var delivery_to  = $("#delivery_to").val();
		var status = $("#status").val();
		var claim_check = $("#claim_check").val();
		var department = $("#department").val();
		var order_no = $("#order_no").val();
		var tempDate1 = new Date(order_from);
		var tempDate2 = new Date(order_to);
		if(tempDate2<tempDate1){
			$("#search").helloWorld("日付についての設定エラーが発生しましたので、再試行してください",null);
			return;
		}
		tempDate1 = new Date(delivery_from);
		tempDate2 = new Date(delivery_to);
		if(tempDate2<tempDate1){
			$("#search").helloWorld("日付についての設定エラーが発生しましたので、再試行してください",null);
			return;
		}
		$("#table_header").parent().parent().parent().attr("id","order-table");
		
		
		$.ajax({
			url:orderViewUrl,
			data:{user:user,customer:customer,order_from:order_from,order_to:order_to,delivery_from:delivery_from,delivery_to:delivery_to,
				  status:status,claim_check:claim_check,department:department,order_no:order_no,start_index:0},
			dataType:'json',
			method:'GET',
			success:function(result){
				var tables = $.fn.dataTable.fnTables(true);

			$(tables).each(function () {
			    $(this).dataTable().fnDestroy();
			});
				
				var html = '';
				for(var i=0; i<result.length; i++){
					html += '<tr>';
					if(result[i]['type'] == 1){
						html += '<td><a href="'+detailUrl1+"?id="+result[i]['id']+'" target="_blank">'+result[i]['id']+'</a><input type="hidden" name="type" value="'+result[i]['type']+'"></td>';
					}else{
						html += '<td><a href="'+detailUrl2+"?id="+result[i]['id']+'" target="_blank">'+result[i]['id']+'</a><input type="hidden" name="type" value="'+result[i]['type']+'"></td>';
					}
					if(result[i]['add_number'] == null){
						result[i]['add_number'] = 0;
					}
					if(result[i]['order_number'] == null){
						result[i]['order_number'] = 0;
					}
					html += '<td>'+formatDate(result[i]['order_date'])+'</td>';
                    html += '<td>'+result[i]['customer_name']+'</td>';
                    html += '<td>'+(result[i]['department'] == null?'':result[i]['department'])+'</td>';
                    html += '<td>'+(result[i]['created_name'] == null?result[i]['user_id']:result[i]['created_name'])+'</td>';
                    html += '<td>'+(result[i]['status'] == "1"?'確定':'<span style="color:red">一時保存</span>')+'</td>';
                    html += '<td>'+(parseFloat(result[i]['order_number'])+parseFloat(result[i]['add_number']))+'</td>';
                    html += '<td>'+result[i]['delivery_number']+'</td>';
                    html += '<td>'+formatDate(result[i]['delivery_expected'])+'</td>';
                	html += '</tr>';
				}

				/*if(html == ''){
					$('#search').helloWorld(message_empty_data,null);
				} */
				
				$("#detail_data").html(html);
				$("#order-table table").DataTable( {
						"scrollY":        "360px",
						"scrollCollapse": true,
						"paging":         false,
						responsive: true,
						searching: false, paging: false,
						"ordering": false,
						"info":     false,
						"oLanguage": {
							"sEmptyTable": message_empty_data
						}
					});
					called_index = 0;
					renewScroll(); 
				

			},
			error:function(err){
				var tables = $.fn.dataTable.fnTables(true);

				$(tables).each(function () {
				    $(this).dataTable().fnDestroy();
				});
				$("#detail_data").html('');
				$("#order-table table").DataTable( {
						"scrollY":        "360px",
						"scrollCollapse": true,
						"paging":         false,
						responsive: true,
						searching: false, paging: false,
						"ordering": false,
						"info":     false,
						"oLanguage": {
							"sEmptyTable": message_empty_data
						}
					});
					called_index = 0;
				renewScroll();
				
				//$('#search').helloWorld(message_empty_data,null);
				
			}
		})
		$("#check_list_panel").css("display","none");
		$("#checklist-order").attr("id","receive-order");
}

// Scroll
function renewScroll(){
	$('#order-table .dataTables_scrollBody').on('scroll', function() {
	 //Return number tr row in tbody
		 var start_index = $('#detail_data tr').length;

		 var user = $("#user").val();
		 var customer = $("#customer").val();
		 var order_from = $("#order_from").val();
		 var order_to = $("#order_to").val();
		 var delivery_from = $("#delivery_from").val();
		 var delivery_to  = $("#delivery_to").val();
		 var status = $("#status").val();
		 var claim_check = $("#claim_check").val();
		 var department = $("#department").val();
		 if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
		 $.ajax({
				 url : orderViewUrl,
				 data: {user:user,customer:customer,order_from:order_from,order_to:order_to,delivery_from:delivery_from,delivery_to:delivery_to,
				 status:status,claim_check:claim_check,department:department,start_index:start_index},
				 type: 'GET',
				 dataType:'json',
				 success: function(result) {
					 if(result.length>0){

						 for(var i=0; i<result.length; i++){
						   var html = '<tr>';
						   if(result[i]['type'] == 1){
								html += '<td><a href="'+detailUrl1+"?id="+result[i]['id']+'" target="_blank">'+result[i]['id']+'</a><input type="hidden" name="type" value="'+result[i]['type']+'"></td>';
							}else{
								html += '<td><a href="'+detailUrl2+"?id="+result[i]['id']+'" target="_blank">'+result[i]['id']+'</a><input type="hidden" name="type" value="'+result[i]['type']+'"></td>';
							} html += '<td>'+formatDate(result[i]['order_date'])+'</td>';
						   html += '<td>'+result[i]['customer_name']+'</td>';
						   html += '<td>'+(result[i]['department'] == null?'':result[i]['department'])+'</td>';
						   html += '<td>'+(result[i]['created_name'] == null?result[i]['user_id']:result[i]['created_name'])+'</td>';
						   html += '<td>'+(result[i]['status'] == "1"?'確定':'<span style="color:red">一時保存</span>')+'</td>';
						   html += '<td>'+result[i]['order_number']+'</td>';
						   html += '<td>'+result[i]['delivery_number']+'</td>';
						   html += '<td>'+formatDate(result[i]['delivery_expected'])+'</td>';
						   html += '</tr>';
						   $('#detail_data').append(html);
					   }

					   // Adjust
						var table = $('#order-table table').DataTable();
						table.columns.adjust();
					 }
				 }
		  });
	   };
   });
}

$(document).ready(function(){
	var first_time = true;
	getBySearch();
	$("#search").click(function(){
		getBySearch();
	});
	$('#customer').change(function(){
		var val = $(this).val();
		if(val == "") {
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
				// if(result == null || result.length == 0){
				// 	for(var i=0;i<listDepartment.length;i++){
				// 		option += '<option value="'+result[i]['department_code']+'">'+result[i]['department']+'</option>';
				// 	}
				// }
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

	$(document).on("dblclick","table>tbody>tr:not(.row-empty)",function(){
		var id = $.trim($(this).find('td').eq(0).text());
		var type = $(this).find('td').eq(0).find("input").val();
		var count_tr_null = $(this).find('.dataTables_empty').length;
		if(count_tr_null <= 0) {
			if(type == 1){
				window.open(detailUrl1+"?id="+id, '_blank');
			} else {
				window.open(detailUrl2+"?id="+id, '_blank');
			}
		}
	});
	

	// Function Check List
	function FuncCheckList(){
		var delivery_from = $("#delivery_from").val();
		var delivery_to = $("#delivery_to").val();
		if(delivery_from == "" && delivery_to == ""){
			$(this).helloWorld(notSelectDateChecklist,null);
		}
		else{
			$("#order-table").css("display","none");
			$("#check_list_panel").css("display","block");
			var tables = $.fn.dataTable.fnTables(true);

			$(tables).each(function () {
			    $(this).dataTable().fnDestroy();
			});

			$("#receive-order").attr("id","checklist-order");

			$.ajax({
				url:checklistViewUrl,
				data:{delivery_from:delivery_from,delivery_to:delivery_to},
				dataType:'json',
				method:'GET',
				success:function(result){
					var html = '';
					var total = 0.0;
					// Order
					if(result.order.length > 0) {
						result.order.forEach(function(value) {
						    var amount = 0.0;
						    if(result.detail.length > 0){
						    	result.detail.forEach(function(value_delivery) {
						    		if(value['order_id'] == value_delivery['order_id']) {
										var money = parseFloat(value_delivery['amount']);
										var style_red = "";
										if(value_delivery['quantity_delivery'] < value_delivery['quantity_order']) {
											style_red = "color:red;";
										}
						    			html += '<tr>';
										html += '<td><a href="'+editDeliveryUrl+'?id='+value_delivery['order_id']+'">'+value_delivery['order_id']+'</a></td>';
					                    html += '<td>'+formatDate(value_delivery['date_delivery'])+'</td>';
					                    html += '<td>'+value_delivery['customer']+'</td>';
					                    html += '<td>'+value_delivery['department']+'</td>';
					                    html += '<td>'+value_delivery['product_id']+'</td>';
					                    html += '<td>'+value_delivery['product_name']+'</td>';
					                    html += '<td>'+value_delivery['quantity_order']+'</td>';
					                    html += '<td style="'+style_red+'">'+value_delivery['quantity_delivery']+'</td>';
					                    html += '<td>'+parseFloat(value_delivery['price']).toFixed(2) + '</td>';
					                    html += '<td>'+(isNaN(money)?'':money.toFixed(2))+'</td>';
					                    html += '<td><input type="checkbox" data-fullcheck="0" data-id="'+value_delivery['id']+'" /></td>';
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
								html += '<td>'+amount.toFixed(2)+'</td>';
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
								html += '<td class="no-borderL sum">小計</td>';
							html += '<td>'+total.toFixed(2)+'</td>';
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
					        searching: false, paging: false,
					        "ordering": false,
					        "info":     false
					    });
					//}
				},
				error:function(result) {
					var html = '';
					html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
					$("#detail_delivery").html(html);
				}
			})
		}
	}

	 $(document).on("click","#checkAll",function () {
         $('input:checkbox').not(this).prop('checked', this.checked);
      });
	 $(document).on("change","#detail_data > tr > td > input:checkbox",function () {
         var check_id = $(this).data("id");
         var total_check = $("input[type=checkbox][data-id="+check_id+"]:checked").size();
         var total_id = $("input[type=checkbox][data-id="+check_id+"]").size();
         if(total_check != total_id){
         	$("input[type=checkbox][data-id="+check_id+"]").each(function(item){
         		$(this).attr("data-fullcheck",0);
         	});
         }else{
         	$("input[type=checkbox][data-id="+check_id+"]").each(function(item){
         		$(this).attr("data-fullcheck",1);
         	});
         }
      });

	 $("#save_checklist").click(function(){
	 	var data = [];
	 	$("#detail_delivery").find("input:checked").each(function(item){
	 		data.push($(this).data("id"));
	 	})

	 	// Data
	 	if(data.length > 0){
	 		$.ajax({
		 		url:checkListUrl,
		 		data:{data:data},
		 		dataType:"json",
		 		method:"POST",
		 		success:function(result){
		 			if(result.success == true){
		 				FuncCheckList();
		 			}
		 		}
		 	});
	 	}
	 	else{
	 		$(this).helloWorld(notCheckData,null);
	 	}

	 	return false;
	 });

	 
	
	 first_time = false;
});

/*function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
		year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('/');
}*/
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

// Print checklist
$(document).on("click","#check_list", function(){
	FuncCheckListPdfExport();
});
// Function Check List
function FuncCheckListPdfExport(){
    var user = $("#user").val();
    var customer = $("#customer").val();
    var order_from = $("#order_from").val();
    var order_to = $("#order_to").val();
    var delivery_from = $("#delivery_from").val();
    var delivery_to  = $("#delivery_to").val();
    var department = $("#department").val();
	var order_no = $("#order_no").val();
	
    $.ajax({
        url:checklistViewUrl,
        data:{user:user,customer:customer,order_from:order_from,order_to:order_to,delivery_from:delivery_from,delivery_to:delivery_to,department:department,order_no:order_no},
        dataType:'json',
        method:'GET',
        success:function(result){
            // Show message
            if(result.count_search > 0) {
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
                $(this).helloWorld(message_error_not_data_checked,null);
            }
        }
    });
}

// Export
$(document).on("click","#btnExportList", function(){
	var user = $("#user").val();
	var customer = $("#customer").val();
	var order_from = $("#order_from").val();
	var order_to = $("#order_to").val();
	var delivery_from = $("#delivery_from").val();
	var delivery_to  = $("#delivery_to").val();
	var status = $("#status").val();
	var claim_check = $("#claim_check").val();
	var department = $("#department").val();
	var order_no = $("#order_no").val();

    var getUrl = url_export.split("?")[0];
    getUrl = getUrl + '?user=' + user + '&customer=' + customer + '&order_from=' + 
    order_from + '&status='+status+'&claim_check='+claim_check+'&order_to=' + order_to + '&delivery_from=' + delivery_from + '&delivery_to=' + 
    delivery_to + '&department=' + department + '&order_no=' + order_no + '&print=false';
    window.open(getUrl);
});
function isFax(text){
	text = String(text);
	if(text.length>8){
		return false;
	}
	var patern = /\d/g;
	var numbers = text.match(patern);
	if(numbers == null || numbers.length != 7){
		return false;
	}
	patern = /(-|\s)/g;
	var chars = text.match(patern);
	if(chars != null && chars.length>1){
		return false;
	}
	return true;
}
function isPhoneNumber(text){
	text = String(text);
	if(text.length>14){
		return false;
	}

	var patern = /^0/g;
	var beginZero = text.match(patern);
	if(beginZero == null || beginZero.length != 1){
		return false;
	}
	patern = /((?![\d-\s]+).)*/g;
	var isNumber = text.match(patern);
	isNumber = isNumber.filter(function(e){return e!=""}); 
	if(isNumber != null && isNumber.length != 0){
		return false;
	}
	patern = /\d/g;
	var numbers = text.match(patern);
	if(numbers == null || numbers.length > 11){
		return false;
	}
	patern = /-/g;
	var chars1 = text.match(patern);
	if(chars1 != null && chars1.length>3){
		return false;
	}
	patern = /\s/g;
	var chars2 = text.match(patern);
	if(chars2 != null && chars2.length>3){
		return false;
	}
	if(chars1 != null && chars1.length !=0 && chars2 != null && chars2.length != 0){
		return false;
	}
	return true;
}
function CheckTextIsPhone(text){
	var indexChar = text.indexOf(',');
	if(indexChar<0){
		return isPhoneNumber(text);
	}else{
		var start_index = 0;
		while(true){
			var phone = null;
			if(indexChar > 0){
				phone = text.substring(start_index,indexChar);
			}else{
				phone = text;
			}
			if(!isPhoneNumber(phone)){
				return false;
			}
			if(indexChar < 0){
				break;
			}
			text = text.substring(indexChar+1);
			indexChar = text.indexOf(',');
		}
		
	}
	return true;
}