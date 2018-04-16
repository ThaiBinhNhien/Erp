var i=false;
var page = 0;
var checkfocus = false;
var warehouse_list = null;
var a_order_no, a_distination_id, a_content_id, a_export_date_start, a_export_date_end,
    a_issuer_id, a_shipper_id, a_status;
    var data;
 $('.datatable').dataTable({
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

function mouseWheelEvent(e) {
    var delta = e.wheelDelta ? e.wheelDelta : -e.detail;
    console.log(delta);
    if (delta<0 && checkfocus) {
        console.log('Scroll down');
        if(i == false) {
            //post ajax
            page++;
            $.post(base_url+'purchase/ajax-export-purchase',
                {
                    num_page : page,
                    order_no : a_order_no,
                    distination_id : a_distination_id,
                    content_id : a_content_id,
                    export_date_start : a_export_date_start,
                    export_date_end : a_export_date_end,
                    issuer_id : a_issuer_id,
                    shipper_id :a_shipper_id,
                    status : a_status
                },
                function(data,status){
                    //console.log(data);
                    insert_table(data);
                });
        }
        if(i == true) i = false;
    }
}

$(".datatable").hover(function(){
    checkfocus = true;
},
function(){
    checkfocus = false;
});
function insert_table(json_data) {
    warehouse_list = JSON.parse(json_data);
    for (var x in warehouse_list) {
        var tr = '';
        console.log(warehouse_list[x].id);
        tr += '<tr>'
            +"<td>"+warehouse_list[x].id+"</td>"
            +"<td>"+warehouse_list[x].date_export+"</td>"
            +"<td>"+warehouse_list[x].sales_des+"</td>"
            +"<td>"+warehouse_list[x].content+"</td>"
            +"<td>"+warehouse_list[x].issuer+"</td>";
            if(warehouse_list[x].形態 ==1) tr += "<td>"+warehouse_list[x].status+"</td>";
            else tr += "<td style='color:red'>"+warehouse_list[x].status+"</td>";
            +'</tr>';
        console.log(tr);
        $("tbody").append(tr);
    }
    if($("tbody").html() == ''){
        $('#search').helloWorld('日時についての設定エラーが発生されましたので、再試行してください。',null);
        $("tbody").html('<td valign="top" colspan="6" class="dataTables_empty">'+message_empty_data+'</td>');
    }
}

$(".search").click(function(){
    /*
     var ending_date   = $('.date-end').val();
     var starting_date = $('.date-start').val();
     if(ending_date!=''&&starting_date==''){
        $('.date-start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日を選択してください。</span></div>');
        return false;
     } 
     if(ending_date==''&&starting_date!=''){
        $('.date-end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">終了日を選択してください。</span></div>');
        return false;
     }
     if($('.search').hasClass('error')){
        return false;
    }*/
    a_order_no = $('.order_no').val();
    a_distination_id = $('.distination').val();
    a_issuer_id = $('.issuer').val();
    a_shipper_id = $('.shiper').val();
    a_content_id = $('.content').val();
    a_status = $('.status').val();
    a_export_date_start = $('.date-start').val().replace('/','-');
    a_export_date_end = $('.date-end').val().replace('/','-');
    page = 0;
    //__Add parameter into csv link
       //__End add parameter into csv link
    /*$.post(base_url+'purchase/ajax-export-purchase',
        {
            num_page : page,
            order_no : a_order_no,
            distination_id : a_distination_id,
            content_id : a_content_id,
            export_date_start : a_export_date_start,
            export_date_end : a_export_date_end,
            issuer_id : a_issuer_id,
            shipper_id :a_shipper_id,
            status : a_status
        },
        function(data,status){
            $('tbody').html('');
            console.log(data);
            insert_table(data);
    });*/
    var data  = {
            num_page : page,
            order_no : a_order_no,
            distination_id : a_distination_id,
            content_id : a_content_id,
            export_date_start : a_export_date_start,
            export_date_end : a_export_date_end,
            issuer_id : a_issuer_id,
            shipper_id :a_shipper_id,
            status : a_status


    };
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
            "url" : base_url+"purchase/ajax-export-purchase",
            "type": "POST",
            "data":data
            },

            "columns": [
                  { "data": "id","title":"発注 No" },
                  { "data": "date_export",         "title":"出庫日" },
                  { "data": "sales_des",         "title":"出庫先" },
                  { "data": "content","title":"出庫内容" },
                  { "data": "issuer",       "title":"起票者" },
                  { "data": "status","title":"形態" },
 
            ],
            "initComplete": function(json){
                row = json['aoData'].length;
                if(row > 0){
                    $('.csv').attr('href',base_url+'purchase/export-warehouse-csv'+'/?order_id='+a_order_no+'&destination_id='+a_distination_id+'&shipper_id='+a_shipper_id+'&content_id='+a_content_id+'&issuer_id='+a_issuer_id+'&status='+a_status+'&export_date_start='+a_export_date_start+'&export_date_end='+a_export_date_end);
                    $('.csv').removeClass('disabled');
                   /*     $('.csv').click(function(){
                            alert('abc');
                            return true;
                        })*/
                } else {
                    $('.csv').attr('href','#').addClass('disabled');    
                }    

                 //__Add the color of is_import and status
                $('tbody tr').each(function() {
                    var status = $(this).find("td:nth-child(6)").text();
                    if(status=='一時保存'){
                        $(this).find("td:nth-child(6)").addClass('red')  ;
                    } 
                });
            }    
        });//End datatable 
    setTimeout(function(){ data_scroll('PurchaseController/ajax_warehouse_'); }, 1000);
    return false;
});

