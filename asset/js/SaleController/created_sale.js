var check=false;
var checkfocus = false;
 $('.datatable').dataTable( {
        scrollY:        '350px',
        scrollCollapse: true,
        paging:         false,
        "info":false,
        responsive      : true,
        searching       : false,
        "ordering"      : false,
        "destroy"       : true
    } );
$('.dataTables_scrollBody').on('scroll', function() {
    check=true;
    console.log(check);
});

var des_table = $('.datatable-call').DataTable({
            "scrollY"       : "340px",
            "scrollCollapse": true,
            "paging"        : false,
            responsive      : true,
            searching       : false, 
            paging          : false,
            "ordering"      : false,
            "info"          : false
            })//End DataTable 



$(".created-revenues").on('dblclick','tr',function(){
	var invoice_id = $(this).find('.invoice_no').text();
    window.open(base_url+"sale/detail-sale-2?inv_id="+invoice_id, '_blank');
});
var invoice_id = null,
	order_id = null,
	user_id = null, //người cấp phiếu
	ship_date_start = null, //ngày bắt đầu ship hàng
	ship_date_end = null, //ngày kết thúc ship hàng
	customer_id = 'none',
	department_id = null,
	page_num = 0;
$('.search').click(function(){
/*	 var ending_date   = $('#ship_date_end').val();
     var starting_date = $('#ship_date_start').val();
     if(ending_date!=''&&starting_date==''){
        $('#ship_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日を選択してください。</span></div>');
        return false;
     } 
     if(ending_date==''&&starting_date!=''){
        $('#ship_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">終了日を選択してください。</span></div>');
        return false;
     }
     if($('.search').hasClass('error')){
        return false;
    }*/



	invoice_id = $('#invoice_no').val();
	order_id = $('#order_id').val();
	user_id = $('#user_id').val();
	ship_date_start = $('#ship_date_start').val();
	ship_date_end = $('#ship_date_end').val();
	customer_id = $('#customer_id').val();
	department_id = $('#department_id').val();
	page_num = 0;
	console.log(ship_date_start);
	$(".export_csv").attr("href",base_url+'sale/ajax_export_csv_created?'+"invoice_id="+invoice_id+"&order_id="+order_id+"&user_id="+user_id
		+"&ship_date_start="+ship_date_start+"&ship_date_end="+ship_date_end+"&customer_id="+customer_id+"&department_id="+department_id);
	
    var data = {
        invoice_id : invoice_id,
        order_id : order_id,
        user_id : user_id,
        ship_date_start : ship_date_start,
        ship_date_end : ship_date_end,
        customer_id : customer_id,
        department_id : department_id,
        page_num : page_num
    };
    $('.datatable-call').DataTable({
            "scrollY"       : "350px",
            "scrollCollapse": true,
            "paging"        : false,
            responsive      : true,
            searching       : false, 
            paging          : false,
            "ordering"      : false,
            "info"          : false,
            "destroy"       : true,
            "ajax": {
            "url" : base_url+"sale/ajax_search_created",
            "type": "POST",
            "data":data
            },
            "columnDefs": [
                { className: "invoice_no", "targets": [ 0 ] }
              ],
    /*          "columnDefs": [
                { className: "order_id1", "targets": [ 1 ] }
              ],*/
            "columns": [
                  { "data": "id","title":"請求書No" },
                  { "data": "date_created",         "title":"作成日" },
                  { "data": "customer",         "title":"お得意先" },
                  { "data": "department","title":"部署名" },
                  { "data": "remark",       "title":"備考" },
                  { "data": "price","title":"請求金額" }
            ],
            "initComplete": function(json){
            }
        });
    setTimeout(function(){ 
        data_scroll();

    }, 1000);
});
data_scroll();
function data_scroll(){
$('.dataTables_scrollBody').on('scroll', function() {
  //Return number tr row in tbody
    if($(this)[0].scrollHeight - $(this).scrollTop() === $(this).outerHeight()) {
            page_num ++;
            $.post(base_url+"sale/ajax_search_created",
            {
                invoice_id : invoice_id,
                order_id : order_id,
                user_id : user_id,
                ship_date_start : ship_date_start,
                ship_date_end : ship_date_end,
                customer_id : customer_id,
                department_id : department_id,
                page_num : page_num
            },
            function(data,status){
                $("tbody").append(convert_json_to_html(data));
            });
    }
})
};

//chuyển dữ liệu json về html
function convert_json_to_html(data) {
	if(data == null) return '';
	var json_data = JSON.parse(data).data;
	var html = "";
	for(var i in json_data){
		html += "<tr>"
		html += "<td class='invoice_no'>" + json_data[i].id + "</td>";
		html += "<td>"+ json_data[i].date_created +"</td>";
		html += "<td>"+ json_data[i].customer +"</td>";
		html += "<td>"+ json_data[i].department +"</td>";
		html += "<td>"+ json_data[i].remark +"</td>";
		html += "<td>"+ json_data[i].price +"</td>";
		html += "</tr>";
	}
	return html;
}

