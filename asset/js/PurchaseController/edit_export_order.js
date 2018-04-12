var numRow = 1;
var amount_first = null;
var amount_last = null;
var amount_plus = null;
var filter_product = [];
$(document).ready(function(){
    amount_first = get_amount();
    console.log(amount_first);
});


/*--------------------------------------Product detail table----------------------------------------------*/
/*    var table='';
    table+='<table class="detail-product">';
    for(i in product_list){
      table+='<tr>'+'<td>'+product_list[i].商品ID+'</td>'+'<td>'+product_list[i].仕入商品名+'</td>'+'</tr>';
      }
    table+='</table>';   
    ///$('.product_id').after(table);
    product_table=table;*/
    //__Get list product and push json
    for(var i in json_product_list){
      var obj = {
        'id': json_product_list[i].商品ID,
        'name': json_product_list[i].仕入商品名,
        'buy_code': json_product_list[i].buy_code
      }
      filter_product.push(obj);
    }
/*--------------------------------------End product detail table-------------------------------------------*/
/*---------------------------Display products table when product_id is focus --------------------------------*/
$('table').on('click','.product_id',function(e){
/*    $(".detail-product").remove();
    $(this).after(product_table);
    var table=$(this).next();
    $(table).css('display','block');
    e.stopPropagation();*/
})
/*---------------------------End display products table when product_id is focus --------------------------------*/
/*---------------------------Hide detail-product table when click outside --------------------------------*/
$(document).click(function(e) {
/*  if( e.target.class != 'product_id') {
    $(".detail-product").hide();
    e.stopPropagation();
  }*/
});
/*---------------------------End hide detail-product table when click outside --------------------------------*/
/*---------------------------Display information of product when select product --------------------------*/
$('#export-table').on('click','.detail-product tr',function(){
var val=$(this).children("td:first").text();
var real_id = $(this).find('input').val();
$prod=$(this).closest('div');
$prod.find('.real_id').val(real_id);
$prod.find('.product_id').val(val);
$('.detail-product').hide();
//Display detail product when selected
$table=$prod.closest('.product');
 for(i in json_product_list){
    if(json_product_list[i].商品ID==real_id){
        $table.find('td[data-name]')        .text(json_product_list[i].仕入商品名);
        $table.find('td[data-color]')       .text(json_product_list[i].色調);
        $table.find('td[data-standard]')    .text(json_product_list[i].規格);
        $table.find('td[data-stock]').text(json_product_list[i].total_stock_product);
        $table.find('td[data-price]')  .text(json_product_list[i].price);
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
/*----------------------End display information of product when select ------------------------------*/
/*---------------Search value by input -----------------*/ 
$('#export-table').on('keyup','.product_id',function(e){
    var input = this.value;
    var filter = input.toUpperCase();
    var prod =  $(this).closest('div');
    var tr = prod.find(".detail-product tr");
    if(input != ''){
    for (var i = 0; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            } else {
            tr[i].style.display = "none";
            
            var numOfVisibleRows = $('.detail-product tbody > tr').filter(function() {
                return $(this).css('display') !== 'none';
                }).length;
            console.log(numOfVisibleRows);
            if(numOfVisibleRows == 0){
                $('.detail-product').hide();
            }
            }
          } 
        }//__End for 
    }else{
        tr.css("display",'');
    }
    
    prod.find('.detail-product').show();
    //__Display detail of product when press enter
    if (e.keyCode == 13) {
    //__Get number row display
    var numOfVisibleRows = $('.detail-product tbody > tr').filter(function() {
        return $(this).css('display') !== 'none';
        }).length;
        //__Display detail if a row
        if(numOfVisibleRows == 1)
        {
            $(".detail-product tbody > tr:visible").addClass('active');
            var val=$(".active > td:first").text();
            var real_id = $(".active > input").val();
            console.log(val);
            $(this).val(val);
            var table = $(this).closest('tr');
            table.find('.real_id').val(real_id);
            var stock_id = $('.stock_from').val();  
            for(i in json_product_list){
                if(json_product_list[i].商品ID==real_id){
                    table.find('td[data-name]')        .text(json_product_list[i].仕入商品名);
                    table.find('td[data-color]')       .text(json_product_list[i].色調);
                    table.find('td[data-standard]')    .text(json_product_list[i].規格);
                    table.find('td[data-stock]').text(json_product_list[i].total_stock_product);
                    table.find('td[data-price]')  .text(json_product_list[i].price);
                }
            };
            $('.detail-product').remove();
      }
   } 
})
/*--------------End search value by input -----------------*/ 
/*------------------------------------Begin Add row purchase order ----------------------------------------*/
$('#insert-export-row').click(function(){
  var select_product = "<input class='product_id'>";
  var table='';
    table+='<table class="detail-product">';
    for(i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].name+'</td>'+'</tr>';
      }
    table+='</table>';  
  var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/><input class="real_id" type="hidden"/></div></td>';
      tr +=  "<td class='product_name' data-name></td>"
              +"<td data-color class='color'></td>"
              +"<td data-standard class='standard'></td>"
              +"<td data-price class='price'></td>"
              +"<td data-stock class='total_stock_product'></td>"
              +"<td><input  type='text' class='amount_export'/></td>" 
              +"<td class='total_price'></td>";
      tr += '</tr>';
      $('.del').after(tr);
      return false;
});

/*$("table").on('click','.product',function(){
  $(this).find(".amount_export").focus();
});*/

/*------------------------------------End Add row purchase order ----------------------------------------*/
$('#export-table').on('focus','input[type="text"]',function(){
  $('table tr').removeClass('del');
  $(this).parent().parent().addClass('del');
})
$('#remove-export-row').click(function(){
    $('.del').remove();
    if($('.product').length == 0){
        var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/><input class="real_id" type="hidden"/></div></td>';
      tr +=  "<td class='product_name' data-name></td>"
              +"<td data-color class='color'></td>"
              +"<td data-standard class='standard'></td>"
              +"<td data-price class='price'></td>"
              +"<td data-stock class='total_stock_product'></td>"
              +"<td><input  type='text' class='amount_export'/></td>" 
              +"<td class='total_price'></td>";
      tr += '</tr>';
      $('tbody').prepend(tr);
    }
    update_sum_total_price();
    return false;
});

$(".SALES_DESTINATION_SELECT").on('change',function(){
    console.log('SALES_DESTINATION_SELECT is change');
  $.post(base_url+"purchase/ajax_get_list_product",
    {
        id:this.value,
        warehouse_id : $('#order_id').val()
    },
    function(data, status){
        json_product_list = JSON.parse(data);
        var string_option = '<option selected disabled></option>';
        //alert(product_list.id3.商品ID);
        Object.keys(json_product_list).forEach(function(k){
        string_option += "<option value='" + json_product_list[k].商品ID +"'>"+json_product_list[k].商品ID+"</option>";
        });
        $(".product_list").html(string_option);
    });
});

$("#export-table").on('change','.product_list',function(){

  var rowProduct = $(this).parent().parent();
  var total_price = 0;
    price_unit = product_list["id"+this.value].price;

  console.log(product_list["id"+this.value].商品名);
  rowProduct.find('.product_name').text(product_list["id"+this.value].name);
  rowProduct.find('.color').text(product_list["id"+this.value].色調);
  rowProduct.find('.standard').text(product_list["id"+this.value].規格);
  rowProduct.find('.price').text(price_unit);
  rowProduct.find('.total_stock_product').text(product_list["id"+this.value].total_stock_product);
  rowProduct.find('.amount_export').val(0);
  //rowProduct.find('.total_price').text(product_list["id"+this.value].色調);
  var total_price = instant_total_price(this.value);
  rowProduct.find('.total_price').text(0);
  update_sum_total_price();
});

$("#export-table").on("keyup",".amount_export",function(){
    var total_price = 0;
    var row = $(this).parent().parent();
    var product_id = row.find('.product_id').val();
    var real_id = row.find('.real_id').val();
    var exporting_number = $(this).val();
    var stock_number  = parseInt($(this).parent().prev().text());
    if(exporting_number == ''){
        $(this).closest('td').css('position','relative');
        $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
        $('table').addClass('error');
    } else if(exporting_number > 0){
        $('table').removeClass('error');
        $(this).closest('td').find('.popup').remove();
            if(exporting_number > stock_number){
              $(this).closest('td').css('position','relative');
              $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">在庫量の値以下で入力してください。</span></div>');
              $('table').addClass('error');
        } else {

            if(tolinen_sale == 0){
                var FIFO = get_total_price_2(this.value,real_id);
                total_price = FIFO['total_price'];
                price_unit = FIFO['price_unit'];
            }else{
                price_unit = json_product_list["id"+real_id].price;
                total_price = price_unit*this.value;
            }
            row.find('.price').text(price_unit);
            row.find('.total_price').text(total_price);
            update_sum_total_price();
        }
    } else {
      $(this).closest('td').css('position','relative');
      $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
      $('table').addClass('error');
    }    

});

//khởi tạo tính tổng giá trị ban đầu khi số lượng sản phẩm bằng 50
function instant_total_price(product_id){
    var total_price = 0;
    var row = $(this).parent().parent();
    //var product_id = row.find('select').val();
    var price_list = product_list['id'+product_id].array_price_at_date;
    var amount_list = product_list['id'+product_id].array_amount_at_date;
    var arr_price = price_list.split("|");
    var arr_amount = amount_list.split("|");
    var i = 0;
    var amount = 0;
    while( amount < 50 ){
        if(amount + parseInt(arr_amount[i]) > 50){
            total_price += (50-amount)*parseInt(arr_price[i]);
        }else{
            total_price += parseInt(arr_amount[i])*parseInt(arr_price[i]);
        }
        amount += parseInt(arr_amount[i]);
        i++;
    }
    return total_price;
}

//update cộng tổng tiền
function update_sum_total_price(){
    var sum_total_price = 0;
    var total_price = $("tbody").find(".total_price");
    for (var i = 0; i < total_price.length; i++) {
        sum_total_price += Number(total_price[i].innerHTML);
    }
    $(".sum_total_price").text(sum_total_price);
}

//khi nhấn nút lưu
$(".save-export-order").click(function(){
    amount_last = get_amount();
    amount_plus = get_amount_plus(amount_first,amount_last);

    var voter_id = $("#voter_id").val();//người cấp phiếu
    var issuer_id = $(".ship_issuer").val();// người xuất kho
    var date = $(".date_export").val();//ngày xuất hàng
    var sales_distination_id = $(".SALES_DESTINATION_SELECT").val();// nơi bán hàng
    var content_id = $(".content-processing").val(); // nội dung xuất hàng
    var note = $(".note").val(); // ghi chú
    var update_date = $("#update_date").val();
    var product_id_list = ''; // danh sách id sản phẩm
    var amount_export_list = ''; // danh sách số lượng sản phẩm
    var price_list = ''; // danh sách tổng giá sản phẩm

    var product_id = document.getElementsByClassName("real_id");

  //check_required('product_id');
  check_required('amount_export');
  if(!check_valid()){
    return false;
  }
    for (var i = 0; i < product_id.length; i++) {
        var e=product_id[i];
        if(i==0) product_id_list += e.value;
        else product_id_list += "|"+e.value;
    } // checked
    console.log("real_id:"+product_id_list);
    var amount_export = document.getElementsByClassName("amount_export");
    for (var i = 0; i < amount_export.length; i++) {
        var e=amount_export[i];
        if(i==0) amount_export_list += e.value;
        else amount_export_list += "|"+e.value;
    } // checked

    var price = document.getElementsByClassName("price");
    for (var i = 0; i < price.length; i++) {
        var e = price[i];
        if(i==0) price_list += e.innerHTML;
        else price_list += "|"+e.innerHTML;
    }

    $(this).helloWorld('出庫伝票（編集）を保存します。よろしいですか？',base_url+"purchase/export-purchase",null,{
        url: base_url+"purchase/ajax_edit_export_order",
        data : {
            a_warehouse_id : $(".warehouse_id").val(), // id hóa đơn xuất hàng
            a_voter_id : voter_id, // id người cấp phiếu
            a_issuer_id : issuer_id, // id người xuất kho
            a_date : date, // ngày xuất kho
            a_sales_distination_id : sales_distination_id, // id nơi bán hàng
            stock_id : $('#stock_id').val(),
            a_content_id : content_id, // id nội dung giao hàng
            a_note : note, // ghi chú
            update_date : update_date,
            a_product_id_list : product_id_list, // danh sách id sản phẩm
            a_amount_export_list : amount_export_list, // danh sách số lượng sản phẩm
            a_price_list : price_list, // danh sách giá tiền
            tolinen_sale : $('#tolinen_sale').val(),
            amount_plus : amount_plus
        },
        error_message: '出庫伝票（新規）を保存します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
    /* $.post(base_url+"purchase/ajax_edit_export_order",{
        a_warehouse_id : $(".warehouse_id").val(), // id hóa đơn xuất hàng
        a_voter_id : voter_id, // id người cấp phiếu
        a_issuer_id : issuer_id, // id người xuất kho
        a_date : date, // ngày xuất kho
        a_sales_distination_id : sales_distination_id, // id nơi bán hàng
        stock_id : $('#stock_id').val(),
        a_content_id : content_id, // id nội dung giao hàng
        a_note : note, // ghi chú
        update_date : update_date,
        a_product_id_list : product_id_list, // danh sách id sản phẩm
        a_amount_export_list : amount_export_list, // danh sách số lượng sản phẩm
        a_price_list : price_list, // danh sách giá tiền
        tolinen_sale : $('#tolinen_sale').val(),
        amount_plus : amount_plus
    },
    function(data,status){
        console.log(data);
    }); */
});
function get_total_price(value,product_id) {
    var price_list = product_list['id'+product_id].array_price_at_date;
    var amount_list = product_list['id'+product_id].array_amount_at_date;
    console.log('amount_list: '+amount_list);
    console.log('price_list: '+price_list);
    var arr_price = price_list.split("|");
    var arr_amount = amount_list.split("|");
    var total_price = 0;
    var i = 0;
    var amount = 0;
    while( amount < value ){
        if(amount + parseInt(arr_amount[i]) > value){
            total_price += (value-amount)*parseInt(arr_price[i]);
        }else{
            total_price += parseInt(arr_amount[i])*parseInt(arr_price[i]);
        }
        amount += parseInt(arr_amount[i]);
        i++;
    }
    return total_price;
}

function get_total_price_2 (value,product_id) {
    var price_list = json_product_list['id'+product_id].array_price_at_date;
    var amount_list = json_product_list['id'+product_id].array_amount_at_date;
    console.log('price list:'+price_list);
    console.log('amount_list:'+amount_list);
    var arr_price = price_list.split("|").map(Number);
    var arr_amount = amount_list.split("|").map(Number);
    var price_unit = ''; //liệt kê đơn giá
    var total_price = 0;
    var price = [];
    var i = 0;
    var n = 0;
    total_amount = arr_amount.reduce(sum_arr,0);//tổng số lượng nhập kho
    console.log('total_amount='+total_amount);
    if(parseInt(value) > total_amount){
        return {'total_price':total_price,'price_unit':'vượt quá số lượng trong kho'};
    }
    while( n < parseInt(value) ){
            if((parseInt(value) - parseInt(n)) > arr_amount[i]){
                //price_unit += arr_amount[i]+'c'+arr_price[i]+'đ';
                total_price += parseInt(arr_amount[i])*parseInt(arr_price[i]);
                price = get_price_unit(price,arr_amount[i],arr_price[i]);
                n += arr_amount[i];
                i++;
                continue;
            }else{
                var amount = parseInt(value)-parseInt(n);
                //price_unit += amount+'c'+arr_price[i]+'đ';
                total_price += parseInt(amount)*parseInt(arr_price[i]);
                price = get_price_unit(price,amount,arr_price[i]);
                n = value;
            }
    }
    price_unit = export_price_unit_to_string(price);
    return {'total_price':total_price,'price_unit':price_unit};
}

//đưa giá và số lượng sản phẩm vào mảng
function get_price_unit(arr,amount,price) {
    var has_import = false;
    for(i in arr){
        if(arr[i].price == price){
            arr[i].amount += amount;
            has_import = true;
        }
    }
    if(has_import == false){
        arr.push({price: price,amount: amount})
        console.log('length :'+arr.length);
    }
    return arr;
}

//đưa dữ liệu đơn giá sản phẩm ra chuỗi
function export_price_unit_to_string(arr) {
    var unit_price_list = '';
    for(i in arr){
        if(i == 0) unit_price_list += arr[i].price+"("+arr[i].amount+")";
        else unit_price_list += ","+arr[i].price+"("+arr[i].amount+")";
    }
    if(arr.length == 1) return arr[0].price;
    return unit_price_list;
}

function sum_arr(a,b) {
    return a+b;
}

function get_amount() {
    var amount = '';
    $.each(document.getElementsByClassName('amount_export'),function(id,val){
        if(id==0) amount += $('.amount_export').eq(id).val();
        else amount += '|'+$('.amount_export').eq(id).val();

    });
    return amount;
}

function get_amount_plus(first,last) {
    var amount_plus = '';
    var amount_first = first.split('|');
    var amount_last = last.split('|');
    for(i in amount_last){
        if(amount_first[i] == null) amount_first[i] = 0;
        if(amount_last[i] == null) amount_last[i] = 0;
        if(i==0) amount_plus += String(parseInt(amount_first[i]) - parseInt(amount_last[i]));
        else amount_plus += "|"+String(parseInt(amount_first[i]) - parseInt(amount_last[i]));
    }
    console.log("amount plus = "+amount_plus);
    return amount_plus;
}

function get_option_id_product() {
    var string_option = '<option></option>';
    Object.keys(product_list).forEach(function(k){
        string_option += "<option value='" + product_list[k].商品ID +"'>"+product_list[k].商品ID+"</option>";
        });
    return string_option;
}
$('#export-table').popup_table('export-table',filter_product);
$('#export-table').on('keypress','.amount_export,.product_id',function(event){
    var key = window.event ? event.keyCode : event.which;
    var charStr = String.fromCharCode(key);
  if($('.content-processing').val()==9){
        if( charStr == '-'){
      return true;
    }
     else if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
      return true;
    }
  } else {
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
      return true;
    }
  }
    
    
});

$(".date_export").datepicker({
    dateFormat:'yy/mm/dd',
    changeMonth: true,
    changeYear: true,
}).attr('readonly','readonly');
