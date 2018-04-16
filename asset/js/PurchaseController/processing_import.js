var accumulation_first = null;//lũy kế nhập kho đầu
var accumulation_last = null;//lũy kế nhập kho sửa lại
var accumulation_plus = null;//số lượng lũy kế nhập kho cộng thêm
var check_has_import = 1; //kiểm tra đã nhập kho xong hết chưa
$(document).ready(function(){
	accumulation_first = get_accumulation();
	console.log(accumulation_first);
	$.each(document.getElementsByClassName('number_order'),function(id,val){
		var accumulation = parseInt($('.accumulation').eq(id).text());//lũy kế nhập kho
		var price_unit = parseFloat($('.price_unit').eq(id).text());
		var price = price_unit*accumulation;
		$('.price').eq(id).text(price);
	});
	update();
});

$('#copy').click(function(){
	$.each(document.getElementsByClassName('number_order'),function(id,val){
		var number_order = $('.number_order').eq(id).text();
		$('.number_purchase').eq(id).val(number_order);
		var price_unit = parseFloat($('.price_unit').eq(id).text());
		var back_number = $('.back_number').eq(id).val();
		var price = price_unit*number_order;
		$('.price').eq(id).text(price);
		$('.accumulation').eq(id).text(number_order-back_number);
	});
	update();
});

$('tbody').on('keyup mouseup','.number_purchase',function(){
	var tr = $(this).parent().parent();
	var number_order = parseFloat(tr.find('.number_order').text());
	var back_number = tr.find('.back_number').val();
	var accumulation = this.value - back_number;
	tr.find('.accumulation').text(accumulation);
	var price_unit = parseFloat(tr.find('.price_unit').text());
	var price = this.value*price_unit;
	tr.find('.price').text(price);
	update();
});
$('tbody').on('keyup mouseup','.back_number',function(){
	var tr = $(this).parent().parent();
	var number_purchase = tr.find('.number_purchase').val();
	var accumulation = number_purchase - this.value;
	tr.find('.accumulation').text(accumulation);
	var price_unit = parseFloat(tr.find('.price_unit').text());
	var price = accumulation*price_unit;
	tr.find('.price').text(price);
	update();
});

function update() {
	var sum_price = 0;
	$.each(document.getElementsByClassName('number_order'),function(id,val){
		var price = parseFloat($('.price').eq(id).text());
		sum_price += price;
	});
	$('.sum_price').text(sum_price);
	var discount = parseFloat($('.discount').text());
	var total_price = sum_price - sum_price*discount/100;
	$('.total_price').text(total_price);
}

function get_accumulation() {
	var accumulation = '';
	$.each(document.getElementsByClassName('accumulation'),function(id,val){
		if(id==0) accumulation += $('.accumulation').eq(id).text();
		else accumulation += '|'+$('.accumulation').eq(id).text();

	});
	return accumulation;
}

//lấy danh sách số lượng sẽ cộng vào kho
function get_amount_warehouse(first,last) {
	var accumulation_plus = '';
	var accumulation_first = first.split('|');
	var accumulation_last = last.split('|');
	for(var i in accumulation_first){
		if(i==0) accumulation_plus += String(parseInt(accumulation_last[i])-parseInt(accumulation_first[i]));
		else accumulation_plus += '|'+String(parseInt(accumulation_last[i])-parseInt(accumulation_first[i]))
	}
	console.log("accumulation plus: "+accumulation_plus);
	return accumulation_plus;
}

