var product_id_list = '';
var row_selected = null;
var product_table = null;
var check_changed = false;
/*$('#customer_id').on('change',function() {
	var customer_id = this.value;
	var base_id = $('#base_id').val();
	$.post(base_url+'sale/ajax_get_list_product',
	{
		customer_id : customer_id,
		base_id : base_id
	},
	function(data,status) {
		list_product = JSON.parse(data);
		product_id_list = convert_list_product_to_html(list_product);
		$('.product_id').html(product_id_list);
	});
});*/

  $(document).on('change keyup click','.amount,.price,#date_create,#cus_name,#department_name,#address,#paid_date_start,#paid_date_end,#remark',
    function(){
      check_changed = true;
    });

$('tbody').on('change','.product_id',function(){
	var product_id = this.value;
	var row = $(this).parent().parent();
	var td = row.find('td');
	for (var i in list_product) {
		if(list_product[i].product_id == product_id){
			td.eq(1).text(list_product[i].product_name);
			td.eq(2).text(list_product[i].standard);
			td.eq(3).text(list_product[i].color);
			td.eq(4).text(list_product[i].sell_price);
			td.eq(5).find('input').val(0);
			td.eq(6).text(0);
		}
	}
});

$('tbody').on("keyup",".amount",function(){
	var row = $(this).parent().parent();
	row.find('.popup').remove();
	var sell_price = parseInt(row.find('.sell_price').text());
	var amount = this.value;
	if(amount > 0){
		$('.save-revenue-2').removeClass('error');
    if(sell_price > 0)
    {
		var price = sell_price*amount;
		if(sell_price>0) row.find('.price').html(price+"<input class='inp-price' type='hidden' value='0' />");

		$('#total_price').text(plus_price());
    }
	} else {
    if(amount == 0 | amount == ''){
      if(row.find('.inp-price').val())row.find('.price').html("<input type='hidden' value='0' />");
      $('#total_price').text(plus_price());
    }
/*		$('.save-revenue-2').addClass('error');
		$(this).closest('td').css('position','relative');
		$(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');*/
    $(this).closest('td').css('position','relative');
    $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
    setTimeout(function(){ $('.popup').fadeOut().remove(); }, 5000);
	}
});


