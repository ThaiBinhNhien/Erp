$(".add-sale").click(function(){
	var form = document.getElementById("form");
	form.submit();
});

$(document).ready(function() {
    $('.datatable').DataTable( {
        "scrollY":        "360px",
        "scrollCollapse": true,
        "paging":         false,
         responsive: true,
        searching: false, paging: false,
        "ordering": false,
        "info":     false
    } );
} );

$('.search').click(function(){

	/*var ending_date   = $('.ship_date_end').val();
    var starting_date = $('.ship_date_start').val();
    if(ending_date!=''&&starting_date==''){
        $('.ship_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日を選択してください。</span></div>');
        return false;
    } 
    if(ending_date==''&&starting_date!=''){
        $('.ship_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">終了日を選択してください。</span></div>');
        return false;
    }
     var ending_date_   = $('.order_date_end').val();
     var starting_date_ = $('.order_date_start').val();
     if(ending_date_!=''&&starting_date_==''){
        $('.order_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日を選択してください。</span></div>');
        return false;
     } 
     if(ending_date_==''&&starting_date_!=''){
        $('.order_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">終了日を選択してください。</span></div>');
        return false;
     }



     if($('.search').hasClass('error')){
        return false;
    }*/

	var order_no = $('.order_no').val();
	var user_id = $('.user_name').val();
	var customer_id = $('.customer').val();
	var ship_date_start = $('.ship_date_start').val();
	var ship_date_end = $('.ship_date_end').val();
	var order_date_start = $('.order_date_start').val();
	var order_date_end = $('.order_date_end').val();
	var department_id = $('.department').val();
	$.post(base_url+"sale/ajax_search_order",
	{
		order_no : order_no,
		user_id : user_id,
		customer_id : customer_id,
		department_id : department_id,
		ship_date_start : ship_date_start,
		ship_date_end : ship_date_end,
		order_date_start : order_date_start,
		order_date_end : order_date_end
	},function(data,status){
		insert_result_table(data);
		//console.log(JSON.stringify(data));
		$('#json_list_order').val(data);
	});
});

$(".customer").on('change',function(){
    $.post(base_url+"sale/ajax_get_list_department_by_customer",
    {
        customer_id : this.value
    },function(data,err){
        var option = "<option></option>";
        console.log(data);
        var list_json = JSON.parse(data);
        for(var i in list_json){
            option += "<option value='"+list_json[i].department_id+"'>"+list_json[i].department_name+"</option>";
        }
        $(".department").html(option);
    });
});

function insert_result_table(data){
	json_list_order = JSON.parse(data);
	console.log("json_list_order: "+json_list_order);
	var list_order = JSON.parse(data);
	console.log(list_order);
	var tr = '';
	for(var i in list_order){
		tr += "<tr>";
		tr += "<td>";
		if(i==0) tr += "<input type='radio' name='cus_and_inv' value='cus"+list_order[i].customer_id+"inv"+list_order[i].inv_group+"'>";
		if(i>0) if(list_order[i].customer_id!=list_order[i-1].customer_id | list_order[i].inv_group!=list_order[i-1].inv_group)
			tr += "<input type='radio' name='cus_and_inv' value='cus"+list_order[i].customer_id+"inv"+list_order[i].inv_group+"'>";
		tr += "</td>";
		tr += "<td>";
		if(i==0) tr += list_order[i].customer_name;
		if(i>0) if(list_order[i].customer_id!=list_order[i-1].customer_id | list_order[i].inv_group!=list_order[i-1].inv_group)
			tr += list_order[i].customer_name;
		tr += "</td>";
		tr += "<td>"+list_order[i].id+"</td>";
		tr += "<input type='hidden' value='"+list_order[i].id+"' name='cus"+list_order[i].customer_id+"inv"+list_order[i].inv_group+"[]'>";
		tr += "<td>"+list_order[i].department+"</td>";
		tr += "<td>"+list_order[i].user+"</td>";
		tr += "<td>"+list_order[i].amount_order+"</td>";
		tr += "<td>"+list_order[i].ship_date+"</td>";
		tr += "<td>"+list_order[i].amount_ship+"</td>";
		tr += "</tr>";
	}
	//console.log(tr);
	if(tr == ''){
		tr = '<tr><td valign="top" colspan="8" class="dataTables_empty">'+message_empty_data+'</td></tr>';
	}
	$('tbody').html(tr);
}