/*-----------------------Begin validation  purchasing number------------------------*/
var valid 	 = false;
var required = false;
var return_number_required = true;
var return_number_valid = false;
$('.processing-table').on('keyup blur','.number_purchase',function(){
	var number_purchase = parseInt($(this).val());
	var number_order 	= parseInt($(this).parent().prev().text());
	$(this).parent().find('.popup').remove();
	if (number_purchase < 0 || !($(this).val()>=0)){
		$(this).closest('td').css('position','relative');
		$(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
		$('.save-purchase').addClass('error');
		$(this).focus();
		return valid ;
	}
	else if(number_purchase > number_order){
		$(this).closest('td').css('position','relative');
		$(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">発注量以下で入庫量を入力してください。</span></div>');
		$('.save-purchase').addClass('error');
		$(this).focus();
		return valid ;
	} 
	else {
		$(this).parent().find('.popup').remove();
		$('.save-purchase').removeClass('error');
		return valid = true;
	}
})

$('.processing-table').on('keyup blur','.back_number',function(){
	var number_purchase = parseInt($(this).closest('tr').find('.number_purchase').val());
	var back_number 	= parseInt($(this).val());
	if(back_number < 0 || isNaN(back_number)){
		$(this).parent().find('.popup').remove();
		$(this).closest('td').css('position','relative');
		$(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
		$(this).focus();
		$('.save-purchase').addClass('error');
		return return_number_valid ;
	}
	else if(back_number > number_purchase ){
		$(this).parent().find('.popup').remove();
		$(this).closest('td').css('position','relative');
		$(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">返品数は入庫量以下の数値で入力してください。</span></div>');
		$(this).focus();
		$('.save-purchase').addClass('error');
		return return_number_valid ;
	} else {
		$(this).parent().find('.popup').remove();
		$('.save-purchase').removeClass('error');
		return return_number_valid = true;

	}
	//console.log(number_purchase);
	//console.log(back_number);
})
/*-----------------------End validation  purchasing number------------------------*/

$('.save-purchase').click(function(){
	/*-----------------------Begin validation purchasing number, returning number------------------------*/
	//-> Don't insert record when purchasing number <= 0
	$( ".number_purchase" ).each(function() {

  		var number_purchase = parseInt($(this).val());
  		if(number_purchase < 0 || !(number_purchase>=0))	{
			$(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
			$(this).focus();
			return required ;
		} else {
			return required = true;
		}
	});
	if($('.first-row a').hasClass('error')){
		return return_number_required;
	}
	if( !required || !return_number_required){
		return false;
	}
	/*-----------------------End validation purchasing number , returning number------------------------*/
	/*$( ".back_number" ).each(function() {
  		var back_number = parseInt($(this).val());
  		if (back_number > 0 )
  		{	
  			if( !return_number_valid ){
  			$(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">Invalid number</span></div>');
			$(this).focus();
			return return_number_required ;
  			}	
  		}else if(back_number < 0 ){
			$(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">Invalid number</span></div>');
			$(this).focus();
			return return_number_required ;
		} else {
			return return_number_required = true;
		}
	});*/

	

	accumulation_last = get_accumulation();
	accumulation_plus = get_amount_warehouse(accumulation_first,accumulation_last);
	var order_id = $('#order_id').text();
	var has_import = $('#has_import').val();//đã nhập kho hay chưa
	var supplier_id = $('#supplier_id').val();
	var order_date = $('#order_date').text().replace('/','-');
	var stock_id = $('#stock_id').val();
	var content_id = $('#content_id').val();
	var sales_des_id = $('#sales_des_id').val();
	var update_date = $('#update_date').val();
	var product_id = '';
	var product_name = '';
	var product_amount = '';
	var product_accumulation = '';
	var back_number = '';
	var product_price = '';
	var product_date = '';//ngày giao hàng của sản phẩm
	$.each(document.getElementsByClassName('product_id'),function(id,val){
		if(id==0){
			product_id += $('.product_id').eq(id).val();
			product_name += $('.product_name').eq(id).text();
			product_amount += $('.number_purchase').eq(id).val();
			back_number += $('.back_number').eq(id).val();
			product_price += $('.price_unit').eq(id).text();
			product_date += $('.product_date').eq(id).val();
			product_accumulation += $('.accumulation').eq(id).text();
		}else{
			product_id += '|'+$('.product_id').eq(id).val();
			product_name += '|'+$('.product_name').eq(id).text();
			product_amount += '|'+$('.number_purchase').eq(id).val();
			back_number += '|'+$('.back_number').eq(id).val();
			product_price += '|'+$('.price_unit').eq(id).text();
			product_date += '|'+$('.product_date').eq(id).val();
			product_accumulation += '|'+$('.accumulation').eq(id).text();
		}
		var number_order = parseInt($('.number_order').eq(id).text());
		var number_import = $('.number_purchase').eq(id).val();
		if(number_order != number_import) check_has_import = 0;
	});

	console.log("back_number: "+back_number);

	console.log('product_name:'+product_name);

	$(this).helloWorld('入庫日は正しいですか？',base_url+'purchase',null,{
        url: base_url+'purchase/ajax_save_processing_import',
        data : {
            order_id 		: order_id,
            has_import 		: has_import,
            content_id 		: content_id,
            sales_des_id 	: sales_des_id,
			supplier_id 	: supplier_id,
			order_date 		: order_date,
			stock_id 		: stock_id,
			update_date		: update_date,
			product_id 		: product_id,
			product_name 	: product_name,
			product_amount 	: product_amount,
			product_accumulation : product_accumulation,
			back_number 	: back_number,
			product_price 	: product_price,
			product_date 	: product_date,
			amount_plus 	: accumulation_plus,
			check_has_import : check_has_import
        },
        error_message: '出庫伝票（新規）を保存します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
    /*$.post(base_url+'purchase/ajax_save_processing_import',
    {
    		order_id 		: order_id,
            has_import 		: has_import,
            content_id 		: content_id,
            sales_des_id 	: sales_des_id,
			supplier_id 	: supplier_id,
			order_date 		: order_date,
			stock_id 		: stock_id,
			product_id 		: product_id,
			product_name 	: product_name,
			product_amount 	: product_amount,
			product_accumulation : product_accumulation,
			back_number 	: back_number,
			product_price 	: product_price,
			product_date 	: product_date,
			amount_plus 	: accumulation_plus,
			check_has_import : check_has_import
    },function(data,error){
    	console.log(data);
    });*/
});

//-->Datepicker limit old date
  $('.datepicker_').datepicker({
	  dateFormat:'yy/mm/dd',
	  changeMonth: true,
        changeYear: true,
      minDate: 0
    }).attr('readonly','readonly');