$('tbody').on("keyup",".inp-price",function(){
	var _val = $(this).val();
	if( _val > 0){
		$('.save-revenue-2').removeClass('error');
		$('#total_price').text(plus_price());
		$(this).closest('td').find('.popup').remove();
	} else {
		$('.save-revenue-2').addClass('error');
		$(this).closest('td').css('position','relative');
		$(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
	}
	
})
/*$('#insert-revenue-2').click(function(){
    $('table tbody tr:last')
            .before("<tr><td><select class='product_id'>"+product_id_list
            	+"</select></td><td></td><td></td><td></td><td class='sell_price'></td><td><input class='amount' /></td><td class='price'></td></tr>");
});*/

$('table').on('focus','.amount,.inp-price',function(){
	console.log('amount focus');
	row_selected = $(this).parent().parent();
});
$('table').on('focus','.amount,.inp-price,.product_id',function(){
  row_selected = $(this).closest('tr');
});
$('#remove-revenue-2').click(function(){
/*	if(row_selected != null) row_selected.remove();
  $('#total_price').text(plus_price());*/
  if($('.product_id').length > 1){
    if(row_selected != null) row_selected.remove();
    $('#total_price').text(plus_price());
  }
  else
  {
    $('.product_id,.amount,.inp-price').val('');
    $('td[data-color],td[data-standard],td[data-accumulation],td[data-name],td[data-price],td[data-sum]').text('');
    $(".price").text('');
  }
  $('#total_price').text(plus_price());
});

function convert_department_list_to_html(data) {
	var json_department_list = JSON.parse(data);
	var option_list = '<option></option>';
	if(json_department_list == null) return option_list;
	for (var i in json_department_list) {
		option_list += "<option value='"+json_department_list[i].department_id+"'>"
		+json_department_list[i].department_name
		+"</option>";
	}
	return option_list;
}

//convert list product thành list id sản phẩm dạng html option
/*function convert_list_product_to_html(json_product_list) {
	product_list = '<option></option>';
	for(i in json_product_list){
		product_list += "<option value='"+json_product_list[i].product_id+"'>"
		+json_product_list[i].product_id
		+"</option>"
	}
	return product_list;
}*/

$(document).on('click','.save-revenue-2',function(){
//$('.save-revenue-2').click(function(){
  /*var valid = true;


  if($('#cus_name').val()==''){
       error_popup('div','#cus_name');
       valid = false;
    }
  if($('#department_name').val()==''){
       error_popup('div','#department_name');
       valid = false;
    }*/
  
	/*if (!validator || !form.valid()) {
        return false;
    }
    var ending_date   = $('#paid_date_end').val();
    var starting_date = $('#paid_date_start').val();
    if(ending_date!=''&&starting_date==''){
        $('#paid_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日を選択してください。</span></div>');
        return false;
    }
    if(ending_date==''&&starting_date!=''){
        $('#paid_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">終了日を選択してください。</span></div>');
        return false;
      }
  check_required('product_id');
  check_required('amount');
  check_required('inp-price');
  if(!check_valid()){
    return false;
  }*/

//check_re();
    //console.log(valid);

    /*  if(!valid){
    return false;
  }*/

/*    $( ".amount").each(function() {
    	var valid = $(this) .val();
    	if(isNaN(valid)){

    	}
    })*/	

  /*  if($('.save-revenue-2').hasClass('error')){
        return false;
    }*/

  if (!validator || !form.valid()) {
        return false;
    }  
  //check_input_required('#cus_name');
  check_required('real_id');
  check_required('amount');
  check_required('inp-price');
  if(!check_valid()){ return false; }

	var invoice_id = $('#invoice_id').val();
	var user_id = $('#user_id').val();
	var date_create = $('#date_create').val();
	var cus_name = $('#cus_name').val();
	var department_name = $('#department_name').val();
	var address = $('#address').val();
	var paid_date_start = $('#paid_date_start').val();
	var paid_date_end = $('#paid_date_end').val();
	var remark = $('#remark').val();
	var total_price = $('#total_price').text();
  var list_product_id = get_list_product_id();
  console.log("list id: "+list_product_id);
  var list_product_name = get_list_product_name();
  console.log("list name: "+list_product_name);
	var list_amount = get_list_amount();
  console.log("list_amount:"+list_amount);
	var list_sell_price = get_list_sell_price();
  console.log("list_sell_price:"+list_sell_price);
  var list_price = get_list_price();
  console.log("list_price:"+list_price);
	$(this).helloWorld('請求書を保存します。よろしいですか？',base_url+"sale/created_sale",null,{
        url: base_url+"sale/ajax_save_sale_2",
        data : {
            invoice_id : invoice_id,
            user_id : user_id,
            date_create : date_create,
            cus_name : cus_name,
            department_name : department_name,
            address : address,
            paid_date_start : paid_date_start,
            paid_date_end : paid_date_end,
            remark : remark,
            total_price : total_price,
            list_product_id : list_product_id,
            list_product_name : list_product_name,
            list_amount : list_amount,
            list_sell_price : list_sell_price,
            list_price : list_price
        },
        error_message: '出庫伝票（新規）を保存します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
  /*$.post(base_url+"sale/ajax_save_sale_2",
  {
    invoice_id : invoice_id,
    user_id : user_id,
    date_create : date_create,
    cus_name : cus_name,
    department_name : department_name,
    address : address,
    paid_date_start : paid_date_start,
    paid_date_end : paid_date_end,
    remark : remark,
    total_price : total_price,
    list_product_id : list_product_id,
    list_amount : list_amount,
    list_sell_price : list_sell_price,
    list_price : list_price
  },function(data,err){
    console.log(data);
  });*/
    

});
/*
//__Create new invoice__
$('.save-revenue-2').click(function(){
	console.log(plus_price());
	return false;
	if (!validator || !form.valid()) {
        return false;
    }
     var ending_date   = $('#paid_date_end').val();
     var starting_date = $('#paid_date_start').val();
     if(ending_date!=''&&starting_date==''){
        $('#paid_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日を選択してください。</span></div>');
        return false;
     } 
     if(ending_date==''&&starting_date!=''){
        $('#paid_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">終了日を選択してください。</span></div>');
        return false;
     }
     if($('.save-revenue-2').hasClass('error')){
        return false;
    }
	
	var data = { };
	$.each($('#no-order-invoice').serializeArray(), function() {
	    data[this.name] = this.value;
	});
	var order_id = $('#invoice_id').val();
	var detail = {};
	for(var i=0; i<product.length; i++) {
		detail.product_id = product[i];
	}
	$(this).helloWorld('請求書を保存します。よろしいですか？',null,null,{
        url 	: base_url+"sale/ajax_save_sale_2",
        data 	: {
        			data:data,
        			total_price     : plus_price(),
        			list_product_id : get_list_product_id(),
            		list_amount 	: get_list_amount(),
            		list_sell_price : get_list_sell_price()
        		  },
        error_message: '出庫伝票（新規）を保存します。よろしいですか？',
        ok_text : "Ok",
        cancel_text: 'キャンセル'
    });

	return false;
});*/

function get_list_product_id() {
	var product_id = $('tbody').find('.real_id');
	var list_product_id = '';
	for(var i=0;i < product_id.length; i++){
		if(i==0) list_product_id += product_id.eq(i).val();
		else list_product_id += '|'+product_id.eq(i).val(); 
	}
	return list_product_id;
}

function get_list_product_name(){
  var product_name = $('tbody').find('.name');
  var list_product_name = '';
  for(var i=0; i < product_name.length; i++){
    if(i==0) list_product_name += product_name.eq(i).text();
    else list_product_name += '|'+product_name.eq(i).text();
  }
  return list_product_name;
}

function get_list_amount() {
	/*var price = parseInt($('.sell_price:first').text());
	if( price === 0){
		var amount = $('tbody').find('.sell_price');
		var list_amount = '';
		for(var i=0;i < amount.length; i++){
			if(i==0) list_amount += 0;
			else list_amount += '|'+ 0; 
		}
	} else {*/
		var amount = $('tbody').find('.amount');
		var list_amount = '';
		for(var i=0;i < amount.length; i++){
			if(i==0) list_amount += amount.eq(i).val();
			else list_amount += '|'+amount.eq(i).val(); 
		}
	//}

	return list_amount;
}

function get_list_sell_price() {
	var sell_price = $('tbody').find('.sell_price');
	
	/*var price = parseInt($('.sell_price:first').text());
	if( price === 0){
		//var amount = $('tbody').find('.sell_price');
		var list_sell_price = '';
		for(var i=0;i < sell_price.length; i++){
		if(i==0) list_sell_price += 0;
		else list_sell_price += '|'+ 0; 
		}
	} else {*/
	var list_sell_price = '';
	for(var i=0;i < sell_price.length; i++){
		if(i==0) list_sell_price += sell_price.eq(i).text();
		else list_sell_price += '|'+sell_price.eq(i).text(); 
		}
	//}
	return list_sell_price;
}

function get_list_price(){
  var price = $('tbody').find('.inp-price');
  var price_list = '';
  for(var i=0; i<price.length; i++){
    if(i==0) price_list += price.eq(i).val();
    else price_list += "|"+price.eq(i).val();
  }
  return price_list;
}

//cộng tiền của tùng sản phẩm trong product lại
function plus_price() {
	var tax = $("#tax").val();
	var total_price = 0;
  var product = $('tbody').find('.product');
  for (var i = 0; i < product.length; i++) {
    var sell_price = parseFloat(product.eq(i).find('.sell_price').text());
    if(sell_price>0){
      if(parseFloat(product.eq(i).find('.price').text())>0) total_price += parseFloat(product.eq(i).find('.price').text())
    }
    else if(product.eq(i).find('.inp-price').val() > 0) total_price += parseFloat(product.eq(i).find('.inp-price').val());
  }
	return total_price+total_price*tax/100;
}



var table='';
    table+='<table class="detail-product">';
    for(var i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].sale_code+'</td>'+'<td>'+json_product_list[i].name+'</td>'
      +'<input type="hidden" value="'+json_product_list[i].id+'"'+'</tr>';
      }
    table+='</table>';
    ///$('.product_id').after(table);
    product_table=table;
/*---------------------------Begin Display products table when product_id is focus --------------------------------*/
$('table').on('click','.product_id',function(e){
    $(".detail-product").remove();
    $(this).after(product_table);
    var table=$(this).next();
    $(table).css('display','block');
    e.stopPropagation();
});
/*---------------------------End Display products table when product_id is focus --------------------------------*/
/*---------------------------Begin Hide detail-product table when click outside --------------------------------*/
$(document).click(function(e) {
  if( e.target.class != 'product_id') {
    $(".detail-product").hide();
    e.stopPropagation();
  }
});
/*---------------------------End Hide detail-product table when click outside --------------------------------*/

/*---------------------------Begin Display information of product when select product --------------------------*/
$('#add-revenues-2').on('click','.detail-product tr',function(){
var val=$(this).children("td:first").text();
var real_id = $(this).find('input').val();
var prod=$(this).closest('div');
prod.find('.product_id').val(val);
prod.find('.real_id').val(real_id);
$(".detail-product").hide();
//__Hide error popup
$(this).closest('td').find('.popup').remove();
//Display detail product when selected
var table=prod.closest('.product');
 for(i in json_product_list){
    if(json_product_list[i].id==real_id){
        table.find('td[data-name]')        .text(json_product_list[i].name);
        table.find('td[data-color]')       .text(json_product_list[i].color);
        table.find('td[data-standard]')    .text(json_product_list[i].standard);
        table.find('td[data-price]')  		.text(json_product_list[i].price);

        if(parseInt(json_product_list[i].special)==1){
        	table.find('.amount').remove();
        	table.find('.inp-price').remove();
        	//table.find('td[data-amount]').text('0');
        	table.find('td[data-amount]').text('').append('<input style="text-align: right;" class="amount" type="text" name="amount"/>');
          table.find('.price').text('').append('<input style="text-align: right;" class="inp-price" type="text"/>');
          table.find('td[data-price]')     .text(0);

        } else {
        	table.find('.inp-price').remove();
        	table.find('td[data-amount]').text('').html('<input style="text-align: right;" class="amount" type="text" name="amount"/>');
          table.find('.price').html('<input style="text-align: right;" class="inp-price" type="hidden" value="0"/>')
        }


    }
  }
   //Show loading display here
    var form = $("form[name='add_purchase_order']");
    // Validation
    var validator = form.data("validator"); 
    if (!validator || !form.valid()) {
        return false;
    }
})
/*---------------End Display information of product when select --------------------*/
/*---------------Begin Search value by input -----------------*/ 
$('#add-revenues-2').on('keyup','.product_id',function(e){
var input =$(this).val();
  var filter = input.toUpperCase();
  var tr = $(".detail-product tr");
  for (i = 0; i < tr.length; i++) {
    var td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
        var numOfVisibleRows = $('.detail-product tbody > tr').filter(function() {
        return $(this).css('display') !== 'none';
        }).length;
        if(numOfVisibleRows == 0){
                $('.detail-product').hide();
            }
      }
    } 
  }//__End for
  if (e.keyCode == 13) {
    //__Get number row display
    var real_id = $(this).find('input').val();
    var numOfVisibleRows = $('.detail-product tbody > tr').filter(function() {
        return $(this).css('display') !== 'none';
        }).length;
        //__Display detail if a row
        if(numOfVisibleRows == 1)
        {
            $(".detail-product tbody > tr:visible").addClass('active');
            var val=$(".active > td:first").text();
            $(this).val(val);
            var real_id = $(".active > input").val();
            var table = $(this).closest('tr');
            for(var i in json_product_list){
                if(json_product_list[i].id==real_id){
                table.find('td[data-name]')        .text(json_product_list[i].name);
                table.find('td[data-color]')       .text(json_product_list[i].color);
                table.find('td[data-standard]')    .text(json_product_list[i].standard);
                table.find('td[data-price]')      .text(json_product_list[i].price);

                if(parseInt(json_product_list[i].special)==1){
                  table.find('.amount').remove();
                  table.find('.inp-price').remove();
                  //table.find('td[data-amount]').text('0');
                  table.find('td[data-amount]').text('').append('<input style="text-align: right;" class="amount" type="text" name="amount"/>');
                  table.find('.price').text('').append('<input style="text-align: right;" class="inp-price" type="text"/>');
                  table.find('td[data-price]')     .text(0);

                } else {
                  table.find('.inp-price').remove();
                  table.find('td[data-amount]').text('').html('<input style="text-align: right;" class="amount" type="text" name="amount"/>');
                  table.find('.price').html('<input style="text-align: right;" class="inp-price" type="hidden" value="0"/>')
                }
              }//__End if
            }//__End for
            $('.detail-product').remove();
      }
   }//__End if   
})
/*--------------End Search value by input -----------------*/ 
/*------------------------------------Begin Add row purchase order ----------------------------------------*/
$('#insert-revenue-2').click(function(){

  var select_product = "<input class='product_id'>";
  var table='';
    table+='<table class="detail-product">';

    for(i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].name+'</td>'+'</tr>';
      }
    	table+='</table>';  
  		var tr = "<tr class='product'>";
      	tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id" name="product_id"/><input class="real_id" type="hidden"/></div></td>';
      	tr +='<td data-name class="name"></td>'
			+'<td data-standard></td>'
			+'<td data-color></td>'
      +'<td data-amount><input class="amount valid" type="text"/></td>'
			+'<td data-price class="sell_price"></td>'
			+'<td class="price"></td>';
      tr += '</tr>';
      if($('.save-revenue-2').hasClass('error')){
        return false;
    	} else {
    		$('.del').after(tr);
    	}

      return false;
});
/*------------------------------------End Add row purchase order ----------------------------------------*/
$('#add-revenues-2').on('focus','input[type="text"]',function(){
  $('table tr').removeClass('del');
  $(this).parent().parent().addClass('del');
})
$('#remove-row-purchase').click(function(){
  //$('.del').remove();
  return false;
})
/*-------------------------------------------------------Begin Validation --------------------------------------------*/
$("#no-order-invoice").validate();
    /// Supplier 
    $('input[name="customer"]').rules('add', { required: true });
    $('input[name="customer"]').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('input[name="department"]').rules('add', { required: true });
    $('input[name="customer"]').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('textarea[name="address"]').rules('add', { required: true });
    $('input[name="customer"]').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    //__Product     
