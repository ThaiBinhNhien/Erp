var json_product_list = null;//để lưu danh sách sản phẩm theo nơi bán
var product_table     = null;
var outsourcing       = null;//0: nhập cho chính tolinen, 1: nhập kho cho guychyu(khách hàng)
var row_selected      = null;
var filter_product    = [];

/*------------------------------------Begin Add row purchase order ----------------------------------------*/
$('#insert-row-purchase').click(function(){
  //__Check amount wether empty
  /*var $nonempty = $('.amount').filter(function() {
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
  {*/
    $('#create-purchase-order').removeClass('error');
    var select_product = "<input class='product_id'>";
    /* var table='';
    table+='<table class="detail-product">';
    for(var i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].name+'</td>'+'</tr>';
      }
      table+='</table>';   */
      var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/><input class="real_id" type="hidden"></div></td>';
      tr += "<td class='product_name' data-name></td><td data-color></td><td data-standard></td><td><input type='text' class='amount'/></td><td data-accumulation></td><td class='price_unit' data-price-unit></td><td class='price'></td>";
      tr += "<td><input class='comment_product' type='text' name='comment'/></td>";
      tr += '</tr>';
      $('.del').after(tr);
  /*} 
  return false;*/
});

/*$("table").on('click','.product',function(){
  $(this).find(".amount").focus();
});*/

/*------------------------------------End Add row purchase order ----------------------------------------*/
/*------------------------------------Begin Remove row purchase order ----------------------------------------*/
$('table').on('focus','.amount,.comment_product',function(){
  console.log('amount focus');
  row_selected = $(this).parent().parent();
});
$('#remove-row-purchase').click(function(){
    if(row_selected != null) row_selected.remove();
    if($(".product").length==0){
      var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/><input class="real_id" type="hidden"></div></td>';
      tr += "<td class='product_name' data-name></td><td data-color></td><td data-standard></td><td><input type='text' class='amount'/></td><td data-accumulation></td><td class='price_unit' data-price-unit></td><td class='price'></td>";
      tr += "<td><input class='comment_product' type='text' name='comment'/></td>";
      tr += '</tr>';
      $('tbody').prepend(tr);
    }
    update_price();
    return false;
});
/*------------------------------------Begin Remove row purchase order ----------------------------------------*/
$('#content_id').change(function(){

  if(this.value == 2){//nhập kho cho guychyu
    var option = '<option></option>';
    for(var i in sales_des_list){
      if(sales_des_list[i].outsourcing != 0){
        option += "<option value='"+sales_des_list[i].id+"'>"+sales_des_list[i].name+"</option>";
      }
    }
    $('#sales_des_id').html(option);
    $('#sales_des_id').prop('disabled',false);
    //Require choose value
    $('#sales_des_id').parent().append('<div class="popup"><span class="popuptext" id="myPopup">必須項目です。ご入力ください。</span></div>');
  }
  else{//nhập kho bình thường
    $('#sales_des_id').parent().find('.popup').remove();
    var option = '';
    for(i in sales_des_list){
      if(sales_des_list[i].outsourcing == 0){
        option += "<option value='"+sales_des_list[i].id+"'>"+sales_des_list[i].name+"</option>";
      }
    }
    $('#sales_des_id').html(option); 
    $('#sales_des_id').prop('disabled',true);
  }
});
 
/*------------------------------Begin Get list product when supplier is chosen -----------------------------*/
$('#supplier_id').change(function(){
  $('.product_id').addClass('loading');
  $('.product_id,.amount,.comment_product').prop("disabled", "disabled");
  var supplier_id = this.value;
  //__Remove row when supplier chosed
  filter_product.length = 0;
  $( ".product" ).each(function( index ) {
    if(index > 0){
      $( this ).remove();
    }
  });
  $('.product_id,.amount,.comment_product').val('');
  $('td[data-color],td[data-standard],td[data-accumulation],.product_name,.price_unit,.price').text('');
  //__End remove row when supplier chosed
  $.post(base_url+'purchase/ajax_get_list_product_by_supplier',
  {
    supplier_id : supplier_id 
  },
  function(data,error){
    json_product_list = JSON.parse(data);
    console.log(json_product_list.length);
    var table='';
    ///$('.product_id').after(table);
    product_table=table;

    //filter_product = json_product_list.map({'id' : ti => ti.name});
    //var student = [];
     for(var i in json_product_list){
      var obj = {
        'id': json_product_list[i].product_id,
        'buy_code': json_product_list[i].id,
        'name': json_product_list[i].name,
      }
      filter_product.push(obj);
    }
    var product_arr = [];

    $(".real_id").each(function() {
      product_arr.push($(this).val());
    });
    //console.log(filter_product);
    //__Find and extract products selected
    table+='<table class="detail-product">';
    for(var i in filter_product){
      var check = false;
      product_arr.forEach(function(element) {
      if(filter_product[i].id==element){
        check = true;
      }
    });
    if(!check){
      table+='<tr>'+'<td>'+filter_product[i].buy_code+'</td>'+'<td>'+filter_product[i].name+'</td>'
      +"<input type='hidden' value='"+filter_product[i].id+"'>"+'</tr>';
    }
    }//__End for
    table+='</table>';
    //__Add table to current product_id input
    $('.product_id').after(table);
    $('.product_id').removeClass('loading');
    $('.product_id,.amount,.comment_product').prop("disabled", false);

  });
});
$('#add-purchase-table').popup_table('add-purchase-table',filter_product);
/*------------------------------End Get list product when supplier is chosen -----------------------------*/
$("tbody").on('change','.product_id',function(){
  var tr = $(this).parent().parent();
  var td = tr.find('td');
  for(var i in json_product_list){
    if(json_product_list[i].product_id==this.value){
      td.eq(1).text(json_product_list[i].name);
      td.eq(2).text(json_product_list[i].color);
      td.eq(3).text(json_product_list[i].standard);
      td.eq(5).text(json_product_list[i].accumulation);
      td.eq(6).text(json_product_list[i].price_unit);
    }
  }
});

