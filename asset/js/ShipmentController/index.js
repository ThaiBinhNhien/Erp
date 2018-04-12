// config color
var CSS_COLOR_NAMES = ["red","#0099ba","Blue","BlueViolet","Chocolate","Coral","CornflowerBlue","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","Darkorange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","Grey","Green","GreenYellow","HoneyDew","HotPink","IndianRed","Indigo","Ivory","Khaki","Lavender","LavenderBlush","LawnGreen","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow","LightGray","LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateGray","LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen","Linen","Magenta","Maroon","MediumAquaMarine","MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumSpringGreen","MediumTurquoise","MediumVioletRed","MidnightBlue","MintCream","MistyRose","Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab","Orange","OrangeRed","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple","Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal","Thistle","Tomato","Turquoise","Violet","Wheat","White","WhiteSmoke","Yellow","YellowGreen"];
var called_index = 0;
// Document ready
$(document).ready(function(){

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


	funcGetListShipment();

	//$('#customer').prop('disabled', true);
	$.ajax({
		url:getCustomerByClassification, 
		dataType:'json',
		method:'GET',
		success:function(result){
			var option = '<option value=""></option>';
			if(result != null){
				for(var i=0;i<result.length;i++){
					option += '<option value="'+result[i]['customer_id']+'">'+result[i]['customer_shipment_name']+'</option>';
				}
			}
			$("#customer").html(option);

		}
	});
	//$('#department_name').prop('disabled', true);
	$.ajax({
		url:getDepartmentByCustomer,
		dataType:'json',
		method:'GET',
		success:function(result){
			var option = '<option value=""></option>';
			if(result != null){
				for(var i=0;i<result.length;i++){
					option += '<option value="'+result[i]['department_code']+'">'+result[i]['department']+'</option>';
				}
			}
			$("#department_name").html(option);
		}
	});
});

// Search shipment
$(document).on("click","#search_shipment", function(){
	funcGetListShipment(false);
});

