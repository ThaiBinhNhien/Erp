
$(document).ready(function(){

	//$('head').append('<link rel="stylesheet" href="'+baseUrl+'asset/bootstrap-select/dist/css/bootstrap-select.min.css" type="text/css" />');
	//$.getScript( baseUrl+"asset/bootstrap-select/dist/js/bootstrap-select.min.js" );
	var is_submit = false;

	// $('.orderDate, .orderToDate').datepicker({
	// 	changeMonth: true,
 //        changeYear: true,
 //        dateFormat: 'yy年mm月dd日 (DD)',
 //        dayNames: ['日', '月', '火', '水', '水', '金', '土']
 //    }).attr('readonly','readonly');
 //    $('.orderDate').datepicker('setDate', 'today');
 //    $('.orderToDate').datepicker('setDate', 'today + 1');

 		$('.orderDate').datepicker({
		dateFormat: 'yy年mm月dd日 (DD)',
        dayNames: ['日', '月', '火', '水', '水', '金', '土'],
		changeMonth: true,
        changeYear: true,
        minDate: 'today',
        onSelect: function () {
            var dt_to = $('.orderToDate');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');
	$('.orderDate').datepicker('setDate', 'today');

	$('.orderToDate').datepicker({
		dateFormat: 'yy年mm月dd日 (DD)',
        dayNames: ['日', '月', '火', '水', '水', '金', '土'],
		changeMonth: true,
        changeYear: true,
        minDate: 'today',
	}).attr('readonly','readonly');
	$('.orderToDate').datepicker('setDate', 'today + 1');

	var arr_floor;
	var begin_floor = 0;
	var end_floor = -1;
	var numberRow = 1;
	var confirm = null;
	var valid = true;
	//Insert row when create-1
	$('#insert').click(function(){

		//var first_data = $("#first_data").html();
		addNewRow()
		return false;
	})

	$('#remove').click(function(){
		//$(this).find(".productselect1").inputpicker("destroy");
		$('.selected').remove();
		if($('#create-table > tbody > tr > td input[name^=addition]').length == 0){
			$('tr.sum-col').find('td').last().text("0.00");
			$("#sum_addition").text("0.00");
		}
		if($("#create-table > tbody > tr:not(.sum-col)").length == 0){
			addNewRow();
		}
		refreshSum();
		
		return false;
	});
	
 
	$(document).on("click","#create-table > tbody > tr:not(.sum-col)",function(){
		$(this).parent().find("tr.selected").removeClass("selected");
		$(this).addClass("selected");
	});
	
	$("#add_floor").click(function(){
		//__Remove width 100% when add
		//$('th.addition').css('width','auto');
		var start_index = parseInt($("#floor_from").val());
		var end_index = parseInt($("#floor_to").val());
		if(start_index > end_index || start_index < 0 || end_index <0)
			return false;

		if(start_index > end_floor || end_index < begin_floor){
			// Tạo floor ban đầu
			$('td[data-floor$="F"]').remove();
			$('th[data-floor$="F"]').remove();
			begin_floor = start_index;
			end_floor = end_index;
			var index = 0;
			for(;end_index >= start_index;start_index++){
				$("#create-table > thead > tr >th:nth-child("+(5+parseInt(index))+")").after('<th data-floor="'+ start_index +'F">'+ start_index +'F</th>');
				$("#create-table > tbody > tr:not(.sum-col) > td:nth-child("+(5+parseInt(index))+")").after('<td data-floor="'+ start_index +'F"><input type="text" class="floor_input" name="_'+ start_index +'F" /></td>');
				$("#create-table > tbody > tr.sum-col > td:nth-child("+(5+parseInt(index))+")").after('<td data-floor="'+ start_index +'F">0</td>');
				index += 1;
			}

		}else{
			// nếu floor tạo rồi. và bấm tạo lại
			if(end_index < end_floor){
				for(;end_floor > end_index;end_floor--){
					$('td[data-floor="'+end_floor+'F"]').remove();
					$('th[data-floor="'+end_floor+'F"]').remove();
				}
				end_floor = end_index;
			}
			if(end_index > end_floor){
				var index = $("#create-table > thead > tr >th.addition_col").index()+1;
				var temp_index = end_index;
				end_floor++;
				for(;end_index >= end_floor;end_floor++){
					$("#create-table > thead > tr >th:nth-child("+index+")").before('<th data-floor="'+ end_floor +'F">'+ end_floor +'F</th>');
					$("#create-table > tbody > tr:not(.sum-col) > td:nth-child("+index+")").before('<td data-floor="'+ end_floor +'F"><input type="text" class="floor_input" name="_'+ end_floor +'F" /></td>');
					$("#create-table > tbody > tr.sum-col > td:nth-child("+index+")").before('<td data-floor="'+ end_floor +'F">0</td>');
					index += 1;
				}
				end_floor = temp_index;
			}

			if(start_index > begin_floor){
				for(;begin_floor < start_index;begin_floor++){
					$('td[data-floor="'+begin_floor+'F"]').remove();
					$('th[data-floor="'+begin_floor+'F"]').remove();
				}
				begin_floor = start_index;
			}
			if(start_index < begin_floor){
				var index = 0;
				var temp_index = start_index;
				for(;begin_floor > start_index;start_index++){
					$("#create-table > thead > tr >th:nth-child("+(5+parseInt(index))+")").after('<th data-floor="'+ start_index +'F">'+ start_index +'F</th>');
					$("#create-table > tbody > tr:not(.sum-col) > td:nth-child("+(5+parseInt(index))+")").after('<td data-floor="'+ start_index +'F"><input type="text" class="floor_input" name="_'+ start_index +'F" /></td>');
					$("#create-table > tbody > tr.sum-col > td:nth-child("+(5+parseInt(index))+")").after('<td data-floor="'+ start_index +'F">0</td>');
					index += 1;
				}
				begin_floor = temp_index;
			}
			
		}
		$(".temp").each(function(){
			$(this).remove();
		});
		if($("#create-table > thead > tr > th[data-floor$=F]").length == 1){
			$("#create-table > thead > tr > th[data-floor$=F]").css("width","100%");
		}else{
			$("#create-table > thead > tr > th[data-floor$=F]").css("width","auto");
		}
		var size = $("#create-table > tbody > tr:not(.sum-col)").length;
		for(var i=0;i<size;i++){
			var size_detail = $("#create-table > tbody > tr:not(.sum-col)").eq(0).find('td input[name$=F]').length;
			for(j=0;j<size_detail;j++){
				var name = $("#create-table > tbody > tr:not(.sum-col)").eq(i).find('td input[name$=F]').eq(j).attr("name");
				name = name.substring(name.indexOf('_'));
				$("#create-table > tbody > tr:not(.sum-col)").eq(i).find('td input[name$=F]').eq(j).attr("name",i+name);
				var element = $("#create-table > tbody > tr:not(.sum-col)").eq(i).find('.productselect1');
				if(element.val() != null && element.val() != ""){
					var special = element.inputpicker('element',element.val())['special'];
					if(special == 1){
						element.parent().parent().find('input[name$="F"],input[name^="addition"]').each(function(){
							$(this).attr("disabled",true);
						});
						element.parent().parent().find('td').last("1");
					}	
				}
				
			}
		}
		refreshSum();
		refreshCenter();
		return false;
	});

	$('.save-new-order').click(function(){
		is_submit = true;
		if(raiseValidate() == false){
			is_submit = false;
			return false;
		}

		is_submit = false;
		var isValid = true;
		$("#create-table > tbody > tr:not(.sum-col)").each(function(index){
			var picker = $(this).find(".productselect1");
			if(picker.val() == null || picker.val() == "" || picker.inputpicker('element',picker.val()) == null){
				$('.save-temp-order').helloWorld((parseInt(index)+1)+' 行目に商品を入力してください。',null);
				isValid = false;
				return false;
			}
		});
		if(isValid == false){
			return;
		}
		var data = {meta:getMeta(),detail:getDetail()};
		
		if($("#create-table > tbody > tr:not(.sum-col)").length != 0 && data['detail'].length == 0){
			$('.save-new-order').helloWorld('選択した商品に数量を入力してください。',null);
			return false;
		}
		if(data['detail'].length == 0){
			$('.save-new-order').helloWorld('製品を選択してください。',null);
			return false;
		}
		if($("#create-table > tbody > tr:not(.sum-col) >td > input[name$='F']").length == 0){
			$('.save-new-order').helloWorld('製品を選択してください。',null);
			return false;
		}
		data['meta'].status = 1;
		var url = createUrl;
		data['url'] = url;
		$('.save-new-order').helloWorld('注文伝票（新規）を保存します。よろしいですか？',viewUrl,null,{url:url,data:data,error_message:errorAjax});
		/*if(checkValidQuantity(data) == true){
			$('.save-new-order').helloWorld('注文伝票（新規）を保存します。よろしいですか？',viewUrl,null,{url:url,data:data,error_message:errorAjax});
		}*/
		/*$('.save-new-order').helloWorld('注文伝票（新規）を保存します。よろしいですか？',viewUrl,null,{url:url,data:data,error_message:errorAjax});*/
 		
	
	})

    $("#btn_prouduct_set").click(function(){
    	var id = $("#product_set").val();
    	if(id == null || id == ""){
    		return;
    	}
    	$.ajax({
			url:productSetUrl,
			data:{id:id},
			dataType:'json',
			method:'GET',
			success:function(result){
				if(result != null && result.length > 0){
					for(var i=0;i<result.length;i++){
						var specialVal = "";
						if(result[i]['category'] == 2){
							continue;
						}
						var disabled = "";
						if(result[i]['special'] == 1){
							disabled = "disabled";
							specialVal = "1";
						}
						//if($("#create-table > tbody > tr:not(.sum-col) > td select option:selected[value="+result[i]['product_id']+"]").length == 0){
							var row = '<tr><td class="headcol"> <input class="form-control product_id" type="hidden" name="product_id" value="'+result[i]['product_id']+'"  />';
							row += '<input class="form-control productselect1" name="product_item_'+numberRow+'" value="'+result[i]['sale_code']+'"  />';
							row += '</td ><td class="sec-col">'+(result[i]['product_name'] == null?'':result[i]['product_name'])+'</td>';
							row += '<td class="thi-col">'+(result[i]['product_standard'] == null?'':result[i]['product_standard'])+'</td>';
							row += '<td class="for-col">'+(result[i]['product_color'] == null?'':result[i]['product_color'])+'</td>';
							row += '<td class="fif-col">'+(result[i]['product_unit'] == null?'':result[i]['product_package_size'])+'</td>';
							if(begin_floor <= end_floor){
								var temp_begin_floor = begin_floor;
								var temp_end_floor = end_floor;
								for(; temp_end_floor >= temp_begin_floor; temp_end_floor--){
									row +='<td data-floor="'+ temp_end_floor +'F"><input type="text" class="floor_input" '+disabled+' name="'+numberRow+'_'+ temp_end_floor +'F" /></td>';
								}
							}
							if($(".temp").length > 0){
								row += '<td class="temp"></td>';
							}
							row +='<td class="no-sum-col six-col addition"><input type="text" '+disabled+' name="addition'+numberRow+'" /></td>';
							row +='<td class="no-sum-col sev-col">'+specialVal+'</td></tr>';
							$("#create-table > tbody > tr.sum-col").before(row);
							
							$('input[name="product_item_'+numberRow+'"]').inputpicker({
						        width:'400px',
						        url: productSearchUrl,
						        urlParam : {"code":'{{q}}',"customer_id":$("#customer").val(),"base_id":$("#customer_department option:selected").data("base"),"department_id":$("#customer_department").val()},
						        fields:[{"name":"sale_code", "text":"商品ID"}, 
						        		{"name":"name", "text":"商品名"}, 
						        		{"name":"standard", "text":"規格"}, 
						        		{"name":"color", "text":"カラー"},
						        		{"name":"package_size", "text":"結束単位"}],
						        fieldText:'sale_code',
						        fieldValue:'id',
						        filterOpen: true,
						        autoOpen: true,
						        headShow: true,
						        pagination: false,
						        selectMode:"active"
						    }).change();
							//$('input[name="product_item_'+numberRow+'"]').change();
							numberRow = numberRow + 1;

						//}

					}
					refreshCenter();
					/*$(".productselect").selectpicker('refresh');
					var xyz = $('.productselect').selectpicker().ajaxSelectPicker(optionsProduct);*/
				}
			}
		})
    });

	$('.save-temp-order').click(function(){
		is_submit = true;
		if(raiseValidate() == false){
			is_submit = false;
			return false;
		}
		is_submit = false;
		var isValid = true;
		$("#create-table > tbody > tr:not(.sum-col)").each(function(index){
			var picker = $(this).find(".productselect1");
			if(picker.val() == null || picker.val() == "" || picker.inputpicker('element',picker.val()) == null){
				$('.save-temp-order').helloWorld((parseInt(index)+1)+' 行目に商品を入力してください。',null);
				var isValid = true;
				return false;
			}
		});
		if(isValid == false){
			return;
		}
		var data = {meta:getMeta(),detail:getDetail()};
		if($("#create-table > tbody > tr:not(.sum-col)").length != 0 && data['detail'].length == 0){
			$('.save-new-order').helloWorld('選択した商品に数量を入力してください。',null);
			return false;
		}
		if(data['detail'].length == 0){
			$('.save-temp-order').helloWorld('製品を選択してください。',null);
			return false;
		}
		
		data['meta'].status = 2;
		var url = createUrl;
 		data['url'] = url;
		/*if(checkValidQuantity(data) == true){
			$('.save-new-order').helloWorld('注文伝票（新規）を保存します。よろしいですか？',viewUrl,null,{url:url,data:data,error_message:errorAjax});
		}*/
		$('.save-new-order').helloWorld('注文伝票（新規）を保存します。よろしいですか？',viewUrl,null,{url:url,data:data,error_message:errorAjax});
	})

	function raiseValidate(){
		if($('#order_form').valid() == true && $('#order_form').data("validator") != null){
			return true;
		}
		return false;
	}

	window.check_valid_value = function check_valid_value(){
	/*$("#create-table > tbody > tr:not(.sum-col) ").each(function(){
			var size_master = parseFloat($(this).find("td:eq(4)").text());
			$(this).find('input[name$="F"]').each(function(){
				if($(this).val() != "" &&(parseFloat($(this).val()) % size_master) != 0){
					$(this).css("color","red");
				}else{
					$(this).css("color","");
				}
			});
		});*/
	}

	function checkValidQuantity(data){
 		var listProduct = {};
		$("#create-table > tbody > tr:not(.sum-col) ").each(function(){
			var productEle = $(this).find(".productselect1");
			productEle = productEle.inputpicker('element',productEle.val());
			if(productEle == null){
				return true;
			}
			
			var product_id = $(this).find(".productselect1").val();
			var product_name = productEle['name'];
			var is_special = productEle['special'];
			var size_master = parseFloat(productEle['package_size']);
			var total_quantity = parseFloat($(this).find("td").last().text());
			if(is_special == true){
				return true;
			}
			if(listProduct[product_id] == null){
				listProduct[product_id] = {};
				listProduct[product_id].name = product_name;
				listProduct[product_id].size_master = size_master;
				listProduct[product_id].quantity = total_quantity;
			}else{
				listProduct[product_id].quantity += total_quantity;
			}
		});
		
		for(var key in listProduct){
			var item = listProduct[key];
			if(item.size_master !=0 && item.quantity % item.size_master != 0){
				continue;
			}else{
				delete listProduct[key];
			}
		}
		if(listProduct.length == 0){
			return true;
		}
		confirm = null;
		var msg = '商品 ';
		for(var key in listProduct){
			var item = listProduct[key];
			msg += item.name+',';
		}
		msg = msg.substring(0, msg.length - 1);
		msg += ' の発注数は結束単位（';
		for(var key in listProduct){
			var item = listProduct[key];
			msg += item.size_master+',';
		}
		msg = msg.substring(0, msg.length - 1);
		msg += '）の倍数ではないのですが、そのまま発注しましょうか？';
		$('.save-new-order').helloWorld(msg,null,null,{
					cancel_callback_function: 'cancel_click',
					success_callback_function: 'ok_click',
					ok_text: 'OK',
					cancel_text: 'キャンセル',
					not_ajax: true
				});
		wait(msg,data);
		return false;
	}

	function wait(msg,data){
		setTimeout(function(){ 
			if(confirm != null){
				if(confirm == true){
					$('.save-new-order').helloWorld('注文伝票（新規）を保存します。よろしいですか？',viewUrl,null,{url:data['url'],data:data,error_message:errorAjax});
				}
				return;
			}else{
				$('.save-new-order').helloWorld(msg,null,null,{
					cancel_callback_function: 'cancel_click',
					success_callback_function: 'ok_click',
					ok_text: 'OK',
					cancel_text: 'キャンセル',
					not_ajax: true
				});
				wait(msg,data);
				
			}
		}, 1000);  
	}
	window.ok_click = function ok_click(){
		confirm = true;
		valid = true;

	}
	window.cancel_click = function cancel_click(){
		confirm = false;
		valid = false;
	}
	function getMeta(){
		var meta_data = {};
		meta_data.order_no = $("#order_no").val();
		meta_data.order_date = $.datepicker.formatDate("yy-mm-dd", $("#order_date").datepicker('getDate'));
		meta_data.customer_id = $("#customer").val();
		meta_data.customer_name = $("#customer option:selected").text();
		meta_data.note = $("#note").val();
		meta_data.department = $("#customer_department").val();
		meta_data.delivery_expected = $.datepicker.formatDate("yy-mm-dd", $("#delivery_expected").datepicker('getDate'));
		return meta_data;
	}

	function getDetail(){
		var detail_data = [];
		$("#create-table > tbody > tr:not(.sum-col)").each(function(index){
			var picker = $(this).find(".productselect1");
			var product_id = picker.inputpicker('element',picker.val())['id'];
			var name = picker.inputpicker('element',picker.val())['name'];
			var standard = picker.inputpicker('element',picker.val())['standard'];
			var color = picker.inputpicker('element',picker.val())['color'];
			var package_size = picker.inputpicker('element',picker.val())['package_size'];
			var special = picker.inputpicker('element',picker.val())['special'];
			var item ={
				'product_id' : product_id,
				'product_code' : picker.val(),
				'product_name' : name,
				'standard' : $.trim(standard),
				'color' : $.trim(color),
				'package_size' : package_size,
				'special' : special,
				'addition': $(this).find('td.addition').find('input').val(),
			};
			var floor_obj = {};
			var is_empty = true;
			if(begin_floor <= end_floor){
				var temp_begin = begin_floor;
				var temp_end = end_floor;
				for(;temp_begin <= temp_end; temp_begin++){
					var val = $(this).find('input[name$="_'+temp_begin+'F"]').val();
					if(val != ''){
						floor_obj[temp_begin+'F'] = val;
						if(val != 0)
							is_empty = false;
					}
				}
			}
			if(is_empty == true && (item.addition == null || item.addition == '')){
				return;
			}
			var temp = JSON.stringify(floor_obj);
			item['floor'] = temp;
			detail_data.push(item);
		});
		return detail_data;
	}
	$(document).on("change",'#create-table > tbody > tr > td input[name$="F"],input[name^=addition]',function(){
		var parent = $(this).parent().parent();
		var picker = parent.find(".productselect1");
		picker = picker.inputpicker('element',picker.val()) 
		var isSpecial = 0;
		if(picker != null && picker["special"] == 1){
			isSpecial = 1;
		}
		var total_on_row = 0.0;
		var total_on_column = 0.0;
		var total = 0.0;
		var total_addition = 0;
		var val = $(this).val();
		if(!isNaN(parseFloat(val))){
			$(this).val(parseFloat($(this).val()).toFixed(2));
		}else{
			if(val != null && val != ''){
				$(this).val(parseFloat("0.00"));
			}
		}
		
		//row
		if(isSpecial == 0){
			parent.find('input[name$="F"]').each(function(){
			var val = $(this).val();
			if(!isNaN(parseFloat(val))){
					total_on_row += parseFloat(val);
				}
			});
			var val = parent.find('input[name^=addition]').val();
			total_on_row += (isNaN(parseFloat(val))?0:parseFloat(val));
		}
		else{
			total_on_row = 1;
		}
		var subName = $(this).attr('name').substring($(this).attr('name').indexOf("_"));
		//column
		parent.parent().find('input[name$="'+subName+'"]').each(function(){
			var val = $(this).val();
			if(!isNaN(parseFloat(val))){
				total_on_column += parseFloat(val);
			}
		});
		
		parent.parent().find('input[name^="addition"]').each(function(){
			var val = $(this).val();
			if(!isNaN(parseFloat(val))){
				total_addition += parseFloat(val);
			}
		});
		//if(val == ''){
			//parent.find('td').last().text("");
		//}else{
			parent.find('td').last().text(total_on_row.toFixed(2));
		//}
		
		parent.parent().find('tr.sum-col').find('td[data-floor="'+subName.substring(1)+'"]').text(total_on_column.toFixed(2));
		parent.parent().find('tr:not(.sum-col)').each(function(){
			var val = parseFloat($(this).find('td').last().text());
			if(!isNaN(parseFloat(val))){
				total += val;
			}
		});
		parent.parent().find("#sum_addition").text(total_addition.toFixed(2));
		parent.parent().find('tr.sum-col').find('td').last().text(total.toFixed(2));
	});
	$(document).on("change","#create-table > tbody > tr > td select",function(){
		var element = $(this).parent().parent().parent();
		element.find(".selected").removeClass("selected");
		element.addClass("selected");
		var id = $(this).val();
		$.ajax({
			url:productInfoUrl,
			data:{id:id},
			dataType:'json',
			method:'GET',
			success:function(result){
				element.find('td:eq(1)').html(result['name']);
				element.find('td:eq(2)').html(result['standard']);
				element.find('td:eq(3)').html(result['color']);
				element.find('td:eq(4)').html(result['package_size']);
			}
		})
	});

	$(document).on("change","#create-table > tbody > tr > td input.productselect1",function(){
		var element = $(this).parent().parent();
		if($(this).val() == '' || $(this).inputpicker('element',$(this).val()) == null){
			/*element.find('td:eq(0) .product_id').val('');
			element.find('td:eq(1)').html('');
			element.find('td:eq(2)').html('');
			element.find('td:eq(3)').html('');
			element.find('td:eq(4)').html('');*/
			return;
		}
		var product_id = $(this).inputpicker('element',$(this).val())['id'];
		var name = $(this).inputpicker('element',$(this).val())['name'];
		var standard = $(this).inputpicker('element',$(this).val())['standard'];
		var color = $(this).inputpicker('element',$(this).val())['color'];
		var package_size = $(this).inputpicker('element',$(this).val())['package_size'];
		var special = $(this).inputpicker('element',$(this).val())['special'];
		element.find('td:eq(0) .product_id').val(product_id);
		element.find('td:eq(1)').html(name == null?'':name);
		element.find('td:eq(2)').html(standard == null?'':standard);
		element.find('td:eq(3)').html(color == null?'':color);
		element.find('td:eq(4)').html(package_size == null?'':package_size);
		if(special == 1){
			element.find('input[name$="F"],input[name^="addition"]').each(function(){
				$(this).attr("disabled",true);
				$(this).val('').trigger("change");
			});
		}else{
			element.find('input[name$="F"],input[name^="addition"]').each(function(){
				$(this).attr("disabled",false);
			});
		}
		

	}); 

	$(document).on("change","#customer",function(){
		var id = $(this).val(); 
		$("#customer_department").val("");
		if(id == null || id == ''){
			return;
		}
		var customer_previous = $("#customer").data("previous");
		if(customer_previous != id){
			
			if(customer_previous != null && customer_previous != ''){
				var msg = "得意先を変更すると下記選択した商品が全てリセットされます。よろしいでしょうか？";
				$('.save-new-order').helloWorld(msg,null,null,{
						cancel_callback_function: 'cancel_customer_click',
						success_callback_function: 'ok_customer_click',
						ok_text: 'はい',
						cancel_text: 'キャンセル',
						not_ajax: true,
						is_master: true
				});

			}else{
				$("#customer").data("previous",id);
				/*$('.productselect1').inputpicker({
			        width:'400px',
			        url: productSearchUrl,
			        urlParam : {"code":'{{q}}',"customer_id":$("#customer").val(),"base_id":base_id,"department_id":$("#customer_department").val()},
			        fields:[{"name":"sale_code", "text":"商品ID"}, 
			        		{"name":"name", "text":"商品名"}, 
			        		{"name":"standard", "text":"規格"}, 
			        		{"name":"color", "text":"カラー"},
			        		{"name":"package_size", "text":"結束単位"}],
			        fieldText:'sale_code',
			        fieldValue:'id',
			        filterOpen: true,
			        autoOpen: true,
			        headShow: true,
			        pagination: false,   // false: no
			    });*/
				$.ajax({
					url:customerDepartmentUrl,
					data:{customer_id:id},
					dataType:'json',
					method:'GET',
					success:function(result){
						var option = '<option value=""></option>';
						if(result != null){
							for(var i=0;i<result.length;i++){
								/*if(valDepartment != "" && valDepartment == result[i]['department_id'])
									option += '<option selected value="'+result[i]['department_id']+'">'+result[i]['department']+'</option>';
								else{
									var selected = "";
									if(is_customer == 1 && i == 0){
										selected = 'selected';
										$("#customer_department").data("previous",result[i]['department_id']);
									}
									option += '<option '+selected+' value="'+result[i]['department_id']+'">'+result[i]['department']+'</option>';
								}*/

								var selected = "";
								if(i == 0){
									selected = 'selected';
									$("#customer_department").data("previous",result[i]['department_id']);
								}
								option += '<option '+selected+' value="'+result[i]['department_id']+'" data-base="'+result[i]['base_code']+'">'+result[i]['department']+'</option>';

							}
						}
						$("#customer_department").html(option);
						//if(is_customer == 1){
								$('.productselect1').inputpicker({
							        width:'400px',
							        url: productSearchUrl,
							        urlParam : {"code":'{{q}}',"customer_id":$("#customer").val(),"base_id":$("#customer_department option:selected").data("base"),"department_id":$("#customer_department").val()},
							        fields:[{"name":"sale_code", "text":"商品ID"}, 
							        		{"name":"name", "text":"商品名"}, 
							        		{"name":"standard", "text":"規格"}, 
							        		{"name":"color", "text":"カラー"},
							        		{"name":"package_size", "text":"結束単位"}],
							        fieldText:'sale_code',
							        fieldValue:'id',
							        filterOpen: true,
							        autoOpen: true,
							        headShow: true,
							        pagination: false,   // false: no
							    });

						//}

					}
				});
				$.ajax({
					url:customerProductSetUrl,
					data:{customer_id:id},
					dataType:'json',
					method:'GET',
					success:function(result){
						var option = '<option value=""></option>';
						if(result != null){
							for(var i=0;i<result.length;i++){
								option += '<option value="'+result[i]['id']+'">'+result[i]['name']+'</option>';
							}
						}
						$("#product_set").html(option);
					}
				});

			}
		}
		
		
		
	});

	window.ok_customer_click = function ok_customer_click(){
		$("#create-table > tbody > tr:not(.sum-col) ").each(function(){
			$(this).remove();
		})
		
		var id = $("#customer").val();
		var valDepartment = $("#customer_department").val();
		$.ajax({
				url:customerDepartmentUrl,
				data:{customer_id:id},
				dataType:'json',
				method:'GET',
				success:function(result){
					var option = '<option value=""></option>';
					if(result != null){
						for(var i=0;i<result.length;i++){
							var selected = "";
								if(i == 0){
									selected = 'selected';
									$("#customer_department").data("previous",result[i]['department_id']);
								}
								option += '<option '+selected+' value="'+result[i]['department_id']+'" data-base="'+result[i]['base_code']+'">'+result[i]['department']+'</option>';
						}
					}
					
					$("#customer_department").html(option);
					addNewRow();
					refreshSum();
				}
			});
			$.ajax({
				url:customerProductSetUrl,
				data:{customer_id:id},
				dataType:'json',
				method:'GET',
				success:function(result){
					var option = '<option value=""></option>';
					if(result != null){
						for(var i=0;i<result.length;i++){
							option += '<option value="'+result[i]['id']+'">'+result[i]['name']+'</option>';
						}
					}
					$("#product_set").html(option);
				}
			});
		$("#customer").data("previous",id);
	}
	window.cancel_customer_click = function cancel_customer_click(){
		var customer_previous = $("#customer").data("previous");
		$("#customer").val(customer_previous).change();
	}

	var previous_base;
	$("#customer_department").on('focus', function () {
        // Store the current value on focus and on change
        previous_base = $("#customer_department option:selected").data("base");
    }).change(function(){
		//if(is_customer == 1){
			var id = $(this).val();
			var department_previous = $("#customer_department").data("previous");
			var data_base = $("#customer_department option:selected").data("base");
			if(id == null || id == ''){
				return;
			}

			if(department_previous != id && previous_base != data_base){
				if(department_previous != null && department_previous != ''){
					var msg = "部署を変更すると下記選択した商品が全てリセットされます。よろしいでしょうか？";
					$('.save-new-order').helloWorld(msg,null,null,{
							cancel_callback_function: 'cancel_department_click',
							success_callback_function: 'ok_department_click',
							ok_text: 'Ok',
							cancel_text: 'キャンセル',
							not_ajax: true,
							is_master: true
					});

				}
			}
		//}

	})

	window.ok_department_click = function ok_department_click(){
		$("#create-table > tbody > tr:not(.sum-col) ").each(function(){
			$(this).remove();
		})
		addNewRow();
		refreshSum();
		var id = $("#customer_department").val();
		$("#customer_department").data("previous",id);
	}
	window.cancel_department_click = function cancel_department_click(){
		var customer_department = $("#customer_department").data("previous");
		$("#customer_department").val(customer_department).change();
	}
	function addNewRow(){

		var new_row = '<tr><td class="headcol"><input class="form-control product_id" type="hidden" name="product_id" value=""  />';
		new_row += '<input class="form-control productselect1" name="product_item_'+numberRow+'" value=""  />';
		new_row += '</td ><td class="no-sum-col sec-col"></td><td class="no-sum-col thi-col"></td><td class="no-sum-col for-col"></td><td class="fif-col"></td>';
		if(begin_floor <= end_floor){
			var temp_begin_floor = begin_floor;
			var temp_end_floor = end_floor;

			for(; temp_end_floor >= temp_begin_floor; temp_begin_floor++){
				new_row +='<td data-floor="'+ temp_begin_floor +'F"><input type="text" class="floor_input" name="'+numberRow+'_'+ temp_begin_floor +'F" /></td>';
			}
		}else{
			new_row += '<td class="temp"></td>';
		}
		
		new_row +='<td class="no-sum-col six-col addition"><input type="text" class="input_addition" name="addition'+numberRow+'" /></td><td class="no-sum-col sev-col">0.00</td></tr>'
		
		var selected_row = $("#create-table > tbody > tr.selected").length;
		if(selected_row > 0) {
			$("#create-table > tbody > tr.selected").after(new_row);
		} else {
			$("#create-table > tbody > tr.sum-col").before(new_row);
		}
		
		/*$(".productselect").selectpicker('refresh');
		var xyz = $('.productselect').selectpicker({title:'Choose Product'}).ajaxSelectPicker(optionsProduct);*/
		//xyz.trigger('change').data('AjaxBootstrapSelect').list.cache = {};
		$('input[name="product_item_'+numberRow+'"]').inputpicker({
	        width:'400px',
	        url: productSearchUrl,
	        urlParam : {"code":'{{q}}',"customer_id":$("#customer").val(),"base_id":$("#customer_department option:selected").data("base"),"department_id":$("#customer_department").val()},
	        fields:[{"name":"sale_code", "text":"商品ID"}, 
	        		{"name":"name", "text":"商品名"}, 
	        		{"name":"standard", "text":"規格"}, 
	        		{"name":"color", "text":"カラー"},
	        		{"name":"package_size", "text":"結束単位"}],
	        fieldText:'sale_code',
	        fieldValue:'id',
	        filterOpen: true,
	        autoOpen: true,
	        headShow: true,
	        pagination: false,   // false: no
	    });
	    numberRow = numberRow + 1;
	    refreshCenter();
	}
/*	$('#customer_department').change(function(){
		var val = $(this).val();
		var valCus = $('#customer').val();
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
		})
	});*/
	if(is_customer == 0){
			$('.productselect1').inputpicker({
		        width:'400px',
		        url: productSearchUrl,
		        urlParam : {"code":'{{q}}',"customer_id":$("#customer").val(),"base_id":$("#customer_department option:selected").data("base"),"department_id":$("#customer_department").val()},
		        fields:[{"name":"sale_code", "text":"商品ID"}, 
		        		{"name":"name", "text":"商品名"}, 
		        		{"name":"standard", "text":"規格"}, 
		        		{"name":"color", "text":"カラー"},
		        		{"name":"package_size", "text":"結束単位"}],
		        fieldText:'sale_code',
		        fieldValue:'id',
		        filterOpen: true,
		        autoOpen: true,
		        headShow: true,
		        pagination: false,   // false: no
		    });
	}

    /*var optionsProduct = {
        ajax          : {
            url     : productSearchUrl,
            type    : 'GET',
            dataType: 'json',
            // Use "{{{q}}}" as a placeholder and Ajax Bootstrap Select will
            // automatically replace it with the value of the search query.
            data    : { code: '{{{q}}}',start_index:0,number:10}
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
                        text : data[i].sale_code,
                        value: data[i].id,
                        disabled: false
                        data : {
                            subtext: data[i].code
                        }
                    }));
                }
            }
            return array;
        }
    };

    var xyz = $('.productselect').selectpicker({title:'Choose Product'}).ajaxSelectPicker(optionsProduct);
    xyz.trigger('change').data('AjaxBootstrapSelect').list.cache = {};*/

    var optionsCustomer = {
        ajax          : {
            url     : customerSearchUrl,
            type    : 'GET',
            dataType: 'json',
            // Use "{{{q}}}" as a placeholder and Ajax Bootstrap Select will
            // automatically replace it with the value of the search query.
            data    : { name: '{{{q}}}',cus_type:1,start_index:0,number:20}
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
                        /*data : {
                            subtext: data[i].code
                        }*/
                    }));
                }
            }
            return array;
        }
    };
    xyz = $('#customer').selectpicker({title:'Choose Customer'}).ajaxSelectPicker(optionsCustomer);
    xyz.trigger('change').data('AjaxBootstrapSelect').list.cache = {};

	$("#order_form").validate({
            rules : {
            	customer:{
            		required:true,
            	},
            	delivery_expected:{
            		required:true,
            		check_logic:true,
            	},
            	order_date:{
            		required:true
            	},
            	customer_department:{
            		required:true
            	},
            },
            tooltip_options: {  // <- totally invalid option
		        customer: {
		            placement: 'bottom',html:true
		        },
		        delivery_expected: {
		            placement: 'bottom'
		        },
		        order_date: {
		            placement: 'top'
		        },
            	customer_department:{
            		placement: 'top'
            	}
            	
			},
			invalidHandler: function(form, validator) {
				if (!validator.numberOfInvalids())
					return;

				$('html, body').animate({
					scrollTop: $(validator.errorList[0].element).offset().top - 50
				}, 800);
			}
    });

	$.validator.addMethod("check_logic",function(value, element){
			//get all tr but current row
			if(is_submit == false){
				return true;
			}
			var temp1 = $.datepicker.formatDate("yy-mm-dd", $("#delivery_expected").datepicker('getDate'));
			var temp2 = $.datepicker.formatDate("yy-mm-dd", $("#order_date").datepicker('getDate'));
			var date1 = new Date(temp1);
			var date2 = new Date(temp2);
			if(date1 < date2){
				return false;
			}
			return true;
		},"発注日以降で日付を入力してください。");

     jQuery.validator.addClassRules({
            floor_input : {
                //required : true,
                //number : true,
                //min : 1
            },
            input_addition:{
            	number:true
            }/*,
            productselect1:{
            		required:true,
                	//check_existed:true
            },*/
        });
     $.validator.addMethod("check_existed",function(value, element){
			//get all tr but current row
			var other_tr = $(element).parent().parent().parent().siblings();
			var flag = true;
            other_tr.each(function(){

                if($(this).find("select.productselect").val() == value )
                {
                    flag = false;
                    return false;
                }
            });
            return flag;
		},"This product are already chosen.");
     $("#customer").parent().find(".dropdown-menu").css({'background-color': '#ffffff','z-index':'99999'});
     function refreshCenter(){
     	$("#create-table > tbody > tr.sum-col >td").each(function(data){
     		//$(this).css("line-height","2.5");
     	})
     	$("#create-table > tbody > tr:not(.sum-col)").each(function(data){

     		/*$(this).find("td").eq(2).css("line-height","2.5");
     		$(this).find("td").eq(3).css("line-height","2.5");
     		$(this).find("td").eq(4).css("line-height","2.5");
     		$(this).find("td").last().css("line-height","2.5");*/

     	})
     }
     function refreshSum(){
     	var temp_begin_floor = begin_floor;
		var temp_end_floor = end_floor;
		for(; temp_end_floor >= temp_begin_floor; temp_end_floor--){
			$("#create-table > tbody > tr:not(.sum-col)").find("input[name$="+temp_end_floor+"F]").change();
		}
     	$('#create-table > tbody > tr > td input[name^=addition]').eq(0).change();
     }
     refreshCenter();
})

//$('tr,td,th').css('height','34px');
//$('th').css('height','22px');
/*$('.small').on('click','tr',function(){

		console.log('abc');
})
$('.small td').click(function(){
	console.log('abc');
})
$( "input" ).focus(function() {
  alert( "Handler for .focus() called." );
});*/




$(document).on("change","#create-table > tbody > tr > td input.productselect1",function(){
	var name = $(this).inputpicker('element',$(this).val())['name'];	
	console.log(name);
	var element = $(this).parent().parent();
	element.find('.sec-col').css('height','auto');
	var t = element.find('td:eq(1)').html(name == null?'':name).height();
	if(t > 30){
		element.css('height',t+2+'px');
		element.find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col,.sec-col').css('height',t+1+'px');
		element.find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col').css('line-height',t+'px');
	}
	else
	{ 
		element.css('height','32px');
		element.find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col,.sec-col').css('height','32px');
		element.find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col,.sec-col').css('line-height','32px');
	}
	}); 

	$(document).on("keyup","#create-table > tbody > tr input",function(e){
		if (e.which === 13) {
			$('#insert').click();
		}
	});

	

	


