var page = 0;
var order_id = 0;
var supplier_id = null;
var content_id = 0;
var user_id = 0;
var stock_id = stock_default;
var order_date_start = 0;
var order_date_end = 0;
var sales_des_id = 0;
var status = 0;
var is_import = 0;

var i=false;
var checkfocus = false;

$('.datatable').dataTable({
        "scrollX": true,
        scrollY:        '350px',
        scrollCollapse: true,
        paging:         false,
        "info":false,
        responsive      : true,
        searching       : false,
        "ordering"      : false,
        "destroy"       : true
    });

$('.dataTables_scrollBody').on('scroll', function() {
    i=true;
    console.log(i);
});

var des_table = $('.datatable-call').DataTable({
            "scrollY"       : "360px",
            "scrollCollapse": true,
            "paging"        : false,
            responsive      : true,
            searching       : false, 
            paging          : false,
            "ordering"      : false,
            "info"          : false
              })//End DataTable 
// For Chrome
//window.addEventListener('mousewheel', mouseWheelEvent);

// For Firefox
//window.addEventListener('DOMMouseScroll', mouseWheelEvent);


$(".datatable").hover(function(){
    checkfocus = true;
},
function(){
    checkfocus = false;
});

$("#purchase").on('dblclick','tr',function(){
    if(!($(this).find('.order_id').text().length>0)) return false;
    var order_id = $(this).find('.order_id').text();
    window.open(base_url+'purchase/detail-purchase?id='+order_id, '_blank');
    return false;
});

$('#search').click(function(){
/*     var ending_date   = $('#order_date_end').val();
     var starting_date = $('#order_date_start').val();
     if(ending_date!=''&&starting_date==''){
        $('#order_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日を選択してください。</span></div>');
        return false;
     } 
     if(ending_date==''&&starting_date!=''){
        $('#order_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">終了日を選択してください。</span></div>');
        return false;
     }
     if($('#search').hasClass('error')){
        return false;
    }*/



    page = 0;
    order_id = $('#code').val();
    supplier_id = $('#supplier_id').val();//nhà cung cấp
    content_id = $('#content_id').val();
    user_id = $('#user_id').val();
    stock_id = $('#stock_id').val();
    order_date_start = $('#order_date_start').val();
    order_date_end = $('#order_date_end').val();
    sales_des_id = $('#sales_des_id').val();
    status = $('#status').val();
    is_import = $('#is_import').val();//nhập kho chưa

    /*$.post(base_url+'purchase/ajax_search_order_purchase',
    {
        order_id : order_id,
        supplier_id : supplier_id,
        content_id : content_id,
        user_id : user_id,
        stock_id : stock_id,
        order_date_start : order_date_start,
        order_date_end : order_date_end,
        sales_des_id : sales_des_id,
        status : status,
        is_import : is_import,
        page : page
    },
    function(data,error){
        console.log(data);
        //$('.data').html(convert_to_html(data));
    });*/
    var data  = {
        order_id : order_id,
        supplier_id : supplier_id,
        content_id : content_id,
        user_id : user_id,
        stock_id : stock_id,
        order_date_start : order_date_start,
        order_date_end : order_date_end,
        sales_des_id : sales_des_id,
        status : status,
        is_import : is_import,
        page : page


    };
    var row;
    $('.datatable-call').DataTable({
            "scrollY"       : "360px",
            "scrollCollapse": true,
            "paging"        : false,
            responsive      : true,
            searching       : false, 
            paging          : false,
            "ordering"      : false,
            "info"          : false,
            "destroy"       : true,
            "ajax": {
            "url" : base_url+"purchase/ajax_search_order_purchase",
            "type": "POST",
            "data":data
            },
            "columnDefs": [
                { className: "order_id", "targets": [ 0 ] }
              ],
    /*          "columnDefs": [
                { className: "order_id1", "targets": [ 1 ] }
              ],*/
            "columns": [
                  { "data": "id","title":"発注No" },
                  { "data": "order_date",         "title":"発注日" },
                  { "data": "supplier",         "title":"仕入先" },
                  { "data": "content_order","title":"発注内容" },
                  { "data": "base",       "title":"拠点" },
                  { "data": "register_user","title":"起票者" },
                  { "data": "status",   "title":"形態" },
                  { "data": "import_date",       "title":"納品日" },
                  { "data": "is_import","title":"入庫" }
            ],
            "initComplete": function(json){
            //console.log(data.order_id);
            row = json['aoData'].length;
            //console.log(row);
            if(row > 0){
                $('.csv').attr('href',base_url+'purchase/export-purchase-csv'+'/?order_id='+order_id+'&supplier_id='+supplier_id+'&content_id='+content_id+'&user_id='+user_id+'&stock_id='+stock_id+'&order_date_start='+order_date_start+'&order_date_end='+order_date_end+'&sales_des_id='+sales_des_id+'&status='+status+'&is_import='+is_import).removeClass('disabled');
                } else {
                $('.csv').attr('href','#').addClass('disabled');    
                }

                //__Add the color of is_import and status
                $('tbody tr').each(function() {
                    var is_import   = $(this).find("td:nth-child(9)").text();
                    var status      = $(this).find("td:nth-child(7)").text();
                    if(is_import=='未'){
                        $(this).find("td:nth-child(9)").addClass('red')  ;
                    } 
                    if(status=='一時保存'||status=='承認待'){
                        $(this).find("td:nth-child(7)").addClass('red')  ;
                    } 
                });
            }//__End initComplete

        })//End datatable 
        //console.log(row);

        //__Add parameter into csv link
        //$('.csv').attr('href',base_url+'purchase/export-purchase-csv'+'/?order_id='+order_id+'&supplier_id='+supplier_id+'&content_id='+content_id+'&user_id='+user_id+'&stock_id='+stock_id+'&order_date_start='+order_date_start+'&order_date_end='+order_date_end+'&sales_des_id='+sales_des_id+'&status='+status+'&is_import='+is_import);
        //__End add parameter into csv link
        

    setTimeout(function(){ data_scroll('purchase/ajax_search_order_purchase'); }, 2000);
    if ( $('td').hasClass('dataTables_empty')) {
    //console.log($('tbody tr').attr('role').length);
     }
    //var row = $('.dataTables_empty').css('background','blue');
    return false;
    });