// Get list
function funcGetListShipment(csv){
	if(csv == "" || csv == null || csv === undefined) {
		csv = false;
	}
	var ticket_no = $('#ticket_no').val();
	var voter = $('#shipment_voter').val();
	var shipping_category = $("#shipping_category option:selected").val();
	var shipment_status = $("#shipment_status option:selected").val();
	var delivery_from = $("#delivery_from").val();
	var delivery_to  = $("#delivery_to").val();
	var customer = $("#customer option:selected").val();
	var department_name = $("#department_name option:selected").val();
	var text_note = $("#text_note").val();
	$.ajax({
		url:shipmentViewUrl, 
		data:{ticket_no:ticket_no,voter:voter,shipping_category:shipping_category,shipment_status:shipment_status,delivery_from:delivery_from,delivery_to:delivery_to,
			  customer:customer,department_name:department_name,text_note:text_note},
		dataType:'json',
		method:'GET',
		success:function(result){
			// Csv
			if(csv == true) {
				if(result.length > 0) {
					var ticket_no = $('#ticket_no').val();
					var voter = $('#shipment_voter').val();
					var shipping_category = $("#shipping_category option:selected").val();
					var shipment_status = $("#shipment_status option:selected").val();
					var delivery_from = $("#delivery_from").val();
					var delivery_to  = $("#delivery_to").val();
					var customer = $("#customer option:selected").val();
					var department_name = $("#department_name option:selected").val();
					var text_note = $("#text_note").val();

					var getUrl = url_export.split("?")[0];
					getUrl = getUrl + '?ticket_no=' + ticket_no + '&voter=' + voter + '&shipping_category=' + 
					shipping_category + '&shipment_status=' + shipment_status + '&delivery_from=' + delivery_from + '&delivery_to=' + 
					delivery_to + '&customer=' + customer + '&department_name=' + department_name + '&text_note=' + text_note + '&print=false';
					window.open(getUrl);
				}
			}

			// Table
			var tables = $.fn.dataTable.fnTables(true);

			$(tables).each(function () {
			    $(this).dataTable().fnDestroy();
			});
			var html = '';
			for(var i=0; i<result.length; i++){
				html += '<tr data-status="'+result[i]['status']+'">';
				html += '<td><a href="'+detailShipmentViewUrl+'?id='+result[i]['ticket_no']+'" target="_blank">'+result[i]['ticket_no']+'</a></td>';
                html += '<td>'+result[i]['creater_date']+'</td>';
                if(result[i]['customer_name'] != null && result[i]['customer_name'] != '') {
                	html += '<td>'+result[i]['customer_name'].replace(/,/g , "<br>")+'</td>';
                }
                else {
                	html += '<td></td>';
                }
                if(result[i]['department_name'] != null && result[i]['department_name'] != '') {
                	html += '<td>'+result[i]['department_name'].replace(/,/g , "<br>")+'</td>';
                }
                else {
                	html += '<td></td>';
                }
				
				if(result[i]['delivery_classification'] != null && result[i]['delivery_classification'] != '') {
                	html += '<td>'+result[i]['delivery_classification']+'</td>';
                }
                else {
                	html += '<td></td>';
                }
				
				
                if(result[i]['status'] == "1" || result[i]['status'] == 1) {
                	html += '<td><span style="color:red">一時保存</span></td>';
                }
                else if(result[i]['status'] == "2" || result[i]['status'] == 2) {
                	html += '<td><span style="color:red">出荷未確定</span></td>';
                }
                else if(result[i]['status'] == "3" || result[i]['status'] == 3) {
                	if(result[i]['number_request'] != null && result[i]['number_request'] > 0) {
	                	html += '<td><span style="color:'+CSS_COLOR_NAMES[result[i]['number_request']]+'">再依頼('+result[i]['number_request']+')</span></td>';
	                }
	                else {
	                	html += '<td><span style="color:color:red">再依頼</span></td>';
	                }
                }
                else if(result[i]['status'] == "4" || result[i]['status'] == 4) {
                	html += '<td><span style="color:red">出荷確定(不足)</span></td>';
                }
                else if(result[i]['status'] == "5" || result[i]['status'] == 5) {
                	html += '<td><span>出荷確定</span></td>';
                }
                else {
                	html += '<td>&nbsp;</td>'; 
                }
                html += '<td>'+result[i]['delivery_date']+'</td>';
            	html += '</tr>';
			}


			$("#shipment_table tbody").html(html); 

			//if(isDatatable == true) {
				$("#shipment_table").DataTable( {
			        "scrollY":        "360px",
			        "scrollCollapse": true,
			        "paging":         false,
			         responsive: true, 
					searching: false, 
			        "ordering": false,
			        "info":     false
				});
				called_index = 0;
				renewScroll();
			//}
		},
		error:function(result) {
			var html = '';
			html = '<tr class="odd row-empty"><td valign="top" colspan="7" class="dataTables_empty">'+message_empty_data+'</td></tr>';
			$("#shipment_table tbody").html(html);
		}
	});
}

// Get customer by delivery classification
$(document).on("change","#shipping_category", function(){
	var val = $(this).find('option:selected').val();
	var customer_id = $('#customer option:selected').val();
	$("#customer").html("");
	$.ajax({
		url:getCustomerByClassification,
		data:{classification_id:val},
		dataType:'json',
		method:'GET',
		success:function(result){
			var option = '<option value=""></option>';
			if(result != null){
				for(var i=0;i<result.length;i++){
					var selected = "";
					if(customer_id != "" && customer_id == result[i]['customer_id']) {
						selected = "selected";
					}
					option += '<option value="'+result[i]['customer_id']+'" '+selected+'>'+result[i]['customer_shipment_name']+'</option>';
				}
			}
			$("#customer").html(option);

		}
	});
});

// Get department by customer
$(document).on("change","#customer", function(){
	var val = $(this).find('option:selected').val();
	if(val == '' || val == null){
        $('#department_name').val("");
        loadCustomer("","");
    }
	var department_id = $('#department_name option:selected').val();
	$("#department_name").html("");
	$.ajax({
		url:getDepartmentByCustomer,
		data:{customer_id:val},
		dataType:'json',
		method:'GET',
		success:function(result){
			var option = '<option value=""></option>';
			if(result != null){
				for(var i=0;i<result.length;i++){
					var selected = "";
					if(department_id != "" && department_id == result[i]['department_code']) {
						selected = "selected";
					}
					option += '<option value="'+result[i]['department_code']+'" '+selected+'>'+result[i]['department']+'</option>';
				}
			}
			$("#department_name").html(option);
		}
	})
});