$('.create_list').click(function(){
	/*$.post(base_url+'sale/ajax_create_list',
	{
		json_list_order : json_list_order
	},function(data,err){
		console.log(data);
	}
	);*/

	$('.create_list').helloWorld('請求書を保存します。よろしいですか？',base_url+'sale/created_sale',null,{
        url: base_url+"sale/ajax_create_list",
        data : {
            json_list_order : json_list_order
        },
        error_message: error_message,
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
});

$('.export_csv').click(function() {
    var order_no = $('.order_no').val();
    var user_id = $('.user_name').val();
    var customer_id = $('.customer').val();
    var ship_date_start = $('.ship_date_start').val();
    var ship_date_end = $('.ship_date_end').val();
    var order_date_start = $('.order_date_start').val();
    var order_date_end = $('.order_date_end').val();
    var department_id = $('.department').val();
    $.post(base_url+"sale/ajax_search_order",
    {
        order_no : order_no,
        user_id : user_id,
        customer_id : customer_id,
        department_id : department_id,
        ship_date_start : ship_date_start,
        ship_date_end : ship_date_end,
        order_date_start : order_date_start,
        order_date_end : order_date_end
    },function(data,status){
        $('#json_list_order').val(data);
        $("#export_csv").submit();
    });
});

$("#revenues-table").on('dblclick','tr',function(){
    if(!(parseInt($(this).find('td').eq(2).text())>0)) return false;
	var order_no = $(this).find('td').eq(2).text();
    window.open(base_url+"order/detail-order-2?id="+order_no, '_blank');
});
/*
//--Validation search by date
$('.ship_date_end').change(function(){
    $('.ship_date_end').closest('div').find('.popup').remove();
    var ending_date = $(this).val();
    var starting_date = $('.ship_date_start').val();
    if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('.ship_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('.ship_date_start').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }

})
$('.ship_date_start').change(function(){
    $('.ship_date_start').closest('div').find('.popup').remove();
    var starting_date = $(this).val();
    var ending_date = $('.ship_date_end').val();
     if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('.ship_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('.ship_date_start,.ship_date_end').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }
})

//--Validation search by date
$('.order_date_end').change(function(){
    $('.order_date_end').closest('div').find('.popup').remove();
    var ending_date = $(this).val();
    var starting_date = $('.order_date_start').val();
    if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('.order_date_end').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('.order_date_start').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }

})
$('.order_date_start').change(function(){
    $('.order_date_start').closest('div').find('.popup').remove();
    var starting_date = $(this).val();
    var ending_date = $('.order_date_end').val();
     if(ending_date!=''&&starting_date!=''){
        if(starting_date > ending_date){
            $('.order_date_start').closest('div').append('<div class="popup"><span class="popuptext" id="myPopup">開始日は終了日以下から選択してください。</span></div>');
            $('.search').addClass('error');
        } else {
            $('.order_date_start,#order_date_end').closest('div').find('.popup').remove();
            $('.search').removeClass('error');
        }
    }
})
*/
var today = new Date();
    $('.ship_date_start').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        maxDate : new Date(today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate()),
        onSelect: function () {
            var dt_to = $('.ship_date_end');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
    }).attr('readonly','readonly');

    $('.ship_date_end').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        maxDate : new Date(today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate()),
        onSelect: function () {
            var dt_from = $('.ship_date_start');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');
    $('.order_date_start').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        maxDate : new Date(today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate()),
        onSelect: function () {
            var dt_to = $('.order_date_end');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
    }).attr('readonly','readonly');

    $('.order_date_end').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        maxDate : new Date(today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate()),
        onSelect: function () {
            var dt_from = $('.order_date_start');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');