/*    $('#no-order-invoice .product_id').each(function() {
        $(this).rules('add', {
            required: true
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });*/
    //__Amount
    /*$('#no-order-invoice .amount').each(function() {
        $(this).rules('add', {
            required: true,
            number: true,
            min: 1
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });
    */
    //Show loading display here
    var form = $("#no-order-invoice");
    // Validation
    var validator = form.data("validator");
   

/*-------------------------------------------------------End  Validation --------------------------------------------*/
//-->Datepicker limit old date
  $('.datepicker_').datepicker({
      dateFormat:'yy/mm/dd',
      changeMonth: true,
        changeYear: true,
      minDate: 0
    }).attr('readonly','readonly');
check_number('inp-price');
check_number('amount');

$('#date_create').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        minDate : 0
    }).attr('readonly','readonly');

//__Validation search by date
$('#paid_date_end').change(function(){
    $('#paid_date_end').closest('div').find('.popup').remove();
    var ending_date = $(this).val();
    var starting_date = $('#paid_date_start').val();
    if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('#paid_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('#paid_date_start').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }
});
$('#paid_date_start').change(function(){
    $('#paid_date_start').closest('div').find('.popup').remove();
    var starting_date = $(this).val();
    var ending_date = $('#paid_date_end').val();
     if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('#paid_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('#paid_date_start,#paid_date_end').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }
});
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
$('.back').click(function(){
  if(check_changed){
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

keypress_number('#add-revenues-2','.amount');