//window.addEventListener('mousewheel', mouseWheelEvent);

// For Firefox
//window.addEventListener('DOMMouseScroll', mouseWheelEvent);

function mouseWheelEvent(e) {
	var delta = e.wheelDelta ? e.wheelDelta : -e.detail;
    console.log("delta:"+delta);
	if (delta<0 && checkfocus) {
		console.log('Scroll down');
        if(check == false){
        	page_num ++;
        	$.post(base_url+"sale/ajax_search_created",
			{
				invoice_id : invoice_id,
				order_id : order_id,
				user_id : user_id,
				ship_date_start : ship_date_start,
				ship_date_end : ship_date_end,
				customer_id : customer_id,
				department_id : department_id,
				page_num : page_num
			},
			function(data,status){
				$("tbody").append(convert_json_to_html(data));
			});
        }
        if(check == true) check= false;
    }
}
$(".datatable-call").hover(function(){
    checkfocus = true;
	console.log(checkfocus);
},
function(){
	checkfocus = false;
	console.log(checkfocus);
});

/*--------------------------------------------------------Begin validation--------------------------------------------------*/
/*//--Validation search by date
$('#ship_date_end').change(function(){
    $('#ship_date_end').closest('div').find('.popup').remove();
    var ending_date = $(this).val();
    var starting_date = $('#ship_date_start').val();
    if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('#ship_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('#ship_date_start').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }

})
$('#ship_date_start').change(function(){
    $('#ship_date_start').closest('div').find('.popup').remove();
    var starting_date = $(this).val();
    var ending_date = $('#ship_date_end').val();
     if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('#ship_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('#ship_date_start,#ship_date_end').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }
})*/
$('#invoice_no,#order_id').keyup(function(){
    var val = $(this).val();
    $(this).closest('div').find('.popup').remove();
    if(isNaN(val) || val<0){
        $(this).closest('div').append('<div class="popup top"><span class="popuptext" id="myPopup">無効な番号</span></div>');
            $('.search').addClass('error');
    } else {
        $(this).closest('div').find('.popup').remove();
        $('.search').removeClass('error');
    }
})
/*--------------------------------------------------------End validation--------------------------------------------------*/
    var today = new Date();
    $('#ship_date_start').datepicker({
            dateFormat:'yy/mm/dd',
            changeMonth: true,
            changeYear: true,
            maxDate : new Date(today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate()),
            onSelect: function () {
                var dt_to = $('#ship_date_end');
                var minDate = $(this).datepicker('getDate');
                dt_to.datepicker('option', 'minDate', minDate); 
            }
        }).attr('readonly','readonly');

    $('#ship_date_end').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        maxDate : new Date(today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate()),
        onSelect: function () {
            var dt_from = $('#ship_date_start');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');

$('#customer_id').change(function(){
    if(this.value != 'none'){
        $.post(base_url+"sale/ajax_get_list_department_by_customer",
        {
            customer_id : this.value
        },function(data,err){
            var option = "<option></option>";
            var list_json = JSON.parse(data);
            for(var i in list_json){
                option += "<option value='"+list_json[i].department_id+"'>"+list_json[i].department_name+"</option>";
            }
            $("#department_id").html(option);
        });
    }else{
        $("#department_id").html('<option></option>');
    }
});

$('.export_csv').click(function(){
    var invoice_id_csv = $('#invoice_no').val();
    var order_id_csv = $('#order_id').val();
    var user_id_csv = $('#user_id').val();
    var ship_date_start_csv = $('#ship_date_start').val();
    var ship_date_end_csv = $('#ship_date_end').val();
    var customer_id_csv = $('#customer_id').val();
    var department_id_csv = $('#department_id').val();
    var page_num_csv = 0;
    var json_data = null;
    $.post(base_url+"sale/ajax_search_created",
    {
        invoice_id : invoice_id_csv,
        order_id : order_id_csv,
        user_id : user_id_csv,
        ship_date_start : ship_date_start_csv,
        ship_date_end : ship_date_end_csv,
        customer_id : customer_id_csv,
        department_id : department_id_csv,
        page_num : page_num_csv
    },
    function(data,status){
        json_data = data;
        if(json_data == '[]'){
            $('#search').helloWorld(message_empty_data,null);
            return false;
        }
        console.log(json_data);
        window.location.href = base_url+'sale/ajax_export_csv_created?'+"invoice_id="+invoice_id_csv+"&order_id="+order_id_csv+"&user_id="+user_id_csv
        +"&ship_date_start="+ship_date_start_csv+"&ship_date_end="+ship_date_end_csv+"&customer_id="+customer_id_csv+"&department_id="+department_id_csv;
    });
});