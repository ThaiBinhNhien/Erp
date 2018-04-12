/*$("table").on("keyup",".discount",function(){
	var table = $(this).parent().parent().parent();
	var sum_price = parseInt(table.find('.sum_price').text());//tổng tiền các sản pẩm trong order
	var tax = parseInt(table.find('.tax').text()); //tiền thuế
	console.log(tax);
	var total_price = sum_price + (this.value/100)*sum_price + tax;
	table.find('.total_price').text(total_price);
	var list_total_price = document.getElementsByClassName('total_price');
	var sum_total_price = 0; //cộng tất cả các total price của từng order
	for(var i=0; i<list_total_price.length; i++){
		sum_total_price += parseFloat(list_total_price[i].innerHTML);
	}
	$('#total_price').text(sum_total_price);
});

$('#total_discount').keyup(function(){
	var sum_price = parseFloat($('.sum_price_department').text());
	var tax = parseFloat($('#total_tax').text());
	var total_price = sum_price - sum_price*(this.value)/100 + tax;
	$('#total_price').text(total_price);
});*/

var check_status = false;

$('#address,#comment').on("keyup",function() {
	check_status = true;
})

$('.save-sale').click(function(){
	var invoice_id = $('#invoice_id').val();
	var customer_id = $('#customer_id').val();
	var invoice_group_id = $('#invoice_group_id').val();
	var address = $('#address').val();
	var comment = $('#comment').val();
	var order_id = document.getElementsByClassName('id_of_order');
	var discount = document.getElementsByClassName('discount');
	var order_id_list = '';
	var discount_cate1 = '';
	var discount_cate2 = '';
	var total_price = parseInt($(".total_price").text());
	for(var i = 0; i<order_id.length ; i++){
		if(i==0) order_id_list += order_id[i].value;
		else order_id_list += '|'+order_id[i].value;
	}
	/*for(var i = 0; i<discount.length ; i++){
		if(i==0) discount_list += discount[i].value;
		else discount_list += '|'+discount[i].value;
	}*/
	for(var i = 0; i < $(".discount_cate1").length; i++){
		if(i==0) discount_cate1 += $(".discount_cate1").eq(i).val();
		else discount_cate1 += "|" + $(".discount_cate1").eq(i).val();
	}

	for(var i = 0; i < $(".discount_cate2").length; i++){
		if(i==0) discount_cate2 += $(".discount_cate2").eq(i).val();
		else discount_cate2 += "|" + $(".discount_cate2").eq(i).val();
	}

	console.log('order id list: ' + order_id_list);
	console.log('discount_cate1 list: ' + discount_cate1);
	console.log('discount_cate2 list: ' + discount_cate2);
	console.log('count of discount_cate1: '+$(".discount_cate1").length);
	console.log('count of discount_cate2: '+$(".discount_cate2").length);
	console.log('count of order: '+$(".id_of_order").length);
	$(this).helloWorld('請求書を保存します。よろしいですか？',base_url+'sale/created_sale',null,{
        url: base_url+"sale/ajax_save_sale",
        data : {
            invoice_id : invoice_id,
			customer_id : customer_id,
			invoice_group_id : invoice_group_id,
			comment : comment,
			address : address,
			order_id_list : order_id_list,
			discount_cate1 : discount_cate1,
			discount_cate2 : discount_cate2,
			total_price : total_price
        },
        error_message: '請求書を保存します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
    /*$.post(base_url+"sale/ajax_save_sale",
    {
    		invoice_id : invoice_id,
			customer_id : customer_id,
			invoice_group_id : invoice_group_id,
			comment : comment,
			order_id_list : order_id_list,
			discount_cate1 : discount_cate1,
			discount_cate2 : discount_cate2,
			total_price : total_price
    },function(data,error){
    	console.log(data);
    });*/
});

/**
* cập nhật tổng chiết khấu và tổng tiền giấy đòi tiền
*/
function update_price(){
	check_status = true;
	var sum_price_cate1 = parseFloat($(".sum_price_cate1").text());
	if(!($(".sum_price_cate1").text()>0)) sum_price_cate1 = 0;
	console.log('sum_price_cate1: '+sum_price_cate1);
	var col_2_value = parseFloat($("#col_2_hide_value").val());
	var sum_price_cate2 = parseFloat($(".sum_price_cate2").text());
	if(!($(".sum_price_cate2").text()>0)) sum_price_cate2 = 0;
	var tax = parseFloat($("#tax_hide_value").val());
	if($(".tax").text()=='') tax = 0;
	var sum_price = sum_price_cate1+sum_price_cate1*col_2_value/100+sum_price_cate2;
	$(".col_2_value").text(Math.abs(parseFloat(sum_price_cate1*col_2_value/100)));
	console.log("col_2_value = "+col_2_value);
	var environment_tax = 0;
	if(col_2_value>0) environment_tax = col_2_value*discount_gaichyu.environment_discount/100;
	var fee_gaichyu = (sum_price_cate1*discount_gaichyu.linen_discount+sum_price_cate1*environment_tax+sum_price_cate2*discount_gaichyu.other_discount)/100;
	$('.discount_gaichyu').text(fee_gaichyu);
	sum_price = sum_price - parseFloat(fee_gaichyu);
	$(".col_4_value").text(parseInt(sum_price));
	if(sum_price*tax/100 > 0) $(".tax").text(parseFloat(sum_price*tax/100));
	$(".total_price").text(parseInt(sum_price+sum_price*tax/100));
}

$("table").on("keyup",".discount_cate1",function(){
	var tb = $(this).parent().parent().parent().parent();
	var price = tb.find(".price_hide_cate1").val();
	var order_id = tb.find('.order_id').val();
	var price1 = parseFloat(price)-this.value*parseFloat(price)/100;
	console.log("price1 "+price1);
	$(".order"+order_id).find(".cate1").text(price1);
	tb.find(".price_cate1").text(parseFloat(price1));
	//tb.find(".price_hide_cate1").val(parseFloat(price1));
	var price_list = document.getElementsByClassName("price_cate1");
	var sum_price = 0;
	for(var i=0; i < price_list.length; i++){
		console.log("department_id: "+$('.department_id_cate1').eq(i).val())
		if(discount_gaichyu.department != $('.department_id_cate1').eq(i).val()) sum_price += parseFloat(price_list[i].innerHTML);
	}
	$(".sum_price_cate1").text(parseFloat(sum_price));
	update_price();
});

$("table").on("keyup",".discount_cate2",function(){
	var tb = $(this).parent().parent().parent().parent();
	var price = tb.find(".price_hide_cate2").val();
	var order_id = tb.find('.order_id').val();
	var price2 = parseFloat(price)-this.value*parseFloat(price)/100;
	console.log("price2 "+price2);
	$(".order"+order_id).find(".cate2").text(price2);
	tb.find(".price_cate2").text(parseFloat(price2));
	var price_list = document.getElementsByClassName("price_cate2");
	var sum_price = 0;
	for(var i=0; i < price_list.length; i++){
		if(discount_gaichyu.department != $('.department_id_cate2').eq(i).val()) sum_price += parseFloat(price_list[i].innerHTML);
	}
	$(".sum_price_cate2").text(parseFloat(sum_price));
	update_price();
});

$('.back').click(function(){
	if(check_status == true){
		$(this).helloWorld('入力した情報を破棄して、MENU画面遷移してよろしいでしょうか？',base_url+'sale',null,{
        url: base_url+"sale/back",
        data : {},
        error_message: '',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
	}else{
		window.location.href = base_url+"sale";
	}
});