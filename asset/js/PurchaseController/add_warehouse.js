var numRow = 1;
var tolinen_sale = null;//check có phải xuất cho tolinen hay ko
var product_table = null;
var json_product_list = null;
var filter_product = [];
$('#insert-export-row').click(function(){
  var select_product = "<input class='product_id'>";
  var table='';
  //__Get number of row which is empty
  var $nonempty = $('.amount_export').filter(function() {
      return this.value == ''
    });
  $( ".amount_export").each(function() {
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
    table+='<table class="detail-product">';
    for(var i in json_product_list){
      table+='<tr>'+'<td>'+json_product_list[i].name+'</td>'+'</tr>';
      }
    table+='</table>';  
  var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/><input type="hidden" class="real_id"/></div></td>';
      tr += "<td class='product_name' data-name></td><td class='color' data-color></td><td class='standard' data-standard></td><td class='price' data-price></td><td class='total_stock_product' data-stock></td><td data-amount><input class='amount_export' value=''/></td><td class='total_price'></td>";

      tr += '</tr>';
      $('.del').after(tr);
      return false;
  }  
});//__End insert row

/*$("table").on('click','.product',function(){
  $(this).find(".amount_export").focus();
});*/

$('#remove-export-row').click(function(){
    $('.del').remove();
    if($(".product").length == 0){
      var tr = "<tr class='product'>";
      tr += '<td><div class="wrap"><span class="input-triangle"><b></b></span><input class="product_id"/><input type="hidden" class="real_id"/></div></td>';
      tr += "<td class='product_name' data-name></td><td class='color' data-color></td><td class='standard' data-standard></td><td class='price' data-price></td><td class='total_stock_product' data-stock></td><td data-amount><input class='amount_export' value=''/></td><td class='total_price'></td>";

      tr += '</tr>';
      $('tbody').prepend(tr);
    }
    update();
    return false;
});//__End remove row

var product_list;
$(".SALES_DESTINATION_SELECT").on('change',function(){
  /*$.post(base_url+"purchase/ajax_get_list_product",
    {
        id:this.value
    },
    function(data, status){
        product_list = JSON.parse(data);
        var string_option = '<option disabled selected value></option>';
        //alert(product_list.id3.商品ID);
        if(Object.keys(product_list).length != 0) Object.keys(product_list).forEach(function(k){
        string_option += "<option value='" + product_list[k].商品ID +"'>"+product_list[k].商品ID+"</option>";
        });
        $(".product_list").html(string_option);
    });*/
  //__Remove row when supplier chosed
  $( ".product" ).each(function( index ) {
    if(index > 0){
      $( this ).remove();
    }
  });
  $('.popup').remove();
  $('.product_id,.amount_export,.comment_product').val('');
  $('td[data-color],td[data-standard],td[data-accumulation],.product_name,.price_unit,.price,.total_stock_product,.total_price').text('');
  //__End remove row when supplier chosed
   //$('.wrap').find('table').remove();
    ajax_get_list_product();
});

$(".stock_id").on('change',function(){
    console.log("stock id: "+this.value);
/*    //__Remove row when supplier chosed
  $( ".product" ).each(function( index ) {
    if(index > 0){
      $( this ).remove();
    }
  });
  $('.popup').remove();
  $('.product_id,.amount_export,.comment_product').val('');
  $('td[data-color],td[data-standard],td[data-accumulation],.product_name,.price_unit,.price,.total_stock_product,.total_price').text('');
  //__End remove row when supplier chosed*/
    ajax_get_list_product();
})

$(".stock_from").on('change',function(){
  //__Remove row when supplier chosed
  $( ".product" ).each(function( index ) {
    if(index > 0){
      $( this ).remove();
    }
  });
  $('.popup').remove();
  $('.product_id,.amount_export,.comment_product').val('');
  $('td[data-color],td[data-standard],td[data-accumulation],.product_name,.price_unit,.price,.total_stock_product,.total_price').text('');
  //__End remove row when supplier chosed
    ajax_get_list_product();
})

function ajax_get_list_product() {
    instance_table();
    var stock_id = null;
    stock_id = $('.stock_from').val();
    //console.log("stock_id: "+stock_id);
    var content = $(".content-processing").val();
    if(stock_id && content){
      $(".product_id").addClass('loading');
      $.post(base_url+"purchase/ajax_get_list_product_2",
      {
          id:$('.SALES_DESTINATION_SELECT').val(),//id nơi bán hàng
          stock_id : stock_id,
          order_content : $(".content-processing").val()
      },
      function(data, status){
          //console.log(data);
          json_product_list = JSON.parse(data);
          filter_product.length = 0;
          var check_empty = true;
          var table='';
      product_table=table;
      $('.product_id').removeClass('loading');
      var product_arr = [];
      for(var i in json_product_list){
      var obj = {
        'id': json_product_list[i].商品ID,
        'buy_code': json_product_list[i].buy_code,
        'name': json_product_list[i].name,
      }
      filter_product.push(obj);
    }
    //__Check data wether empty
    if(filter_product.length > 0){
      table+='<table class="detail-product">';
      for(var i in filter_product){
        var check = false;
        product_arr.forEach(function(element) {
        if(filter_product[i].id==element){
          check = true;
        }
      });
      if(!check){
        table+='<tr>'+'<td>'+filter_product[i].id+'</td>'+'<td>'+filter_product[i].name+'</td>'+'</tr>';
      }
      }//__End for
      table+='</table>';
      $('.product_id').removeClass('loading');
      $('.product_id,.amount_export').prop("disabled", false);
    }
    else
    {
      $(this).helloWorld("在庫商品はありません。",null);
      $('.product_id').removeClass('loading');
      $('.product_id,.amount_export').prop("disabled", true);
    }
      });
    }//__End if
}//__End function

$("#export-table").on('change','.product_list',function(){
  var rowProduct = $(this).parent().parent();
  console.log(product_list["id"+this.value].name);
  rowProduct.find('.product_name').text(product_list["id"+this.value].name);
  rowProduct.find('.color').text(product_list["id"+this.value].色調);
  rowProduct.find('.standard').text(product_list["id"+this.value].規格);
  rowProduct.find('.price').text(product_list["id"+this.value].price);
  rowProduct.find('.total_stock_product').text(product_list["id"+this.value].total_stock_product);
  //rowProduct.find('.amount_export').text(product_list["id"+this.value].色調);
  //rowProduct.find('.total_price').text(product_list["id"+this.value].色調);
  var total_price;
  var price_unit;
  if(tolinen_sale){
    var FIFO = get_total_price_2(50,this.value);
    total_price = FIFO['total_price'];
    price_unit = FIFO['price_unit'];
  }else{
    price_unit = product_list["id"+this.value].price;
    total_price = 50*price_unit;
  }
  rowProduct.find('.amount_export').val(50);
  rowProduct.find('.total_price').text(total_price);
  rowProduct.find('.price').text(price_unit);
  update();
});

//khi thay đỏi nội dung xử lý
$('.content-processing').change(function(){
    var user_base = $('#user_base').val();
    if(this.value == 11){
        $('#stock_to').css('display','block');
        $('label[name="stock"]').text('移動元');
    }else{
        $('#stock_to').css('display','none');
         $('label[name="stock"]').text('在庫場所');
    }
    if(this.value == 8){
        tolinen_sale = 0;
        var option = '<option></option>';
        for(var i in sales_des_list){
          if(sales_des_list[i].outsourcing != 0){
            option += "<option value='"+sales_des_list[i].id+"'>"+sales_des_list[i].name+"</option>";
          }
        }
        $('.SALES_DESTINATION_SELECT').html(option);
        $('.SALES_DESTINATION_SELECT').prop('disabled',false);
    }
    else{
        tolinen_sale = 1;
        var option = '';
        for(i in sales_des_list){
          if(sales_des_list[i].outsourcing == 0){
            option += "<option value='"+sales_des_list[i].id+"'>"+sales_des_list[i].name+"</option>";
          }
        }
        $('.SALES_DESTINATION_SELECT').html(option);
        $('.SALES_DESTINATION_SELECT').prop('disabled',true);
    }
    ajax_get_list_product();
        //Hide popup error
        var tooltip = $('.SALES_DESTINATION_SELECT').parent();
        tooltip.find('.tooltip').hide();


});
/*--------------------------------------------------Validation form add warehouse--------------------------------------------*/
$("form[name='add_export_order']").validate();
    $('.SALES_DESTINATION_SELECT').rules('add', { required: true });
        $('.SALES_DESTINATION_SELECT').tooltip({
            trigger: 'manual',
            placement:'top'
        });
    $('#issuer').rules('add', { required: true });
      $('#issuer').tooltip({
          trigger: 'manual',
          placement:'top'
      });
    $('.content-processing').rules('add', { required: true });
        $('.content-processing').tooltip({
            trigger: 'manual',
            placement:'bottom'
        });
    $('.stock_from').rules('add', { required: true });
        $('.stock_from').tooltip({
            trigger: 'manual',
            placement:'bottom'
        });
    $('.stock_to').rules('add', { required: true });
        $('.stock_to').tooltip({
            trigger: 'manual',
            placement:'bottom'
        });
    /*//--Product     
    $('.no-order-table .product_id').each(function() {
        $(this).rules('add', {
            required: true
        });
        $(this).tooltip({
            trigger: 'manual',
            placement:'bottom'
        }); 
    });*/
// Show loading display here
var form = $("form[name='add_export_order']");
// Validation
var validator = form.data("validator");
/*--------------------------------------------------Validation form add warehouse--------------------------------------------*/
//--Validation amount export
$('#export-table').on('keyup blur','.amount_export',function(event){
    //var exporting_number = parseInt($(this).val());
    var exporting_number = $(this).val();
    var stock_number  = parseInt($(this).parent().prev().text());
    var row = $(this).parent().parent();
    var product_id = row.find('.real_id').val();
    /*if(stock_number!=''&&exporting_number!=''){
    if((exporting_number > stock_number ) || exporting_number <= 0 ){
        $(this).parent().find('.popup').remove();
        $(this).parent().append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
        $(this).focus();
        $('.add-export-order').addClass('error');
    } else {
        $(this).parent().find('.popup').remove();
        $('.add-export-order').removeClass('error');
    }
    }*/

    $(this).closest('td').find('.popup').remove();
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
            var total_price = 0;
            var price_unit = '';
            if(tolinen_sale){
                var FIFO = get_total_price_2(this.value,product_id);
                total_price = FIFO['total_price'];
                price_unit = FIFO['price_unit'];
            }else{
                price_unit = json_product_list["id"+product_id].price;
                total_price = price_unit*this.value;
            }
            row.find('.price').text(price_unit);
            row.find('.total_price').text(total_price);
            update();        
        }

    }else if($(".content-processing").val()==9 && exporting_number < 0){
      console.log('afdfd  ');  
      $('table').removeClass('error');
      $(this).closest('td').find('.popup').remove();


      var info_back = get_total_price_back(exporting_number,product_id);
      row.find('.price').text(info_back['price_unit']);
      row.find('.total_price').text(info_back['total_price']);

      update();
    } else {
      $(this).closest('td').css('position','relative');
      $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
      $('table').addClass('error');
    }
    /*if(exporting_number >= 0 ){
        $('table').removeClass('error');
        $(this).closest('td').find('.popup').remove();  
        if(exporting_number > stock_number){
          $(this).closest('td').css('position','relative');
          $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">このフィールドにを入力してください。</span></div>');
          $('table').addClass('error');
        } else {
        var total_price = 0;
        var price_unit = '';
        var row = $(this).parent().parent();
        var product_id = row.find('input').val();
        if(tolinen_sale){
            var FIFO = get_total_price_2(this.value,product_id);
            total_price = FIFO['total_price'];
            price_unit = FIFO['price_unit'];
        }else{
            price_unit = json_product_list["id"+product_id].price;
            total_price = price_unit*this.value;
        }
        row.find('.price').text(price_unit);
        row.find('.total_price').text(total_price);
        update();        
        }
    } else {
        $(this).closest('td').css('position','relative');
        //$(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">このフィールドにを入力してください。</span></div>');
        $('table').addClass('error');
        }*/
    
});


