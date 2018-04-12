
var product_table = null;
var filter_product = [];
/*------------------------Begin Calculate price of product after change amount --------------------------------------------*/
$('tbody').on('keyup','.amount',function(e){
  //Get position tr
  var amount = $(this).val();
  if(amount > 0){
    $(this).closest('td').find('.popup').remove();
    $('#create-purchase-order').removeClass('error');
    var pos_tr = $(this).closest('tr');
    //Get value price_unit
    var price_unit = parseInt(pos_tr.find('.price_unit').text());
    //Price every product
    if(price_unit>0) pos_tr.find('.price').text($(this).val()*price_unit);
    //Sum price of all products
    var sum_price = 0;
    $( ".price" ).each(function( index ) {
      if(parseFloat($(this).text())>0) sum_price += parseFloat($(this).text());
    });
    $('.sum-price').text(sum_price);
    //Sum price after discount
    var discount = $('.discount').val();
    var total_price = sum_price - sum_price*(discount/100);
    $('.sum-total').text(total_price);
  } else {
    $(this).closest('td').css('position','relative');
    $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
    $('#create-purchase-order').addClass('error');
  }

});
/*------------------------End Calculate price of product after change amount --------------------------------------------*/
/*------------------------Begin Sum price of order --------------------------------------------*/
$('tbody').on('keyup mouseup','.discount',function(){
  var discount = this.value;
  if( discount >= 0){
      //$('#create-purchase-order').removeClass('error');
      //$(this).closest('td').find('.popup').remove();  
  var sum_price = 0;
  for(var i=0;i < document.getElementsByClassName('price').length;i++){
    if($('.price').eq(i).text()!='') sum_price += parseFloat($('.price').eq(i).text());
  }
  $('.sum-price').text(sum_price);
  
  var total_price = sum_price - sum_price*discount/100;
  $('.sum-total').text(total_price);
  }
  //} else {
    //$(this).closest('td').css('position','relative');
    //$(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
  //}

});
/*------------------------End Sum price of order --------------------------------------------*/

/*    var table='';
    table+='<table class="detail-product">';
    for(var i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].product_id+'</td>'+'<td>'+json_product_list[i].name+'</td>'+'</tr>';
      }
    table+='</table>';   
    ///$('.product_id').after(table);
    product_table=table;
    console.log(product_table);*/

    //__Get list product and push json
    for(var i in json_product_list){
      var obj = {
        'id': json_product_list[i].product_id,
        'name': json_product_list[i].name,
        'buy_code': json_product_list[i].buy_code
      }
      filter_product.push(obj);
    }


/*---------------------------Begin Display products table when product_id is focus --------------------------------*/
$('table').on('click','.product_id',function(e){
/*    $(".detail-product").remove();
    $(this).after(product_table);
    var table=$(this).next();
    $(table).css('display','block');
    e.stopPropagation();*/
})
/*---------------------------End Display products table when product_id is focus --------------------------------*/
/*---------------------------Begin Hide detail-product table when click outside --------------------------------*/
$(document).click(function(e) {
/*  if( e.target.class != 'product_id') {
    $(".detail-product").hide();
    e.stopPropagation();
  }*/
});
/*---------------------------End Hide detail-product table when click outside --------------------------------*/