//đỏi danh sách select sản phẩm khi thay đỏi nơi bán
function convert_product_list_select() {
  var select_product = "<select class='product_id'>";
  select_product += "<option></option>";
  for(var i in json_product_list){
    select_product += "<option value='"+json_product_list[i].product_id+"'>"+json_product_list[i].id+"</option>";
  }
  select_product += "</select>";
  for(i in document.getElementsByClassName('product')){
    var td = $('.product').eq(i).find('td');
    td.eq(0).html(select_product);
    td.eq(1).text('');
    td.eq(2).text('');
    td.eq(3).text('');
    td.eq(4).find('.amount').val(0);
    td.eq(5).text('');
    td.eq(6).text('');
    td.eq(7).text('');
    td.eq(8).find('.comment_product').val('');
  }
  $('.sum-price').text(0);
  $('.discount').val(0);
  $('.sum-total').text(0);
}
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
    if(isNaN(price_unit)) return false;
    //Price every product
    pos_tr.find('.price').text($(this).val()*price_unit);
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

function update_price(){
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
/*------------------------End Calculate price of product after change amount --------------------------------------------*/
$('tbody').on('keyup mouseup','.discount',function(){
  var sum_price = 0;
  for(var i=0;i < document.getElementsByClassName('price').length;i++){
    if($('.price').eq(i).text()!='') sum_price += parseFloat($('.price').eq(i).text());
  }
  $('.sum-price').text(sum_price);
  var discount = this.value;
  var total_price = sum_price - sum_price*discount/100;
  $('.sum-total').text(total_price);
});

$('#stock_id').change(function(){
  if(this.value!=0){
    $('#stock_address').val(null);
    $('#stock_address').prop('disabled',true);
  }
  else $('#stock_address').prop('disabled',false);
});
/*-------------------------------------------------------Begin Validation --------------------------------------------*/
$("form[name='add_purchase_order']").validate();
    //__Date
    $('.datepicker_').rules('add', { required: true });
    $('.datepicker_').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    //__Supplier 
    $('#supplier_id').rules('add', { required: true });
    $('#supplier_id').tooltip({
        trigger: 'manual',
        placement:'top'
    });

    //__Stock
    $('#content_id').rules('add', { required: true });
    $('#content_id').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    //__Stock
    $('#stock_id').rules('add', { required: true });
    $('#stock_id').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    //__Discount 
    $('.discount').rules('add', { required: true ,number: true,min: 0,max: 100});
        $('.discount').tooltip({
            trigger: 'manual',
            placement:'top'
    });
    //__Show loading display here
    var form = $("form[name='add_purchase_order']");
    //__Validation
    var validator = form.data("validator");
/*-------------------------------------------------------End  Validation --------------------------------------------*/

$('#add-purchase-table').on('keyup','.product_id',function(){
  var valid = $(this) .val();
  //__Display error if value is empty
  if(valid == ''){
    $(this).closest('td').css('position','relative');
    $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
    $('#create-purchase-order').addClass('error');
    //__Remove current product table      
    $(".detail-product").remove();           
    var selected_product = [];
    //__Get all selected product into array
    $(".real_id").each(function() {
      selected_product.push($(this).val());
    });

    var table = '';
    table+='<table class="detail-product">';
    //__Loop throught all product and compare, if there is the product selected, it will dismiss. The order hand, it will add product table
    for(var i in filter_product){
      var check = false;
      selected_product.forEach(function(element) {
      if(filter_product[i].id==element){
        check = true;
      }
    });
    if(!check){
      table+='<tr>'+'<td>'+(filter_product[i].buy_code==null ? '' : filter_product[i].buy_code)+'</td>'+'<td>'+filter_product[i].name+'</td>'
      +'<input type="hidden" value="'+filter_product[i].id+'">'+'</tr>';
    }
  }//__End for
    table+='</table>';
    //__Add table to current product_id input
    $(this).after(table);
    $('.detail-product').css('display','block');  
    return false;//Exit();
  } else {
    $(this).closest('td').find('.popup').remove();
    $('#create-purchase-order').removeClass('error');
  }//__End else if
})
/*-------------------------------------------------------End  Validation --------------------------------------------*/
$('.add-purchase').on('click','#create-purchase-order',function(){
   //__Check supplier,delivery
   if (!validator || !form.valid()) {
        return false;
    }
    //__Check selecting product  
    $( ".product_id").each(function() {
      var valid = $(this) .val();
      var real_id = $(this).parent().find('.real_id').val();
      var buy_code = find_buy_code_by_id(real_id);
      if(isNaN(real_id) || real_id == ''){
        $(this).closest('td').find('.popup').remove();
        $(this).closest('td').css('position','relative');
        $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
        $('#create-purchase-order').addClass('error');
              return false;//Exit();
            } else {
              $(this).closest('td').find('.popup').remove();
              $('#create-purchase-order').removeClass('error');
            }           
    });//__End product
    //__Check validation of amount
    $( ".amount").each(function() {
      var valid = $(this) .val();
      if(valid == '' || valid == 0){
          $(this).closest('td').css('position','relative');
          $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
          $('#create-purchase-order').addClass('error');
          return false;//Exit();
        }
      
    });//__End amount
  //__If invalid, can't create new record
  if($('#create-purchase-order').hasClass('error')){
        return false;
    }

  var sales = $('#sales_des_id').val();
  if( sales == ''){
      return false;
  }

  var order_id = $('.order_id').val();
  var user_id = $('#user_id').val();
  var date_create = $('#date_create').val();
  var date_delivery = $("#date_delivery").val();
  var supplier_id = $('#supplier_id').val();
  var sales_des_id = $('#sales_des_id').val();
  var content_id = $('#content_id').val();
  var stock_id = $('#stock_id').val();
  var stock_address = $('#stock_address').val();
  var product_id = '';
  var product_name = '';
  var product_amount = '';
  var product_price_list = '';
  var comment_product = '';
  var discount = $('.discount').val();
  var comment = $('#comment').val();
  for(var i=0;i < document.getElementsByClassName('product').length;i++){
    if(i==0){
      product_id += $('.product').eq(i).find('.real_id').val();
      product_name += $('.product').eq(i).find('.product_name').text();
      product_amount += $('.product').eq(i).find('.amount').val();
      product_price_list += parseFloat($('.product').eq(i).find('.price_unit').text());
      comment_product += $('.product').eq(i).find('.comment_product').val();
    }else{
      product_id += '|'+$('.product').eq(i).find('.real_id').val();
      product_name += '|'+$('.product').eq(i).find('.product_name').text();
      product_amount += '|'+$('.product').eq(i).find('.amount').val();
      product_price_list += '|'+parseFloat($('.product').eq(i).find('.price_unit').text());
      comment_product += '|'+$('.product').eq(i).find('.comment_product').val();
    }
  }
  $(this).helloWorld('発注伝票（新規）を保存します。よろしいですか？',base_url+'purchase',null,{
        url: base_url+"purchase/ajax_save_order",
        data : {
            order_id : order_id,
            user_id : user_id,
            date_create : date_create,
            date_delivery : date_delivery,
            supplier_id : supplier_id,
            sales_des_id : sales_des_id,
            content_id : content_id,
            stock_id : stock_id,
            stock_address : stock_address,
            product_id : product_id,
            product_name : product_name,
            product_amount : product_amount,
            product_price_list : product_price_list,
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

$('#save-provisional').click(function(){
  if (!validator || !form.valid()) {
        return false;
    }

    $( ".product_id").each(function() {
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
      
  });
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

  var sales = $('#sales_des_id').val();
  if( sales == ''){
      return false;
  }

  var order_id = $('.order_id').val();
  var user_id = $('#user_id').val();
  var date_create = $('#date_create').val();
  var date_delivery = $("#date_delivery").val();
  var supplier_id = $('#supplier_id').val();
  var sales_des_id = $('#sales_des_id').val();
  var content_id = $('#content_id').val();
  var stock_id = $('#stock_id').val();
  var stock_address = $('#stock_address').val();
  var product_id = '';
  var product_name = '';
  var product_amount = '';
  var product_price_list = '';
  var comment_product = '';
  var discount = $('.discount').val();
  var comment = $('#comment').val();
  for(var i=0;i < document.getElementsByClassName('product').length;i++){
    if(i==0){
      product_id += $('.product').eq(i).find('.real_id').val();
      product_name += $('.product').eq(i).find('.product_name').text();
      product_amount += $('.product').eq(i).find('.amount').val();
      product_price_list += parseFloat($('.product').eq(i).find('.price_unit').text());
      comment_product += $('.product').eq(i).find('.comment_product').val();
    }else{
      product_id += '|'+$('.product').eq(i).find('.real_id').val();
      product_name += '|'+$('.product').eq(i).find('.product_name').text();
      product_amount += '|'+$('.product').eq(i).find('.amount').val();
      product_price_list += '|'+parseFloat($('.product').eq(i).find('.price_unit').text());
      comment_product += '|'+$('.product').eq(i).find('.comment_product').val();
    }
  }
  $(this).helloWorld('発注伝票（新規）を保存します。よろしいですか？',base_url+'purchase',null,{
        url: base_url+"purchase/ajax_save_order",
        data : {
            order_id : order_id,
            user_id : user_id,
            date_create : date_create,
            date_delivery : date_delivery,
            supplier_id : supplier_id,
            sales_des_id : sales_des_id,
            content_id : content_id,
            stock_id : stock_id,
            stock_address : stock_address,
            product_id : product_id,
            product_name : product_name,
            product_amount : product_amount,
            product_price_list : product_price_list,
            product_comment : comment_product,
            discount : discount,
            comment : comment,
            status : 0
        },
        error_message: '出庫伝票（新規）を保存します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
});
/*---------------------------Begin Display products table when product_id is focus --------------------------------*/
/*$('table').on('click','.product_id',function(e){
    $(".detail-product").remove();
    
var arr1 = [];
$(".product_id").each(function() {
  arr1.push($(this).val());
});

var table1='';
    table1+='<table class="detail-product">';

for(var i in filter_product){
  var check = false;
  arr1.forEach(function(element) {
  if(filter_product[i].id==element){

    check = true;
  }
  });
if(!check){
    table1+='<tr>'+'<td>'+filter_product[i].id+'</td>'+'<td>'+filter_product[i].name+'</td>'+'</tr>';
  }
}
table1+='</table>';

$(this).after(table1);

    $('.detail-product').css('display','block');

    e.stopPropagation();
});*/

/*---------------------------End Display products table when product_id is focus --------------------------------*/
/*---------------------------Begin Hide detail-product table when click outside --------------------------------*/
/*$(document).click(function(e) {
  if( e.target.class != 'product_id') {
    $(".detail-product").hide();
    e.stopPropagation();
  }
});*/
/*---------------------------End Hide detail-product table when click outside --------------------------------*/


/*__Add del class when input is focused */ 
$('#add-purchase-table').on('focus','input[type="text"]',function(){
  if (!$(this).hasClass("not-edit")) {
    $('table tr').removeClass('del');
    $(this).parent().parent().addClass('del');
  }
})
/*__End add del class when input is focused */ 
//__Datepicker limit old date
  /*$('.datepicker_').datepicker({
      dateFormat:'yy/mm/dd',
      changeMonth: true,
      changeYear: true,
      minDate: 0,
    }).attr('readonly','readonly');*/
//__Destination 

$('#date_create').datepicker({
    dateFormat:'yy/mm/dd',
    changeMonth: true,
    changeYear: true,
    minDate : 0,
    onSelect: function () {
        var dt_to = $('#date_delivery');
        var minDate = $(this).datepicker('getDate');
        dt_to.datepicker('option', 'minDate', minDate); 
    }
}).attr('readonly','readonly');

$('#date_delivery').datepicker({
    dateFormat:'yy/mm/dd',
    changeMonth: true,
    changeYear: true,
    minDate : 0,
    onSelect: function () {
        var dt_from = $('#date_create');
        var maxDate = $(this).datepicker('getDate');
        dt_from.datepicker('option', 'maxDate', maxDate);
    }
}).attr('readonly','readonly');

$('#sales_des_id').change(function(){
  if($(this).val()!==''){
    $(this).closest('div').find('.popup').remove();
  } else {
    $(this).closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
  }
})

//__Don't allow typing text, only number
$('#add-purchase-table').on('keypress','.amount,.discount,.product_id',function(event){
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
      return true;
    }
});

function find_buy_code_by_id(real_id) {
  for(var i in filter_product){
    if(filter_product[i].id == real_id) return filter_product[i].buy_code;
  }
}