data_scroll('purchase/ajax_search_order_purchase');
function data_scroll(url){
$('.dataTables_scrollBody').on('scroll', function() {
  //Return number tr row in tbody
    var num_row=$('.dataTables_scrollBody tbody tr').length;
    if($(this)[0].scrollHeight - $(this).scrollTop() === $(this).outerHeight()) {
       
      $.ajax({
            url : base_url+url,
            data: {
            order_id : order_id,
            supplier_id : supplier_id,
            content_id : content_id,
            user_id : user_id,
            stock_id : stock_id,
            order_date_start : order_date_start,
            order_date_end : order_date_end,
            sales_des_id : sales_des_id,
            status : status,
            is_import : is_import,
            page : num_row
              },
              type: 'POST',
              success: function(data) {
              var obj = JSON.parse(data);
              obj = obj.data;
              var cont = '';
              //Check obj have value
              if(obj.length>0){
              for( var i=0;i<obj.length;i++)
              {   
              cont+='<tr role="row" data-id="'+obj[i]['id']+'">'; 
                //Loop all properties of object
                  //Check except_field that have value
                   cont+='<td class="order_id">'+(obj[i]['id'])+'</td>';
                   cont+='<td>'+(obj[i]['order_date'])+'</td>';
                   cont+='<td>'+(obj[i]['supplier'])+'</td>';
                   cont+='<td>'+(obj[i]['content_order'])+'</td>';
                   cont+='<td>'+(obj[i]['base'])+'</td>';
                   cont+='<td>'+(obj[i]['register_user'])+'</td>';
                   if(obj[i]['status']=='一時保存'||obj[i]['status']=='承認待')
                   {
                        cont+='<td class="red">'+(obj[i]['status'])+'</td>';
                   } else {
                        cont+='<td>'+(obj[i]['status'])+'</td>';
                   }
                   cont+='<td>'+(obj[i]['import_date'])+'</td>';
                   
                   if(obj[i]['is_import']=='未')
                   {
                        cont+='<td class="red">'+(obj[i]['is_import'])+'</td>';
                   } else {
                        cont+='<td>'+(obj[i]['is_import'])+'</td>';
                   }
                cont+='</tr>';
              }//End for
                //console.log(cont);
             $('.dataTables_scrollBody tbody').append(cont);  
              }//End if
              }//End success
            });//End ajax second
    };
});
}//End function
function convert_to_html(json_data) {
    var html='';
    var data = JSON.parse(json_data);
    for(var id in data){
        html += '<tr>';
        html += "<td class='order_id'>"+data[id].id+"</td>";
        html += "<td>"+data[id].order_date+"</td>";
        html += "<td>"+data[id].supplier+"</td>";
        html += "<td>"+data[id].content_order+"</td>";
        html += "<td>"+data[id].base+"</td>";
        html += "<td>"+data[id].register_user+"</td>";
        html += "<td>"+data[id].status+"</td>";
        html += "<td>"+data[id].import_date+"</td>";
        if(data[id].is_import=='未') html += "<td class='red'>"+data[id].is_import+"</td>";
        else html += "<td>"+data[id].is_import+"</td>";
        html += '</tr>';
    }
    return html;
}

