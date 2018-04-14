var numRow = 1;
/*$('#insert-export-row').click(function(){
    var select_id_product = $(".product_list").eq(0).html();
    select_id_product = select_id_product.replace('selected','');
    select_id_product = select_id_product.replace('<option','<option selected');

    $('table tbody tr:last')
            .before("<tr class='detail-product'>" +
       "<td class='id_product'><select class='product_list' name='product_list'>"+ select_id_product +"</select></td><td class='product_name'></td><td class='color'></td><td class='standard'></td><td class='price'></td><td class='total_stock_product'></td><td><input class='amount_export' value='50'/></td><td class='total_price'></td>" 
       + '</tr>');
    return false;
    
});

$('#remove-export-row').click(function(){
    $('.del').remove();
    return false;
});*/

/*--------------------------------------Product detail table----------------------------------------------*/
    var table='';
    table+='<table class="detail-product">';
    for(i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].商品ID+'</td>'+'<td>'+json_product_list[i].仕入商品名+'</td>'+'</tr>';
      }
    table+='</table>';   
    ///$('.product_id').after(table);
    product_table=table;
/*--------------------------------------End product detail table-------------------------------------------*/
/*---------------------------Display products table when product_id is focus --------------------------------*/
$('table').on('click','.product_id',function(e){
    $(".detail-product").remove();
    $(this).after(product_table);
    var table=$(this).next();
    $(table).css('display','block');
    e.stopPropagation();
})
/*---------------------------End display products table when product_id is focus --------------------------------*/
/*---------------------------Hide detail-product table when click outside --------------------------------*/
$(document).click(function(e) {
  if( e.target.class != 'product_id') {
    $(".detail-product").hide();
    e.stopPropagation();
  }
});
/*---------------------------End hide detail-product table when click outside --------------------------------*/
/*---------------------------Display information of product when select product --------------------------*/
$('#export-table').on('click','.detail-product tr',function(){
var val=$(this).children("td:first").text();
$prod=$(this).closest('div');
$prod.find('.product_id').val(val);
$('.detail-product').hide();
//Display detail product when selected
$table=$prod.closest('.product');
 for(i in json_product_list){
    if(json_product_list[i].商品ID==val){
        $table.find('td[data-name]')        .text(json_product_list[i].仕入商品名);
        $table.find('td[data-color]')       .text(json_product_list[i].色調);
        $table.find('td[data-standard]')    .text(json_product_list[i].規格);
        $table.find('td[data-stock]').text(json_product_list[i].total_stock_product);
        $table.find('td[data-price-unit]')  .text(json_product_list[i].price_unit);
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
$('#export-table').on('keyup','.product_id',function(){
input =$(this).val();
  filter = input.toUpperCase();
  tr = $(".detail-product tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
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
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/></div></td>';
      tr +=  `<td class='product_name' data-name></td>
              <td data-color class='color'></td>
              <td data-standard class="standard"></td>
              <td data-price class="price"></td>
              <td data-stock class="total_stock_product"></td>
              <td><input  type="text" class="amount_export"/></td> 
              <td class="total_price"></td>`;
      tr += '</tr>';
      $('.del').after(tr);
      return false;
});
/*------------------------------------End Add row purchase order ----------------------------------------*/
$('#export-table').on('focus','input[type="text"]',function(){
  $('table tr').removeClass('del');
  $(this).parent().parent().addClass('del');
})





$(".SALES_DESTINATION_SELECT").on('change',function(){
    console.log('SALES_DESTINATION_SELECT is change');
  $.post(base_url+"purchase/ajax_get_list_product",
    {
        id:this.value,
        warehouse_id : $('#order_id').val()
    },
    function(data, status){
        product_list = JSON.parse(data);
        var string_option = '<option selected disabled></option>';
        //alert(product_list.id3.商品ID);
        Object.keys(product_list).forEach(function(k){
        string_option += "<option value='" + product_list[k].商品ID +"'>"+product_list[k].商品ID+"</option>";
        });
        $(".product_list").html(string_option);
    });
});

$("#export-table").on('change','.product_list',function(){
  var rowProduct = $(this).parent().parent();
  console.log(product_list["id"+this.value].商品名);
  rowProduct.find('.product_name').text(product_list["id"+this.value].商品名);
  rowProduct.find('.color').text(product_list["id"+this.value].色調);
  rowProduct.find('.standard').text(product_list["id"+this.value].規格);
  rowProduct.find('.price').text(product_list["id"+this.value].price);
  rowProduct.find('.total_stock_product').text(product_list["id"+this.value].total_stock_product);
  rowProduct.find('.amount_export').val(50);
  //rowProduct.find('.total_price').text(product_list["id"+this.value].色調);
  var total_price = instant_total_price(this.value);
  rowProduct.find('.total_price').text(total_price);
  update_sum_total_price();
});

$("#export-table").on("keyup",".amount_export",function(){
    var total_price = 0;
    var row = $(this).parent().parent();
    var product_id = row.find('input').val();
    if(tolinen_sale == 0){
        var FIFO = get_total_price_2(this.value,product_id);
        total_price = FIFO['total_price'];
        price_unit = FIFO['price_unit'];
    }else{
        price_unit = json_product_list["id"+product_id].price;
        total_price = price_unit*this.value;
    }
    row.find('.price').text(price_unit);
    row.find('.total_price').text(total_price);
    update_sum_total_price();
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
/*--------------------------------------Validation exporting amount------------------------------------------------*/
$('#export-table').on('keyup blur','.amount_export',function(){
    $('#export-table').find('.popup').remove();
   
    var stock = parseInt($(this).closest('tr').find('.total_stock_product').text());
    var amount_export = parseInt($(this).val());

    if(amount_export <= 0 || isNaN(amount_export)){
        $(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
        $(this).focus();
        $('.save-export-order').addClass('error');
        //return return_number_valid ;
    } else if(amount_export > stock){
        $(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">出庫量は在庫量の数値以下を入力してください。</span></div>');
        $(this).focus();
        $('.save-export-order').addClass('error');
    }
    else{
         $('#export-table').find('.popup').remove();
         $('.save-export-order').removeClass('error');
    }
}) 
/*-------------------------------------End validation exporting amount------------------------------------------*/
//khi nhấn nút lưu
$(".save-export-order").click(function(){

    if($('.save-export-order').hasClass('error')){
        return false;
    }

    var voter_id = $("#voter_id").val();//người cấp phiếu
    var issuer_id = $(".ship_issuer").val();// người xuất kho
    var date = $(".datepicker_").val();//ngày xuất hàng
    var sales_distination_id = $(".SALES_DESTINATION_SELECT").val();// nơi bán hàng
    var content_id = $(".content-processing").val(); // nội dung xuất hàng
    var note = $(".note").val(); // ghi chú
    var product_id_list = ''; // danh sách id sản phẩm
    var amount_export_list = ''; // danh sách số lượng sản phẩm
    var price_list = ''; // danh sách tổng giá sản phẩm

    var product_id = document.getElementsByClassName("product_id");
    for (var i = 0; i < product_id.length; i++) {
        var e=product_id[i];
        if(i==0) product_id_list += e.value;
        else product_id_list += "|"+e.value
    } // checked
    console.log(product_id_list);
    var amount_export = document.getElementsByClassName("amount_export");
    for (var i = 0; i < amount_export.length; i++) {
        var e=amount_export[i];
        if(i==0) amount_export_list += e.value;
        else amount_export_list += "|"+e.value;
    } // checked
    console.log(amount_export_list);
    var price = document.getElementsByClassName("price");
    for (var i = 0; i < price.length; i++) {
        var e = price[i];
        if(i==0) price_list += e.innerHTML;
        else price_list += "|"+e.innerHTML
    }

    /*$(this).helloWorld('出庫伝票（編集）を保存します。よろしいですか？',null,null,{
        url: base_url+"purchase/ajax_edit_export_order",
        data : {
            a_warehouse_id : $(".warehouse_id").val(), // id hóa đơn xuất hàng
            a_voter_id : voter_id, // id người cấp phiếu
            a_issuer_id : issuer_id, // id người xuất kho
            a_date : date, // ngày xuất kho
            a_sales_distination_id : sales_distination_id, // id nơi bán hàng
            a_content_id : content_id, // id nội dung giao hàng
            a_note : note, // ghi chú
            a_product_id_list : product_id_list, // danh sách id sản phẩm
            a_amount_export_list : amount_export_list, // danh sách số lượng sản phẩm
            a_price_list : price_list // danh sách giá tiền
        },
        error_message: '出庫伝票（新規）を保存します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });*/
    $.post(base_url+"purchase/ajax_edit_export_order",{
        a_warehouse_id : $(".warehouse_id").val(), // id hóa đơn xuất hàng
        a_voter_id : voter_id, // id người cấp phiếu
        a_issuer_id : issuer_id, // id người xuất kho
        a_date : date, // ngày xuất kho
        a_sales_distination_id : sales_distination_id, // id nơi bán hàng
        a_content_id : content_id, // id nội dung giao hàng
        a_note : note, // ghi chú
        a_product_id_list : product_id_list, // danh sách id sản phẩm
        a_amount_export_list : amount_export_list, // danh sách số lượng sản phẩm
        a_price_list : price_list // danh sách giá tiền
    },
    function(data,status){
        alert(data);
    });
});
function get_total_price(value,product_id) {
    var price_list = json_product_list['id'+product_id].array_price_at_date;
    var amount_list = json_product_list['id'+product_id].array_amount_at_date;
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

/*-------------------------------------------------------Begin Validation --------------------------------------------*/
$("form[name='add_purchase_order']").validate();


function get_total_price_2 (value,product_id) {
    var price_list = json_product_list['id'+product_id].array_price_at_date;
    var amount_list = json_product_list['id'+product_id].array_amount_at_date;
    console.log('price list:'+price_list);
    console.log('amount_list:'+amount_list);
    var arr_price = price_list.split("|").map(Number);
    var arr_amount = amount_list.split("|").map(Number);
    var price_unit = ''; //liệt kê đơn giá
    var total_price = 0;
    var i = 0;
    var n = 0;
    var price = [];
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

function sum_arr(a,b) {
    return a+b;
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

//-->Datepicker limit old date
  $('.datepicker_').datepicker({
      dateFormat:'yy/mm/dd',
      changeMonth: true,
        changeYear: true,
      minDate: 0
    }).attr('readonly','readonly');
