$(".save-created").click(function(){
	var invoice_id = $('#invoice_id').val();
	var remark = $('#remark').val();
	var address = $('#address').val();
	var total_price = parseFloat($('#total_price').text());
	var update_date = $('#update_date').val();
	console.log('update_date: '+update_date);
	var discount_cate1_list = '';
	var discount_cate2_list = '';
	var order_id_list = '';
	var discount_cate1 = document.getElementsByClassName('discount_cate1');
	var discount_cate2 = document.getElementsByClassName('discount_cate2');
	var order_id = document.getElementsByClassName('order_id_list');
	for (var i = 0; i < discount_cate1.length; i++) {
		if(i==0) discount_cate1_list += discount_cate1[i].value;
		else discount_cate1_list += '|'+discount_cate1[i].value;
	}

	for (var i = 0; i < discount_cate2.length; i++) {
		if(i==0) discount_cate2_list += discount_cate2[i].value;
		else discount_cate2_list += '|'+discount_cate2[i].value;
	}

	for (var i = 0; i < order_id.length; i++) {
		if(i==0) order_id_list += order_id[i].value;
		else order_id_list += '|'+order_id[i].value;
	}

	console.log("order list: "+order_id_list);
	console.log("total price: "+total_price);
	console.log("discount_cate1_list: "+discount_cate1_list);
	console.log("discount_cate2_list: "+discount_cate2_list);

	$(this).helloWorld('請求書を保存します。よろしいですか？',base_url+"sale/created_sale",null,{
        url: base_url+"sale/ajax_edit_sale",
        data : {
            invoice_id : invoice_id,
	    	total_price : total_price,
	    	update_date : update_date,
	    	order_id_list : order_id_list,
	    	discount_cate1_list : discount_cate1_list,
	    	discount_cate2_list : discount_cate2_list,
	    	remark : remark,
	    	address : address
        },
        error_message: '請求書を編集します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });

    /*$.post(base_url+"sale/ajax_edit_sale",
    {
    	invoice_id : invoice_id,
    	total_price : total_price,
    	order_id_list : order_id_list,
    	discount_cate1_list : discount_cate1_list,
    	discount_cate2_list : discount_cate2_list,
    	remark : remark,
    	address : address
    },
 	function(data,error){
 		console.log(data);
 	}
    );*/
});

$(".save-no-order").click(function(){
	var invoice_id = $('#invoice_id').val();
	var customer = $('#cus_name').val();
	var department = $('#department_name').val();
	var paid_date_start = $('#paid_date_start').val();
	var paid_date_end = $('#paid_date_end').val();
	var remark = $('#comment').val();
	var address = $('#address').val();
	var total_price = parseFloat($('#total_price').text());
	var update_date = $('#update_date').val();
	console.log('update_date: '+update_date);
	var product_id_list = '';
	var product_amount_list = '';
	var product_price_list = '';
	var index = 0;
	$(".product_detail").each(function(i){
		if($(".product_detail").eq(i).find('.amount_no_order').length!=0){
			if(index==0){
				product_id_list += $(".product_detail").eq(i).find('.product_id').val();
				product_amount_list += $(".product_detail").eq(i).find('.amount_no_order').val();
				product_price_list += $(".product_detail").eq(i).find('.price_no_order').val();
				index = 1;
			}else{
				product_id_list += "|"+$(".product_detail").eq(i).find('.product_id').val();
				product_amount_list += "|"+$(".product_detail").eq(i).find('.amount_no_order').val();
				product_price_list += "|"+$(".product_detail").eq(i).find('.price_no_order').val();
			}
		}
	});
	$(this).helloWorld('請求書を保存します。よろしいですか？',base_url+"sale/created_sale",null,{
        url: base_url+"sale/ajax_edit_sale_no_order",
        data : {
            invoice_id : invoice_id,
			customer : customer,
			department : department,
			paid_date_start : paid_date_start,
			paid_date_end : paid_date_end,
			remark : remark,
			address : address,
			update_date : update_date,
			total_price : total_price,
			product_id_list : product_id_list,
			product_amount_list : product_amount_list,
			product_price_list : product_price_list
        },
        error_message: '請求書を編集します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });

	/*$.post(base_url+"sale/ajax_edit_sale_no_order",
	{
		invoice_id : invoice_id,
			customer : customer,
			department : department,
			paid_date_start : paid_date_start,
			paid_date_end : paid_date_end,
			remark : remark,
			address : address,
			total_price : total_price,
			product_id_list : product_id_list,
			product_amount_list : product_amount_list,
			product_price_list : product_price_list
	},function(data,error){
		console.log(data);
	});*/
});

$("table").on("keyup",".discount_cate1",function(){
	var tb = $(this).parent().parent().parent().parent();
	var order_id = tb.find('.order_id').val();
	var sum_price = 0;
	tb.find('.price').each(function(index){
		sum_price += parseFloat($(this).text());
	});
	tb.find('.sum_price').text(sum_price - sum_price*this.value/100);
	$(".cate1_of_order"+order_id).text(sum_price - sum_price*this.value/100);
	var price_cate1 = 0;
	$(".price_cate1").each(function(index){
		console.log("index: "+index);
		if(discount_gaichyu.department != $('.department_id').eq(index).val()) price_cate1 += parseFloat($(this).text());
	});
	$(".sum_price_cate1").text(price_cate1);
	update();
});

$("table").on("keyup",".discount_cate2",function(){
	var tb = $(this).parent().parent().parent().parent();
	var order_id = tb.find('.order_id').val();
	var sum_price = 0;
	tb.find('.price').each(function(index){
		sum_price += parseFloat($(this).text());
	});
	tb.find('.sum_price').text(sum_price - sum_price*this.value/100);
	$(".cate2_of_order"+order_id).text(sum_price - sum_price*this.value/100);
	var price_cate2 = 0;
	$(".price_cate2").each(function(index){
		if(discount_gaichyu.department != $('.department_id').eq(index).val()) price_cate2 += parseFloat($(this).text());
	});
	$(".sum_price_cate2").text(price_cate2);
	update();
});

$("tbody").on("keyup",".price_cate1",function(){
	var sum_price = 0;
	$(".product_cate1").each(function(index){
		if($(".product_cate1").eq(index).find('.price_cate1').length>0){
			if($(".product_cate1").eq(index).find('.price_cate1').val() != '') 
				sum_price += parseInt($(".product_cate1").eq(index).find('.price_cate1').val());
		}else{
			sum_price += parseInt($(".product_cate1").eq(index).find('td').eq(4).text())
		}
	});
	console.log('sum_price: '+sum_price);
	$('.sum_price_cate1').text(sum_price);
	update_no_order();
});

$("tbody").on("keyup",".price_cate2",function(){
	var sum_price = 0;
	$(".product_cate2").each(function(index){
		if($(".product_cate2").eq(index).find('.price_cate2').length>0){
			if($(".product_cate2").eq(index).find('.price_cate2').val() != '') 
				sum_price += parseInt($(".product_cate2").eq(index).find('.price_cate2').val());
		}else{
			sum_price += parseInt($(".product_cate2").eq(index).find('td').eq(4).text())
		}
	});
	console.log('sum_price: '+sum_price);
	$('.sum_price_cate2').text(sum_price);
	update_no_order();
});

function update_no_order() {
	var sum_price_cate1 = parseInt($(".sum_price_cate1:first").text());
	var sum_price_cate2 = parseInt($(".sum_price_cate2:first").text());
	if(!(sum_price_cate1>0)) sum_price_cate1 = 0;
	if(!(sum_price_cate2>0)) sum_price_cate2 = 0;
	$('.sum_price').text(sum_price_cate1+sum_price_cate2);
	var tax_price = (sum_price_cate1+sum_price_cate2)*tax/100;
	$(".tax").text(tax_price);
	var total_price = sum_price_cate1 + sum_price_cate2 + tax_price;
	$('.total_price').text(total_price);
}

function update(){
	var price_cate1 = parseFloat($(".sum_price_cate1").text());
	if(!(price_cate1 > 0)) price_cate1 = 0;
	var col_2_hide_value = $(".col_2_hide_value").val();
	var price_cate2 = parseFloat($(".sum_price_cate2").text());
	if($(".sum_price_cate2").text()=='') price_cate2 = 0;
	var col_2_value = Math.abs(price_cate1*col_2_hide_value/100);
	if(col_2_value > 0) $(".col_2_value").text(col_2_value);
	var sum_price = price_cate1 + (col_2_hide_value*price_cate1/100) + price_cate2;
	console.log('col_2_hide_value: '+price_cate1);

	var environment_tax = 0;
	if(col_2_hide_value>0) environment_tax = col_2_hide_value*discount_gaichyu.environment_discount/100;
	var fee_gaichyu = (price_cate1*discount_gaichyu.linen_discount+price_cate1*environment_tax+price_cate2*discount_gaichyu.other_discount)/100;
	$('.discount_gaichyu').text(fee_gaichyu);
	sum_price = sum_price - parseFloat(fee_gaichyu);

	$("#sum_price").text(parseInt(sum_price));
	var tax = $(".tax_hide_value").val();
	if(tax != 0) $(".tax_value").text(sum_price*tax/100);
	$("#total_price").text(parseInt(sum_price + sum_price*tax/100));
}
$(document).ready(function(){
$('#paid_date_start').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        minDate : 0,
        onSelect: function () {
            var dt_to = $('#paid_date_end');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
    }).attr('readonly','readonly');

    $('#paid_date_end').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        minDate : 0,
        onSelect: function () {
            var dt_from = $('#paid_date_start');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');
});