$(".add-export-order").click(function(){
    //var cond = false;
    /*var exporting_number = $('.amount_export').val();
    if(exporting_number==''){
        $('.add-export-order').addClass('error');
        $('.amount_export').parent().append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
    } else {
        $('.add-export-order').removeClass('error');
        $('.add-export-order').find('.popup').remove();
    }*/
    
    if (!validator || !form.valid()) {
        return false;
    }
      check_required('real_id');
      check_required('amount_export');
      if(!check_valid()){
        return false;
      }


    /*if($('.add-export-order').hasClass('error')){
        return false;
    }*/
    var voter_id = $('#voter-id').val();//người cấp phiếu
    var issuer_id = $("#issuer").val();// người xuất kho
    var date = $(".datepicker_").val();//ngày xuất hàng
    var sales_distination_id = $(".SALES_DESTINATION_SELECT").val();// nơi bán hàng
    var content_id = $(".content-processing").val(); // nội dung xuất hàng
    var note = $(".note").val(); // ghi chú
    var product_id_list = ''; // danh sách id sản phẩm
    var amount_export_list = ''; // danh sách số lượng sản phẩm
    var price_list = ''; // danh sách tổng giá sản phẩm

    var product_id = document.getElementsByClassName("real_id");
    for (var i = 0; i < product_id.length; i++) {
        var e=product_id[i];
        if(i==0) product_id_list += e.value;
        else product_id_list += "|" + e.value;
    } // checked
    console.log(product_id_list);
    var amount_export = document.getElementsByClassName("amount_export");
    for (var i = 0; i < amount_export.length; i++) {
        var e=amount_export[i];
        if(i==0) amount_export_list += e.value;
        else amount_export_list += "|" + e.value;
    } // checked

    var price = document.getElementsByClassName("price");//tổng tiền
    for (var i = 0; i < price.length; i++) {
        var e = price[i];
        if(i==0) price_list += e.innerHTML;
        else price_list += "|" + e.innerHTML;
    }

    switch(content_id){
        //khi nội dung xuất kho là chuyển kho
        case '11':
        $(this).helloWorld('出庫伝票（新規）を保存します。よろしいですか？',base_url+"purchase/export-purchase",null,{
            url : base_url+'purchase/ajax_save_move_stock',
            data :    {
                    a_warehouse_id : $(".warehouse_id").val(), // id hóa đơn xuất hàng
                    a_voter_id : voter_id, // id người cấp phiếu
                    a_issuer_id : issuer_id, // id người xuất kho
                    a_date : date, // ngày xuất kho
                    a_sales_distination_id : sales_distination_id, // id nơi bán hàng
                    a_content_id : content_id, // id nội dung giao hàng
                    a_note : note, // ghi chú
                    a_product_id_list : product_id_list, // danh sách id sản phẩm
                    a_amount_export_list : amount_export_list, // danh sách số lượng sản phẩm
                    a_price_list : price_list, // danh sách giá tiền
                    a_status : 1,
                    arr_product_id : product_id_list.split('|'),
                    arr_amount : amount_export_list.split('|'),
                    stock_from : $('.stock_from').val(),
                    stock_to : $('.stock_to').val(),
                    tolinen_sale : tolinen_sale
                },
            error_message: '出庫伝票（新規）を保存します。よろしいですか？',
            ok_text: "Ok",
            cancel_text: 'キャンセル'
        });
        break;

        // điều chỉnh tồn kho
        case '9':
        $(this).helloWorld('出庫伝票（新規）を保存します。よろしいですか？',base_url+"purchase/export-purchase",null,{
            url: base_url+'purchase/ajax_correct_stock',
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
                a_price_list : price_list, // danh sách giá tiền
                stock_id : $('.stock_from').val(),
                a_status : 1,
                tolinen_sale : tolinen_sale
            },
            error_message: '出庫伝票（新規）を保存します。よろしいですか？',
            ok_text: "Ok",
            cancel_text: 'キャンセル'
        });
        break;

        //trường hợp mặc định
        default:
        $(this).helloWorld('出庫伝票（新規）を保存します。よろしいですか？',base_url+"purchase/export-purchase",null,{
            url: base_url+"purchase/ajax_add_warehouse",
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
                a_price_list : price_list, // danh sách giá tiền
                stock_id : $('.stock_from').val(),
                a_status : 1,
                tolinen_sale : tolinen_sale
            },
            error_message: '出庫伝票（新規）を保存します。よろしいですか？',
            ok_text: "Ok",
            cancel_text: 'キャンセル'
        });
    }
});