/*---------------------------Begin Display information of product when select product --------------------------*/
$('#edit-purchase-table').on('click','.detail-product tr',function(){
/*var val=$(this).children("td:first").text();
var prod=$(this).closest('div');
$(this).closest('td').find('.popup').remove();
$(".detail-product").hide();
prod.find('.product_id').val(val);
//Display detail product when selected
var table=prod.closest('.product');
 for(i in json_product_list){
    if(json_product_list[i].product_id==val){
        table.find('td[data-name]')        .text(json_product_list[i].name);
        table.find('td[data-color]')       .text(json_product_list[i].color);
        table.find('td[data-standard]')    .text(json_product_list[i].standard);
        table.find('td[data-accumulation]').text(json_product_list[i].accumulation);
        table.find('td[data-price-unit]')  .text(json_product_list[i].price_unit);
    }
  }
   //Show loading display here
    var form = $("form[name='add_purchase_order']");
    // Validation
    var validator = form.data("validator"); 
    if (!validator || !form.valid()) {
        return false;
    }*/
})
/*---------------End Display information of product when select --------------------*/
/*---------------Begin Search value by input -----------------*/ 
$('#edit-purchase-table').on('keyup','.product_id',function(){
/*var input =$(this).val();
  var filter = input.toUpperCase();
  var tr = $(".detail-product tr");
  for (i = 0; i < tr.length; i++) {
    var td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }*/
})
/*--------------End Search value by input -----------------*/ 
/*------------------------------------Begin Add row purchase order ----------------------------------------*/
$('#insert-row-purchase').click(function(){


  //__Check amount wether empty
  var $nonempty = $('.amount').filter(function() {
    return this.value == ''
  });
  $( ".amount").each(function() {
      var valid = $(this) .val();
        if(valid > 0){} else {
          $(this).closest('td').find('.popup').remove();
          $(this).closest('td').css('position','relative');
          $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
          $('#create-purchase-order').addClass('error');
          return false;//Exit();
        }
      
  });
  if (($nonempty.length > 0) ) {
    return false;
  } 
  else if((json_product_list.length == $('.product_id').length))
  {
    $(this).helloWorld('一覧に仕入商品がもうありません。行挿入出来ません。');
    return false;
  }
  else 
  {
    $('#create-purchase-order').removeClass('error');
    var select_product = "<input class='product_id'>";
    var table='';
    table+='<table class="detail-product">';
    for(var i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].name+'</td>'+'</tr>';
      }
      table+='</table>';  
      var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/><input type="hidden" class="real_id"/></div></td>';
      tr += "<td class='product_name' data-name></td><td data-color></td><td data-standard></td><td><input type='text' class='amount'/></td><td data-accumulation></td><td class='price_unit' data-price-unit></td><td class='price'></td>";
      tr += "<td><input class='comment_product' type='text' name='comment'/></td>";
      tr += '</tr>';
      $('.del').after(tr);
  } 
  return false;
/*  var select_product = "<input class='product_id'>";
  var table='';
    table+='<table class="detail-product">';
    for(i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].name+'</td>'+'</tr>';
      }
    table+='</table>';  
  var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/></div></td>';
      tr += "<td class='product_name' data-name></td><td data-color></td><td data-standard></td><td><input type='text' class='amount'/></td><td data-accumulation></td><td class='price_unit' data-price-unit></td><td class='price'></td>";
      tr += "<td><input name='comment' class='comment_product' type='text'/></td>";
      tr += '</tr>';
      $('.del').after(tr);
      return false;*/
});

/*$("table").on('click','.product',function(){
  $(this).find(".amount").focus();
});*/

/*------------------------------------End Add row purchase order ----------------------------------------*/
$('#edit-purchase-table').on('focus','.comment_product,.amount',function(){
  $('table tr').removeClass('del');
  $(this).parent().parent().addClass('del');
})
$('#remove-row-purchase').click(function(){
  $('.del').remove();
  if($('.product').length == 0){
      var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/><input type="hidden" class="real_id"/></div></td>';
      tr += "<td class='product_name' data-name></td><td data-color></td><td data-standard></td><td><input type='text' class='amount'/></td><td data-accumulation></td><td class='price_unit' data-price-unit></td><td class='price'></td>";
      tr += "<td><input class='comment_product' type='text' name='comment'/></td>";
      tr += '</tr>';
      $('tbody').prepend(tr);
  }
  update_price();
  return false;
})

function update_price() {
    var sum_price = 0;
    $( ".price" ).each(function( index ) {
      if(parseFloat($(this).text())>0) sum_price += parseFloat($(this).text());
    });
    $('.sum-price').text(sum_price);
    //Sum price after discount
    var discount = $('.discount').val();
    var total_price = sum_price - sum_price*(discount/100);
    $('.sum-total').text(total_price);
}


