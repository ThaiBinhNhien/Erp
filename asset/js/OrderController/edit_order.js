$(document).ready(function(){
	var first_time = true;
	var is_submit = false;
	// jQuery('.mydatepicker').datepicker({
	// 	changeMonth: true,
 //        changeYear: true,
	// 	dateFormat: 'yy年mm月dd日 (DD)',
	// 	dayNames: [ '日','月','火','水','水','金','土' ]
	// }).attr('readonly','readonly');
	// $("#order_date").datepicker("setDate",order_date);
	// $("#delivery_date").datepicker("setDate",delivery_date);

	$('#order_date').datepicker({
		dateFormat: 'yy年mm月dd日 (DD)',
        dayNames: ['日', '月', '火', '水', '水', '金', '土'],
		changeMonth: true,
        changeYear: true,
        minDate: order_date,
        onSelect: function () {
            var dt_to = $('#delivery_date');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');
	$('#order_date').datepicker('setDate', order_date);

	$('#delivery_date').datepicker({
		dateFormat: 'yy年mm月dd日 (DD)',
        dayNames: ['日', '月', '火', '水', '水', '金', '土'],
		changeMonth: true,
        changeYear: true,
        minDate: order_date,
	}).attr('readonly','readonly');
	$('#delivery_date').datepicker('setDate', delivery_date);


	$(document).on("click","#edit_order  > tbody > tr:not(.sum-col)",function(){
		$(this).parent().find("tr.selected").removeClass("selected");
		$(this).addClass("selected");
	});
	$('#remove').click(function(){
		$('.selected').remove();
		if($('#edit_order > tbody > tr > td input[name^=addition]').length == 0){
			$('tr.sum-col').find('td').last().text("0.00");
			$("#sum_addition").text("0.00");
		}
		if($("#edit_order > tbody > tr:not(.sum-col)").length == 0){
			addNewRow();
		}
		refreshSum();
		return false;
	})
	$('#insert').click(function(){
		addNewRow();
		/*$(".productselect").selectpicker('refresh');
		var xyz = $('.productselect').selectpicker({title:'Choose Product'}).ajaxSelectPicker(optionsProduct);*/
		//xyz.trigger('change').data('AjaxBootstrapSelect').list.cache = {};
		return false;
	})
	$(document).on("change","#edit_order > tbody > tr > td select",function(){
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
	$(document).on("change",'#edit_order  > tbody > tr > td input[name$="F"],input[name^=addition]',function(){
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
			if(val != null && val != '')
				$(this).val(parseFloat("0.00"));
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
		}else{
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
		parent.find('td').last().text(total_on_row.toFixed(2));
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
	$(document).on("change","#customer",function(){
		if(first_time == true)
			return;
		var id = $(this).val();
		if(id == null || id == ''){
			return;
		}
		$.ajax({
			url:customerDepartmentUrl,
			data:{customer_id:id},
			dataType:'json',
			method:'GET',
			success:function(result){
				var option = '<option value=""></option>';
				if(result != null){
					for(var i=0;i<result.length;i++){
						option += '<option value="'+result[i]['department_code']+'">'+result[i]['department']+'</option>';
					}
				}
				$("#customer_department").html(option);
			}
		}); 
		
	});
	$("#customer_department").change(function(){
		if(is_customer == 1){
			var id = $(this).val();
			var department_previous = $("#customer_department").data("previous");
			if(id == null || id == ''){
				return;
			}
			if(department_previous != id){
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
		}

	})

	window.ok_department_click = function ok_department_click(){
		$("#edit_order > tbody > tr:not(.sum-col) ").each(function(){
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
	
	$(document).on("change","#edit_order > tbody > tr > td input.productselect1",function(){
		var element = $(this).parent().parent();
		if($(this).val() == ''){
			return;
		}
		var name = $(this).inputpicker('element',$(this).val())['name'];
		var standard = $(this).inputpicker('element',$(this).val())['standard'];
		var color = $(this).inputpicker('element',$(this).val())['color'];
		var package_size = $(this).inputpicker('element',$(this).val())['package_size'];
		var special = $(this).inputpicker('element',$(this).val())['special'];
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

	function addNewRow(){
		var new_row = '<tr class="new_row"><td class="headcol"><input class="form-control product_id" type="hidden" name="product_id" value=""  />';
		new_row += '<input class="form-control productselect1" name="product_item_'+numberRow+'" value=""  />';
		new_row += '</td ><td class="sec-col no-sum-col"></td><td class="thi-col no-sum-col"></td><td class="for-col no-sum-col"></td><td class="fif-col"></td>';
		var index = $("#edit_order > tbody > tr.sum-col").length +1;
		for(var i=0;i<floor_array.length;i++){
			new_row +='<td data-floor="'+ floor_array[i]['floor'] +'"><input type="text" class="floor_input"  name="'+numberRow+'_'+ floor_array[i]['floor'] +'" /></td>';
		}
		new_row +='<td class="six-col addition"><input type="text" name="addition'+numberRow+'" /></td><td class="sev-col no-sum-col"></td></tr>'
		
		var selected_row = $("#edit_order > tbody > tr.selected").length;
		if(selected_row > 0) {
			$("#edit_order > tbody > tr.selected").after(new_row);
		} else {
			$("#edit_order > tbody > tr.sum-col").before(new_row);
		}

		$('.new_row').find('td').css('height','31px');
		$('input[name="product_item_'+numberRow+'"]').inputpicker({
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
	    });
	    numberRow = numberRow + 1;
	    refreshCenter();
	}
	$('.productselect1').inputpicker({
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
    });
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
            data    : { name: '{{{q}}}',start_index:0,number:10}
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

    function getMeta(){
		var meta_data = {};
		meta_data.order_date = $.datepicker.formatDate("yy-mm-dd", $("#order_date").datepicker('getDate'));
		meta_data.customer_id = $("#customer").val();
		meta_data.customer_name = $("#customer option:selected").text();
		meta_data.note = $("#note").val();
		meta_data.date_update = date_update;
		meta_data.department = $("#customer_department").val();
		meta_data.delivery_date = $.datepicker.formatDate("yy-mm-dd", $("#delivery_date").datepicker('getDate'));
		return meta_data;
	}

	function getDetail(){
		var detail_data = [];
		$("#edit_order > tbody > tr:not(.sum-col)").each(function(index){
			var picker = $(this).find(".productselect1");
			var product_id = picker.inputpicker('element',picker.val())['id'];
			var name = picker.inputpicker('element',picker.val())['name'];
			var standard = picker.inputpicker('element',picker.val())['standard'];
			var color = picker.inputpicker('element',picker.val())['color'];
			var package_size = picker.inputpicker('element',picker.val())['package_size'];
			var special = picker.inputpicker('element',picker.val())['special'];
			var item ={
				'id'		 : $(this).find('td:eq(0)').find('.sp_id').val(),
				'product_id' : product_id,
				'product_code' : picker.val(),
				'product_name' : name,
				'standard' : $.trim(standard),
				'color' : $.trim(color),
				'package_size' : $.trim(package_size),
				'special' : special,
				'addition': $(this).find('td.addition').find('input').val(),
			};
			var floor_obj = {};
			var is_empty = true;
			for(var i=0;i<floor_array.length;i++){
				var val = $(this).find('input[name$="_'+floor_array[i]['floor']+'"]').val();
					if(val != ''){
						floor_obj[floor_array[i]['floor']] = val;
						if(val != 0)
							is_empty = false;
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
	$('#save_order').click(function(){
		is_submit = true;
		if(raiseValidate() == false){
			is_submit = false;
			return false;
		}
		is_submit = false;
		var isValid = true;
		$("#edit_order > tbody > tr:not(.sum-col)").each(function(index){
			var picker = $(this).find(".productselect1");
			if(picker.val() == null || picker.val() == "" || picker.inputpicker('element',picker.val()) == null){
				$('.edit_order').helloWorld((parseInt(index)+1)+' 行目に商品を入力してください。',null);
				isValid = false;
				return false;
			}
		});
		if(isValid == false){
			return;
		}
		var data = {meta:getMeta(),detail:getDetail()};
		if($("#edit_order > tbody > tr:not(.sum-col)").length != 0 && data['detail'].length == 0){
			$('.save-new-order').helloWorld('選択した商品に数量を入力してください。',null);
			return false;
		}
		if(data['detail'].length == 0){
			$('.edit_order').helloWorld('製品を選択してください。',null);
			return false;
		}
		if($("#edit_order > tbody > tr:not(.sum-col) >td > input[name$='F']").length == 0){
			$('.edit_order').helloWorld('製品を選択してください。',null);
			return false;
		}
		var data = {id:master_id,meta:getMeta(),detail:getDetail()};
		var url = editUrl;
		data['url'] = url;
		/*if(checkValidQuantity(data) == true){
			$('.save-new-order').helloWorld('注文伝票（編集）を保存します。よろしいですか？',viewUrl,null,{url:url,data:data,error_message:errorAjax});
		}*/
		$('.save-new-order').helloWorld('注文伝票（編集）を保存します。よろしいですか？',viewUrl,null,{url:url,data:data,error_message:errorAjax});
	})
	function raiseValidate(){
		if($('#order_form').valid() && $('#order_form').data("validator")){
			return true;
		}
		return false;
	}
	window.check_valid_value = function check_valid_value(){
	
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
		$('#save_order').helloWorld(msg,null,null,{
					cancel_callback_function: 'cancel_click',
					success_callback_function: 'ok_click',
					ok_text: '保存',
					cancel_text: '修正',
					not_ajax: true
				});
		wait(msg,data);
		return false;
	}

	function wait(msg,data){
		setTimeout(function(){ 
			if(confirm != null){
				if(confirm == true){
					$('#save_order').helloWorld('注文伝票（編集）を保存します。よろしいですか？',viewUrl,null,{url:data['url'],data:data,error_message:errorAjax});
				}
				return;
			}else{
				$('#save_order').helloWorld(msg,null,null,{
					cancel_callback_function: 'cancel_click',
					success_callback_function: 'ok_click',
					ok_text: '保存',
					cancel_text: '修正',
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

	$("#order_form").validate({
            rules : {
            	customer:{
            		required:true,
            	},
            	delivery_date:{
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
		        delivery_date: {
		            placement: 'bottom'
		        },
		        order_date: {
		            placement: 'top'
		        },
            	customer_department:{
            		placement: 'top'
            	},
            	
			},
			invalidHandler: function(form, validator) {
				if (!validator.numberOfInvalids())
					  return;
	  
				$('html, body').animate({
					  scrollTop: $(validator.errorList[0].element).offset().top - 50
				}, 800);
		  }
    });

     jQuery.validator.addClassRules({
            floor_input : {
                //required : true,
                //number : true,
                //min:1
            },
            input_addition:{
            	number:true
            },
            productselect:{
            		required:true,
                	//check_existed:true
            },
        });

     $.validator.addMethod("check_logic",function(value, element){
			//get all tr but current row
			if(is_submit == false){
				return true;
			}
			var temp1 = $.datepicker.formatDate("yy-mm-dd", $("#delivery_date").datepicker('getDate'));
			var temp2 = $.datepicker.formatDate("yy-mm-dd", $("#order_date").datepicker('getDate'));
			var date1 = new Date(temp1);
			var date2 = new Date(temp2);
			if(date1 < date2){
				return false;
			}
			return true;
		},"発注日以降で日付を入力してください。");
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
     var first_time = false;
     $("#customer").parent().find(".dropdown-menu").css({'background-color': '#ffffff','z-index':'99999'});
     function refreshCenter(){
     	$("#edit_order > tbody > tr.sum-col >td").each(function(data){
     		//$(this).css("line-height","2.5");
     	})
     	$("#edit_order > tbody > tr:not(.sum-col)").each(function(data){

     		/*$(this).find("td").eq(2).css("line-height","2.5");
     		$(this).find("td").eq(3).css("line-height","2.5");
     		$(this).find("td").eq(4).css("line-height","2.5");
     		$(this).find("td").last().css("line-height","2.5");*/

     	})
     }
     function refreshSum(){
     	for(var i=0;i<floor_array.length;i++){
			$("#edit_order > tbody > tr:not(.sum-col)").find("input[name$=F]").change();
		}
		$('#edit_order > tbody > tr > td input[name^=addition]').eq(0).change();
     }
     refreshCenter();
})

$( "tbody .sec-col" ).each(function( index ) {
  var cell_height = $( this ).height() ;
  if(cell_height > 30)
	{   
	  $(this).css('height',cell_height-1+'px');
	  $(this).closest('tr').find('td').css('height',cell_height-1+'px');
	  $(this).closest('tr').css('height',cell_height+'px');
	  $(this).closest('tr').find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col').css('line-height',cell_height+'px');
	}
  else {
    $(this).closest('tr').css('height','31px');
    $(this).css('line-height','2.5');
    $(this).closest('tr').find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col').css('line-height','2.5');
    $(this).closest('tr').find('td').css('height',30+'px');
    $(this).closest('tr').find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col,.sec-col').css('margin-top','1px !important');
  }
});
	$(document).on("change","#edit_order > tbody > tr > td input.productselect1",function(){
		var name = $(this).inputpicker('element',$(this).val())['name'];	
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
		element.find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col,.sec-col').css({'height':'32px','line-height':'32px'});
		//element.find('.headcol,.thi-col,.for-col,.fif-col,.six-col,.sev-col,.sec-col').css('line-height','32px');
	}
}); 

$(document).on("keyup","#edit_order > tbody > tr input",function(e){
	if (e.which === 13) {
		$('#insert').click();
	}
});