data_scroll('PurchaseController/ajax_warehouse_');
function data_scroll(url){
$('.dataTables_scrollBody').on('scroll', function() {
  //Return number tr row in tbody
    var num_row=$('.dataTables_scrollBody tbody tr').length;
    if($(this)[0].scrollHeight - $(this).scrollTop() === $(this).outerHeight()) {
    console.log(num_row);
      $.ajax({
            url : base_url+url,
            data: {
            num_page : num_row,
            order_no : a_order_no,
            distination_id : a_distination_id,
            content_id : a_content_id,
            export_date_start : a_export_date_start,
            export_date_end : a_export_date_end,
            issuer_id : a_issuer_id,
            shipper_id :a_shipper_id,
            status : a_status
              },
              type: 'POST',
              success: function(data) {
              var obj = JSON.parse(data);
              var cont = '';
              //Check obj have value
              if(obj.length>0){
              for( var i=0;i<obj.length;i++)
              {   
              cont+='<tr role="row" data-id="'+obj[i]['id']+'">'; 
                //Loop all properties of object
                  //Check except_field that have value
                   cont+='<td>'+(obj[i]['id'])+'</td>';
                   cont+='<td>'+(obj[i]['date_export'])+'</td>';
                   cont+='<td>'+(obj[i]['sales_des'])+'</td>';
                   cont+='<td>'+(obj[i]['content'])+'</td>';
                   cont+='<td>'+(obj[i]['issuer'])+'</td>';
                   
                   if(obj[i]['status'] == '一時保存'){
                        cont+='<td class="red">'+(obj[i]['status'])+'</td>';
                   } else {
                        cont+='<td>'+(obj[i]['status'])+'</td>';
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
$("#export").on('dblclick','tr',function(){
    if(!(parseInt($(this).find('td').eq(0).text())>0)) return false;
    var id = $(this).find('td').eq(0).text();
    window.open(base_url+"purchase/detail-export-purchase?id="+id, '_blank');
    return false;
});

/*--------------------------------------------------------Begin validation--------------------------------------------------*/
/*//--Validation search by date
$('.date-end').change(function(){
    //$('.date-end').closest('div').find('.popup').remove();
    $('#export').find('.popup').remove();
    var ending_date = $(this).val();
    var starting_date = $('.date-start').val();
    if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('.date-end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('.date-start').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }

})
$('.date-start').change(function(){
    //$('.date-start').closest('div').find('.popup').remove();
    $('#export').find('.popup').remove();
    var starting_date = $(this).val();
    var ending_date = $('.date-end').val();
     if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('.date-start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('.date-start').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }
})*/

    $('.date-start').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('.date-end');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
    }).attr('readonly','readonly');

    $('.date-end').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_from = $('.date-start');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');
$('.order_no').keyup(function(){
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
/*--------------------------------------------------------ending_date validation--------------------------------------------------*/
keypress_number('#export','.order_no');