//lưu tạm
$('.save-provisional').click(function() {
    var exporting_number = $('.amount_export').val();
    if(exporting_number==''){
        $('.add-export-order').addClass('error');
        $('.amount_export').parent().append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
    } else {
        $('.add-export-order').removeClass('error');
        $('.add-export-order').find('.popup').remove();
    }
    
    if (!validator || !form.valid()) {
        return false;
    }
    if($('.add-export-order').hasClass('error')){
        return false;
    }
    var voter_id = $('#voter-id').val();//người cấp phiếu
    var issuer_id = $("#issuer").val();// người xuất kho
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
        else product_id_list += "|" + e.value;
    } // checked
    console.log(product_id_list);
    var amount_export = document.getElementsByClassName("amount_export");
    for (var i = 0; i < amount_export.length; i++) {
        var e=amount_export[i];
        if(i==0) amount_export_list += e.value;
        else amount_export_list += "|" + e.value;
    } // checked

    var price = document.getElementsByClassName("price");//tổng tiền
    for (var i = 0; i < price.length; i++) {
        var e = price[i];
        if(i==0) price_list += e.innerHTML;
        else price_list += "|" + e.innerHTML;
    }

    switch(content_id){
        //khi nội dung xuất kho là chuyển kho
        case '11':
        $(this).helloWorld('出庫伝票（新規）を保存します。よろしいですか？',base_url+"purchase/export-purchase",null,{
            url : base_url+'purchase/ajax_save_move_stock',
            data :    {
                    a_warehouse_id : $(".warehouse_id").val(), // id hóa đơn xuất hàng
                    a_voter_id : voter_id, // id người cấp phiếu
                    a_issuer_id : issuer_id, // id người xuất kho
                    a_date : date, // ngày xuất kho
                    a_sales_distination_id : sales_distination_id, // id nơi bán hàng
                    a_content_id : content_id, // id nội dung giao hàng
                    a_note : note, // ghi chú
                    a_product_id_list : product_id_list, // danh sách id sản phẩm
                    a_amount_export_list : amount_export_list, // danh sách số lượng sản phẩm
                    a_price_list : price_list, // danh sách giá tiền
                    a_status : 0,
                    arr_product_id : product_id_list.split('|'),
                    arr_amount : amount_export_list.split('|'),
                    stock_from : $('.stock_from').val(),
                    stock_to : $('.stock_to').val(),
                    tolinen_sale : tolinen_sale
                },
            error_message: '出庫伝票（新規）を保存します。よろしいですか？',
            ok_text: "Ok",
            cancel_text: 'キャンセル'
        });
        break;

        case '9':
        $.post(base_url+'purchase/ajax_correct_stock',
        {
                    a_warehouse_id : $(".warehouse_id").val(), // id hóa đơn xuất hàng
                    a_voter_id : voter_id, // id người cấp phiếu
                    a_issuer_id : issuer_id, // id người xuất kho
                    a_date : date, // ngày xuất kho
                    a_sales_distination_id : sales_distination_id, // id nơi bán hàng
                    a_content_id : content_id, // id nội dung giao hàng
                    a_note : note, // ghi chú
                    a_product_id_list : product_id_list, // danh sách id sản phẩm
                    a_amount_export_list : amount_export_list, // danh sách số lượng sản phẩm
                    a_price_list : price_list, // danh sách giá tiền
                    a_status : 0,
                    arr_product_id : product_id_list.split('|'),
                    arr_amount : amount_export_list.split('|'),
                    stock_from : $('.stock_from').val(),
                    stock_to : $('.stock_to').val(),
                    tolinen_sale : tolinen_sale
        },function(data,err){
          console.log(data);
        }
        );
        break;

        //trường hợp mặc định
        default:
        $(this).helloWorld('出庫伝票（新規）を保存します。よろしいですか？',base_url+"purchase/export-purchase",null,{
            url: base_url+"purchase/ajax_add_warehouse",
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
                a_price_list : price_list, // danh sách giá tiền
                stock_id : $('.stock_from').val(),
                a_status : 0,
                tolinen_sale : tolinen_sale
            },
            error_message: '出庫伝票（新規）を保存します。よろしいですか？',
            ok_text: "Ok",
            cancel_text: 'キャンセル'
        });
    }
});
$("#export-table1").on("keyup",".amount_export",function(){
    var total_price = 0;
    var price_unit = '';
    var row = $(this).parent().parent();
    var product_id = row.find('select').val();
    if(tolinen_sale){
        var FIFO = get_total_price_2(this.value,product_id);
        total_price = FIFO['total_price'];
        price_unit = FIFO['price_unit'];
    }else{
        price_unit = product_list["id"+product_id].price;
        total_price = price_unit*this.value;
    }
    row.find('.price').text(price_unit);
    row.find('.total_price').text(total_price);
    update();
});