$('#department_name').change(function(){
    var val = $(this).val();
    var valCus = $('#customer option:selected').val();
    if(valCus == "") {
        loadCustomer(val,valCus);
    }
});

function loadCustomer(val,valCus){
    $("#customer").html("");
        $.ajax({
            url:getCustomerByDepartment,
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


// On click column
$(document).on("dblclick","table>tbody>tr:not(.row-empty)",function(){
	var id = $.trim($(this).find('td').eq(0).text());
	var count_tr_null = $(this).find('.dataTables_empty').length;
	if(count_tr_null <= 0) {
		window.open(detailShipmentViewUrl+"?id="+id, '_blank');
	}
});

// Scroll By height
function renewScroll(){
	$('#shipment .dataTables_scrollBody').on('scroll', function() {
		var start_index = $('#shipment_table tbody tr').length;
		var ticket_no = $('#ticket_no').val();
		var voter = $('#shipment_voter').val();
		var shipping_category = $("#shipping_category option:selected").val();
		var shipment_status = $("#shipment_status option:selected").val();
		var delivery_from = $("#delivery_from").val();
		var delivery_to  = $("#delivery_to").val();
		var customer = $("#customer option:selected").val();
		var department_name = $("#department_name option:selected").val();
		var text_note = $("#text_note").val();

		if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
			$.ajax({
				url:shipmentViewUrl,
				data:{ticket_no:ticket_no,voter:voter,shipping_category:shipping_category,shipment_status:shipment_status,delivery_from:delivery_from,delivery_to:delivery_to,
					customer:customer,department_name:department_name,text_note:text_note,start_index:start_index},
				dataType:'json',
				method:'GET',
				success:function(result){

					var html = '';
					for(var i=0; i<result.length; i++){
						html += '<tr data-status="'+result[i]['status']+'">';
						html += '<td><a href="'+detailShipmentViewUrl+'?id='+result[i]['ticket_no']+'" target="_blank">'+result[i]['ticket_no']+'</a></td>';
						html += '<td>'+result[i]['creater_date']+'</td>';
						if(result[i]['customer_name'] != null && result[i]['customer_name'] != '') {
							html += '<td>'+result[i]['customer_name'].replace(/,/g , "<br>")+'</td>';
						}
						else {
							html += '<td></td>';
						}
						if(result[i]['department_name'] != null && result[i]['department_name'] != '') {
							html += '<td>'+result[i]['department_name'].replace(/,/g , "<br>")+'</td>';
						}
						else {
							html += '<td></td>';
						}
						
						if(result[i]['delivery_classification'] != null && result[i]['delivery_classification'] != '') {
							html += '<td>'+result[i]['delivery_classification']+'</td>';
						}
						else {
							html += '<td></td>';
						}
						
						if(result[i]['status'] == "1" || result[i]['status'] == 1) {
							html += '<td><span style="color:red">一時保存</span></td>';
						}
						else if(result[i]['status'] == "2" || result[i]['status'] == 2) {
							html += '<td><span style="color:red">出荷未確定</span></td>';
						}
						else if(result[i]['status'] == "3" || result[i]['status'] == 3) {
							if(result[i]['number_request'] != null && result[i]['number_request'] > 0) {
								html += '<td><span style="color:'+CSS_COLOR_NAMES[result[i]['number_request']]+'">再依頼('+result[i]['number_request']+')</span></td>';
							}
							else {
								html += '<td><span style="color:color:red">再依頼</span></td>';
							}
						}
						else if(result[i]['status'] == "4" || result[i]['status'] == 4) {
							html += '<td><span style="color:red">出荷確定(不足)</span></td>';
						}
						else if(result[i]['status'] == "5" || result[i]['status'] == 5) {
							html += '<td><span>出荷確定</span></td>';
						}
						else {
							html += '<td>&nbsp;</td>';
						}
						html += '<td>'+result[i]['delivery_date']+'</td>';
						html += '</tr>';
					}
					
					$("#shipment_table tbody").append(html);

					// Adjust
					var table = $('#shipment_table').DataTable();
					table.columns.adjust();
				}
			});
		}
	});
}

// Export
$(document).on("click","#btnExportList", function(){
	funcGetListShipment(true);
});