$('#create-purchase-order').click(function(){
      /*$( ".product_id").each(function() {
      var valid = $(this) .val();
        if(valid == ''){
          $('#create-purchase-order').addClass('error');
          $(this).closest('td').css('position','relative');
          $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">このフィールドにを入力してください。</span></div>');
          return false;//Exit();
        }   
  });
      $( ".amount").each(function() {
      var amount = $(this) .val();
        if(amount > 0){
        } else {
          $('#create-purchase-order').addClass('error');
          $(this).closest('td').css('position','relative');
          $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
        }    
  });

  if($('#create-purchase-order').hasClass('error')){
        return false;
    }

  var discount = $('.discount').val();
  if(discount >= 0){

  } else {
    return false;
  }*/
  //console.log(check_number)
  //check_required('product_id');
  //check_required('amount');


  /* $( ".product_id").each(function() {
      var valid = $(this) .val();
        if(valid == ''){
          $(this).closest('td').css('position','relative');
          $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
              $('#create-purchase-order').addClass('error');
              return false;//Exit();
        } else {
          $(this).closest('td').find('.popup').remove();
          $('#create-purchase-order').removeClass('error');
        }
      
  }); */// validation product_id
    $( ".amount").each(function() {
      var valid = $(this) .val();
        if(valid > 0){  
        } else {
          $(this).closest('td').css('position','relative');
          $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
          $('#create-purchase-order').addClass('error');
          return false;//Exit();
        }
      
  });
  if($('#create-purchase-order').hasClass('error')){
        return false;
    }
/*  if(!check_valid()){
    return false;
  }*/
  var discount = $('.discount').val();
  var order_id = $('.order_id').val();
  var date_create = $('#date_create').val();
  var delivery_date = $('#delivery_date').val();
  var supplier_id = $('#supplier_id').val();
  var sales_des_id = $('#sales_des_id').val();
  var content_id = $('#content_id').val();
  var stock_id = $('#stock_id').val();
  var stock_address = $('#stock_address').val();
  var update_date = $('#update_date').val();
  console.log('update_date:'+update_date);
  var product_id = '';
  var product_name = '';
  var product_amount = '';
  var product_price_unit = '';
  var comment_product = '';
  
  var comment = $('#comment').val();
  for(var i=0;i < document.getElementsByClassName('product').length;i++){
    if(i==0){
      product_id += $('.product').eq(i).find('.real_id').val();
      product_name += $('.product').eq(i).find('.product_name').text();
      product_amount += $('.product').eq(i).find('.amount').val();
      product_price_unit += parseFloat($('.product').eq(i).find('.price_unit').text());
      comment_product += $('.product').eq(i).find('.comment_product').val();
    }else{
      product_id += '|'+$('.product').eq(i).find('.real_id').val();
      product_name += '|'+$('.product').eq(i).find('.product_name').text();
      product_amount += '|'+$('.product').eq(i).find('.amount').val();
      product_price_unit += '|'+parseFloat($('.product').eq(i).find('.price_unit').text());
      comment_product += '|'+$('.product').eq(i).find('.comment_product').val();
    }
  }
  $(this).helloWorld('発注伝票（新規）を保存します。よろしいですか？',base_url+'purchase',null,{
        url: base_url+"purchase/ajax_edit_purchase_order",
        data : {
            order_id : order_id,
            date_create : date_create,
            delivery_date : delivery_date,
            supplier_id : supplier_id,
            sales_des_id : sales_des_id,
            content_id : content_id,
            stock_id : stock_id,
            stock_address : stock_address,
            update_date : update_date,
            product_id : product_id,
            product_name : product_name,
            product_amount : product_amount,
            product_price_unit : product_price_unit,
            product_comment : comment_product,
            discount : discount,
            comment : comment,
            status : 1
        },
        error_message: '出庫伝票（新規）を保存します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
});
/*-----------------------------Remove tr when sales of destination change ---------------------------------*/
$('#sales_des_id').change(function(){
//__Don't use
/*  $('.product').remove();
  var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/></div></td>';
      tr += "<td class='product_name' data-name></td><td data-color></td><td data-standard></td><td><input type='text' class='amount'/></td><td data-accumulation></td><td class='price_unit' data-price-unit></td><td class='price'></td>";
      tr += "<td><input class='comment_product' type='text'/></td>";
      tr += '</tr>';
  $('thead').after(tr);*/
})
/*-----------------------------Remove tr when sales of destination change ---------------------------------*/
//__Datepicker limit old date
$('.datepicker_').datepicker({
    dateFormat:'yy/mm/dd',
    changeMonth: true,
      changeYear: true,
    minDate: 0
  }).attr('readonly','readonly');


//check_number('discount');
//check_number('amount');

$('#date_create').datepicker({
    dateFormat:'yy/mm/dd',
    changeMonth: true,
    changeYear: true,
    onSelect: function () {
        var dt_to = $('#delivery_date');
        var minDate = $(this).datepicker('getDate');
        dt_to.datepicker('option', 'minDate', minDate); 
    }
}).attr('readonly','readonly');

var date_create_arr = $("#date_create").val().split("/");

$('#delivery_date').datepicker({
    dateFormat:'yy/mm/dd',
    changeMonth: true,
    changeYear: true,
    minDate : new Date(date_create_arr[0],date_create_arr[1]-1,date_create_arr[2]),
    onSelect: function () {
        var dt_from = $('#date_create');
        var maxDate = $(this).datepicker('getDate');
        dt_from.datepicker('option', 'maxDate', maxDate);
    }
}).attr('readonly','readonly');



$('#edit-purchase-table').popup_table('edit-purchase-table',filter_product);
//__Don't allow typing text, only number
$('#edit-purchase-table').on('keypress','.amount,.discount,.product_id',function(event){
    var key = window.event ? event.keyCode : event.which;
    var charStr = String.fromCharCode(key);
/*    if( charStr == '-'){
      return true;
    }
    else */

    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
      return true;
    }
});