function get_total_price_2 (value,product_id) {
    var price_list = json_product_list['id'+product_id].array_price_at_date;
    var amount_list = json_product_list['id'+product_id].array_amount_at_date;
    console.log('price list:'+price_list);
    console.log('amount_list:'+amount_list);
    //var number_export = json_product_list['id'+product_id].number_export;
    var arr_price = price_list.split("|").map(Number);
    var arr_amount = amount_list.split("|").map(Number);
    var price_unit = ''; //liệt kê đơn giá
    var total_price = 0;
    var price = [];
    var i = 0;
    var n = 0;
    //console.log('number_export='+number_export);
    //console.log('value='+value);
    var total_amount = arr_amount.reduce(sum_arr,0);//tổng số lượng nhập kho
    console.log('total_amount='+total_amount);
    //number_export = 0;
    if(parseInt(value) > total_amount){
        return {'total_price':total_price,'price_unit':''};
    }
    while( n < parseInt(value) ){
        console.log('n='+n);
            if((parseInt(value) - parseInt(n)) > arr_amount[i]){
                //price_unit += arr_amount[i]+'cái giá'+arr_price[i]+'đồng';
                total_price += parseInt(arr_amount[i])*parseInt(arr_price[i]);
                price = get_price_unit(price,arr_amount[i],arr_price[i]);
                n += arr_amount[i];
                i++;
                continue;
            }else{
                var amount = parseInt(value)-parseInt(n);
                console.log('value='+value);
                console.log('amount = value - n = '+amount);
                //price_unit += amount+'cá giá'+arr_price[i]+'đồng';
                price = get_price_unit(price,amount,arr_price[i]);
                total_price += parseInt(amount)*parseInt(arr_price[i]);
                n = value;
            }
    }
    //console.log("length"+price.length);
    //console.log("unit price: " + export_price_unit_to_string(price));
    price_unit = export_price_unit_to_string(price);
    return {'total_price':total_price,'price_unit':price_unit};
}