$('.checklist').click(function(){
    order_id = $('#code').val();
    supplier_id = $('#supplier_id').val();//nhà cung cấp
    content_id = $('#content_id').val();
    user_id = $('#user_id').val();
    stock_id = $('#stock_id').val();
    order_date_start = $('#order_date_start').val();
    order_date_end = $('#order_date_end').val();
    sales_des_id = $('#sales_des_id').val();
    status = $('#status').val();
    is_import = $('#is_import').val();
    var parameters = "order_date_start="+order_date_start+"&order_date_end="+order_date_end+"&order_id="+order_id+"&supplier_id="+supplier_id+
                     "&content_id="+content_id+"&user_id="+user_id+"&stock_id="+stock_id+"&sales_des_id="+sales_des_id+"&status="+status+"&is_import="+is_import;
    window.open(base_url+'purchase/pdf-checklist?'+parameters,'_self');
});
/*--------------------------------------------------------Begin validation--------------------------------------------------*/
//--Validation search by date
/*$('#order_date_end').change(function(){
    $('#order_date_end').closest('div').find('.popup').remove();
    var ending_date = $(this).val();
    var starting_date = $('#order_date_start').val();
    if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('#order_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('#search').addClass('error');
        } else {
            $('#order_date_start').closest('div').find('.popup').remove();
            $('#search').removeClass('error');
        }
    }

})
$('#order_date_start').change(function(){
    $('#order_date_start').closest('div').find('.popup').remove();
    var starting_date = $(this).val();
    var ending_date = $('#order_date_end').val();
     if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('#order_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('#search').addClass('error');
        } else {
            $('#order_date_start,#order_date_end').closest('div').find('.popup').remove();
            $('#search').removeClass('error');
        }
    }
})*/
$('#code').keyup(function(){
    var val = $(this).val();
    $(this).closest('div').find('.popup').remove();
    if(isNaN(val) || val<0){
        $(this).closest('div').append('<div class="popup top"><span class="popuptext" id="myPopup">無効な番号</span></div>');
            $('#search').addClass('error');
    } else {
        $(this).closest('div').find('.popup').remove();
        $('#search').removeClass('error');
    }
})
/*--------------------------------------------------------End validation--------------------------------------------------*/
/*$('.csv').click(function(){
     var ending_date   = $('#order_date_end').val();
     var starting_date = $('#order_date_start').val();
     if(ending_date!=''&&starting_date==''){
        $('#order_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日を選択してください。</span></div>');
        return false;
     } 
     if(ending_date==''&&starting_date!=''){
        $('#order_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">終了日を選択してください。</span></div>');
        return false;
     }
     if($('#search').hasClass('error')){
        return false;
    }

    page = 0;
    order_id = $('#code').val();
    supplier_id = $('#supplier_id').val();//nhà cung cấp
    content_id = $('#content_id').val();
    user_id = $('#user_id').val();
    stock_id = $('#stock_id').val();
    order_date_start = $('#order_date_start').val();
    order_date_end = $('#order_date_end').val();
    sales_des_id = $('#sales_des_id').val();
    status = $('#status').val();
    is_import = $('#is_import').val();//nhập kho chưa
    $.post(base_url+'purchase/ajax_csv',
    {
        order_id : order_id,
        supplier_id : supplier_id,
        content_id : content_id,
        user_id : user_id,
        stock_id : stock_id,
        order_date_start : order_date_start,
        order_date_end : order_date_end,
        sales_des_id : sales_des_id,
        status : status,
        is_import : is_import,
        page : page
    },
    function(data,error){
        console.log(data);
    });
    return false;
});*/

$('#order_date_start').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#order_date_end');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
    }).attr('readonly','readonly');

    $('#order_date_end').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_from = $('#order_date_start');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');