function get_total_price_back(amount_export,product_id) {
  var n = 0;
  var i = 0;
  var price = [];
  var price_unit = '';
  var total_price = 0;
  var arr_price = json_product_list['id'+product_id].array_price_back_at_date.split("|").map(Number);
  var arr_amount = json_product_list['id'+product_id].array_amount_back_at_date.split("|").map(Number);
  amount_export *= (-1);
  while(n < amount_export){
    if((parseInt(amount_export) - parseInt(n)) > arr_amount[i]){
      total_price += parseInt(arr_amount[i])*parseInt(arr_price[i])*(-1);
      price = get_price_unit(price,arr_amount[i]*(-1),arr_price[i]);
      n += arr_amount[i];
      i++;
    }else{
      var amount = parseInt(amount_export)-parseInt(n);
      price = get_price_unit(price,amount*(-1),arr_price[i]);
      total_price += parseInt(amount)*parseInt(arr_price[i])*(-1);
      n = amount_export;
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
    for(var i in arr){
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
    for(var i in arr){
        if(i == 0) unit_price_list += arr[i].price+"("+arr[i].amount+")";
        else unit_price_list += ","+arr[i].price+"("+arr[i].amount+")";
    }
    if(arr.length == 1) return arr[0].price;
    return unit_price_list;
}

function update() {
    var sum_price = 0;
    for(var i = 0; i < document.getElementsByClassName('product').length; i++){
      if(parseFloat($('.product').eq(i).find('.total_price').text())>0)  sum_price += parseFloat($('.product').eq(i).find('.total_price').text());
    }
    $('#sum').text(sum_price);
}

//--An add 2018-10-01
/*---------------------------Begin Display products table when product_id is focus --------------------------------*/
$('table').on('click','.product_id',function(e){
    $(".detail-product").remove();

    if(product_table!=null){
        $(this).after(product_table);
    }
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
$('#export-table').on('click','.detail-product tr',function(){
var val=$(this).children("td:first").text();
var real_id = $(this).find('input').val();
var prod=$(this).closest('div');
prod.find('.product_id').val(val);
prod.find('.real_id').val(real_id);
$(".detail-product").hide();
prod.parent().find('.popup').remove();
//Jump to amount input
$('.amount').focus();
//Display detail product when selected
var table=prod.closest('.product');
var stock_id = $('.stock_from').val();
$.post(base_url+"purchase/ajax_get_info_export",
{
  product_id : real_id,
  stock_id : stock_id,
  sales_des_id : $('.SALES_DESTINATION_SELECT').val()
},function(data,error) {
  console.log(error);
  console.log(data);
  update_product_info(real_id,JSON.parse(data));
  for(var i in json_product_list){
    if(json_product_list[i].商品ID==real_id){
        table.find('td[data-name]')        .text(json_product_list[i].name);
        table.find('td[data-color]')       .text(json_product_list[i].色調);
        table.find('td[data-standard]')    .text(json_product_list[i].規格);
        table.find('td[data-stock]').text(json_product_list[i].total_stock_product);
        table.find('.amount_export').val('');
        table.find('.total_price').text('');
        //$table.find('.amount_export')  .val(0);
    }
  }
  //console.log(json_product_list);
});

 
    //--Product     
    //$prod.find('.product_id').removeClass('error');
   //Show loading display here
   $(this).closest('div').find('.tooltip').hide();
    var form = $("form[name='add_purchase_order']");
    // Validation
    var validator = form.data("validator"); 
    if (!validator || !form.valid()) { 
        return false;
    }
})
/*---------------End Display information of product when select --------------------*/

/*__Search value by input__*/ 
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
            $.post(base_url+"purchase/ajax_get_info_export",
            {
              product_id : real_id,
              stock_id : stock_id,
              sales_des_id : $('.SALES_DESTINATION_SELECT').val()
            },function(data,error) {
              console.log(error);
              console.log(data);
              update_product_info(real_id,JSON.parse(data));
              for(var i in json_product_list){
                if(json_product_list[i].商品ID==real_id){
                    table.find('td[data-name]')        .text(json_product_list[i].name);
                    table.find('td[data-color]')       .text(json_product_list[i].色調);
                    table.find('td[data-standard]')    .text(json_product_list[i].規格);
                    table.find('td[data-stock]').text(json_product_list[i].total_stock_product);
                    //$table.find('.amount_export')  .val(0);
                }
              }
              //console.log(json_product_list);
            });


            $('.detail-product').remove();
      }
   }    
})
/*--------------End Search value by input -----------------*/ 




//--Datepicker limit old date
  $('.datepicker_').datepicker({
      dateFormat:'yy/mm/dd',
      changeMonth: true,
        changeYear: true,
      minDate: 0
    }).attr('readonly','readonly');
//Insert row export order
$('#export-table').on('focus','.amount_export',function(){
    $('table tr').removeClass('del');
    $(this).parent().parent().addClass('del');
});

function update_product_info(product_id,object_info) {
  console.log(object_info);
  for(var i in json_product_list){
    if(json_product_list[i].商品ID == product_id){
      json_product_list[i].total_stock_product = object_info['total_stock_product'];
      json_product_list[i].array_price_at_date = object_info['array_price_at_date'];
      json_product_list[i].array_amount_at_date = object_info['array_amount_at_date'];
      json_product_list[i].array_price_back_at_date = object_info['array_price_back_at_date'];
      json_product_list[i].array_amount_back_at_date = object_info['array_amount_back_at_date'];
      if(object_info['price']!=null & object_info['price']!=0) json_product_list[i].price = object_info['price'];
    }
  }
}


//__Don't allow typing text, only number
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
$('#export-table').popup_table('export-table',filter_product);

function instance_table() {
  $(".product").remove();
  var tr = "<tr class='product'>"
            +'<td>'
             +'<div class="wrap">'
                +'<span class="input-triangle"><b></b></span>'
                +'<input class="product_id" name="product_id"/>'
                +'<input type="hidden" class="real_id">'
              +'</div>'
            +'</td>'
            +'<td class="product_name" data-name></td>'
            +'<td class="color" data-color></td>'
            +'<td class="standard" data-standard></td>'
            +'<td class="price" data-price></td>'
            +'<td class="total_stock_product" data-stock></td>'
            +'<td data-amount><input class="amount_export" value="" type="text" name="amount_export"/></td>'
            +'<td class="total_price"></td>'
        +'</tr>';
  $(".sum-col").before(tr);
  $('#sum').text('0');
}
