
$(document).ready(function(){
	var PL_PRODUCT_ID = "商品ID";
	var PL_PRODUCT_NAME_ORDER = '商品名';
	var PL_STANDARD = '規格'; 
	var PL_COLOR_TONE = '色調';
	var OD_UNIT_PRICE = '単価';
	var OD_QUANTITY = '数量';
	var PRICE_BUY = '仕入単価';
	var OD_PRODUCT_CODE = '商品コード';
	var OSHD_QUANTITY = '発注数';
	var NAME_SELL = '販売商品名';
	var NAME_BUY = '仕入商品名';
	var PL_PRODUCT_CODE_BUY = '仕入商品コード';
	var PL_PRODUCT_CODE_SELL = '販売商品コード';

	function conver_id(id_string){
		var tmp_id = id_string.split("_");
		return tmp_id[0];
	}
    $("#Purchase li").on("mouseleave", function (e) {
		e.preventDefault();
		$('#Purchase li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
			
		});
    });
	    
    var moveFlag = true;
	$('#Purchase li a').hover( function (e) {
		var id_string = $(this).parent().parent().attr('id');
		var id = conver_id(id_string);
     	var table_name = '#table_purchar_'+ id + ' table tbody';
		$('#Purchase li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
		});
		$('#'+id_string).find('div').addClass('home_js_h_table');
		$.ajax( {
			url : getPurcharDetail,
			data:{id:id},
			dataType:'json',
			method:'GET',
			success:function(result){
				$(table_name).html('');
				var my_result = [];
				my_result = result.rel;
				var leng_rel = my_result.length;
				if(leng_rel > 0)
				{	
					for (let index = 0; index < leng_rel; index++) {
						var tmp_PL_PRODUCT_ID = (my_result[index][PL_PRODUCT_CODE_BUY] == null) ? '' : my_result[index][PL_PRODUCT_CODE_BUY];
						if(my_result[index][PL_PRODUCT_CODE_BUY] == null && my_result[index][NAME_BUY] == null && my_result[index][PL_STANDARD] == null && my_result[index][PL_COLOR_TONE] == null) {
							tmp_PL_PRODUCT_ID = "<span class='field_delete'>"+message_delete_product+"</span>";
						}
						var tmp_PL_PRODUCT_NAME = (my_result[index][NAME_BUY] == null) ? '' : my_result[index][NAME_BUY];
						var tmp_PL_STANDARD = (my_result[index][PL_STANDARD] == null) ? '' : my_result[index][PL_STANDARD];
						var tmp_PL_COLOR_TONE = (my_result[index][PL_COLOR_TONE] == null) ? '' : my_result[index][PL_COLOR_TONE];
						var tmp_OD_UNIT_PRICE = (my_result[index][PRICE_BUY] == null) ? '' : my_result[index][PRICE_BUY];
						var tmp_OD_QUANTITY = (my_result[index][OSHD_QUANTITY] == null) ? '' : my_result[index][OSHD_QUANTITY];
						var row = "<tr><td>" + tmp_PL_PRODUCT_ID + "</td><td>" + tmp_PL_PRODUCT_NAME + "</td><td>" + tmp_PL_STANDARD +"</td><td>"+ tmp_PL_COLOR_TONE +"</td><td>"+ tmp_OD_UNIT_PRICE +"</td><td>"+ tmp_OD_QUANTITY +"</td></tr>";
						$(table_name).append(row);
					}
				}
				else
				{
					var row = "<tr><td colspan='6' style ='text-align: center'>No Data!</td></tr>";
					$(table_name).append(row);
				}
				my_result = [];
			}
		} )

    });

    $('#receive-order li a').hover( function (e) {
		
		var id_string = $(this).parent().parent().attr('id');
		var id = conver_id(id_string);
		var table_name = '#table_'+ id + ' table tbody';
		
		$('#receive-order li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
		});
		$('#'+id_string).find('div').addClass('home_js_h_table');
		$.ajax({
			url:getDetailOder,
			data:{id:id},
			dataType:'json',
			method:'GET', 
			success:function(result){
				$(table_name).html('');
				var my_result = [];
				my_result = result.rel;
				var leng_rel = my_result.length;
				if(leng_rel > 0)
				{
					for (let index = 0; index < leng_rel; index++) {
						var val_PL_PRODUCT_ID = (my_result[index][PL_PRODUCT_CODE_SELL] == null) ? '' : my_result[index][PL_PRODUCT_CODE_SELL];
						var val_PL_PRODUCT_NAME = (my_result[index][PL_PRODUCT_NAME_ORDER] == null) ? '' : my_result[index][PL_PRODUCT_NAME_ORDER];
						if(my_result[index][PL_PRODUCT_CODE_SELL] == null && my_result[index][PL_STANDARD] == null && my_result[index][PL_COLOR_TONE] == null) {
							val_PL_PRODUCT_ID = "<span class='field_delete'>"+message_delete_product+"</span>";
						}
						var val_PL_STANDARD = (my_result[index][PL_STANDARD] == null) ? '' : my_result[index][PL_STANDARD];
						var val_PL_COLOR_TONE = (my_result[index][PL_COLOR_TONE] == null) ? '' : my_result[index][PL_COLOR_TONE];
						var val_OD_UNIT_PRICE = (my_result[index][OD_UNIT_PRICE] == null) ? '' : my_result[index][OD_UNIT_PRICE];
						var val_OD_QUANTITY = (my_result[index][OD_QUANTITY] == null) ? '' : my_result[index][OD_QUANTITY];
						var row = "<tr><td>" + val_PL_PRODUCT_ID + "</td><td>" + val_PL_PRODUCT_NAME + "</td><td>" + val_PL_STANDARD +"</td><td>"+ val_PL_COLOR_TONE +"</td><td>"+ val_OD_UNIT_PRICE +"</td><td>"+ val_OD_QUANTITY +"</td></tr>";
						$(table_name).append(row);
					}
				}
				else
				{
					var row = "<tr><td colspan='6' style ='text-align: center'>No Data!</td></tr>";
					$(table_name).append(row);
				}
				my_result = [];
			}
		});
    });

    $("#receive-order li").on("mouseleave", function (e) {
		e.preventDefault();
		$('#receive-order li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
			
		});
    });

    $("#receive-order ul").on("mouseleave", function (e) {
		$('#receive-order li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
			
		});
    });

    $('#revenue-list li a').hover( function (e) {
		e.preventDefault();
		var id_string = $(this).parent().parent().attr('id');
		var id = conver_id(id_string);
     	var table_name = '#table_re_'+ id + ' table tbody';
		$('#revenue-list li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
		});
		$('#'+id_string).find('div').addClass('home_js_h_table');
     	
     	$.ajax({
			url:getDetailOder_revenue,
			data:{id:id},
			dataType:'json',
			method:'GET',
			success:function(result){
				$(table_name).html('');
				var my_result = [];
				my_result = result.rel;
				var leng_rel = my_result.length;
				if(leng_rel > 0)
				{
					for (let index = 0; index < leng_rel; index++) {
						var val_OD_PRODUCT_CODE = (my_result[index][PL_PRODUCT_CODE_SELL] == null) ? '' : my_result[index][PL_PRODUCT_CODE_SELL];
						if(my_result[index][PL_PRODUCT_CODE_SELL] == null && my_result[index][PL_STANDARD] == null && my_result[index][PL_COLOR_TONE] == null) {
							val_OD_PRODUCT_CODE = "<span class='field_delete'>"+message_delete_product+"</span>";
						}
						var val_PL_PRODUCT_NAME = (my_result[index][NAME_SELL] == null) ? '' : my_result[index][NAME_SELL];
						var val_PL_STANDARD = (my_result[index][PL_STANDARD] == null) ? '' : my_result[index][PL_STANDARD];
						var val_PL_COLOR_TONE = (my_result[index][PL_COLOR_TONE] == null) ? '' : my_result[index][PL_COLOR_TONE];
						var val_OD_UNIT_PRICE = (my_result[index][OD_UNIT_PRICE] == null) ? '' : my_result[index][OD_UNIT_PRICE];
						var val_OD_QUANTITY = (my_result[index][OD_QUANTITY] == null) ? '' : my_result[index][OD_QUANTITY];
						var row = "<tr><td>" + val_OD_PRODUCT_CODE + "</td><td>" + val_PL_PRODUCT_NAME + "</td><td>" + val_PL_STANDARD +"</td><td>"+ val_PL_COLOR_TONE +"</td><td>"+ val_OD_UNIT_PRICE +"</td><td>"+ val_OD_QUANTITY +"</td></tr>";
						$(table_name).append(row);
					}
				}
				else
				{
					var row = "<tr><td colspan='6' style ='text-align: center'>No Data!</td></tr>";
					$(table_name).append(row);
				}
				my_result = [];
			}
		});
		// e.preventDefault();
    });

    $("#revenue-list li").on("mouseleave", function (e) {
		e.preventDefault();
		$('#revenue-list li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
		});
		// e.preventDefault();
    });

    $('#ship-list-tmp li a').hover( function (e) {
		e.preventDefault();
		var id_string = $(this).parent().parent().attr('id');
		var id = conver_id(id_string);
		var table_name = '#table_ship_'+ id + ' table tbody';
		$('#ship-list-tmp li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
		});
		$('#'+id_string).find('div').addClass('home_js_h_table');
     	
     	$.ajax({
			url:getDetailOrder_shipment,
			data:{id:id},
			dataType:'json',
			method:'GET',
			success:function(result){
				$(table_name).html('');
				var my_result = [];
				my_result = result.rel;
				var leng_rel = my_result.length;
				if(leng_rel > 0)
				{	
					for (let index = 0; index < leng_rel; index++) {
						var val_OD_PRODUCT_CODE = (my_result[index][PL_PRODUCT_CODE_SELL] == null) ? '' : my_result[index][PL_PRODUCT_CODE_SELL];
						var val_PL_PRODUCT_NAME = (my_result[index][NAME_SELL] == null) ? '' : my_result[index][NAME_SELL];
						if(my_result[index][PL_PRODUCT_CODE_SELL] == null && my_result[index][NAME_SELL] == null && my_result[index][PL_STANDARD] == null && my_result[index][PL_COLOR_TONE] == null) {
							val_OD_PRODUCT_CODE = "<span class='field_delete'>"+message_delete_product+"</span>";
						}
						var val_PL_STANDARD = (my_result[index][PL_STANDARD] == null) ? '' : my_result[index][PL_STANDARD];
						var val_PL_COLOR_TONE = (my_result[index][PL_COLOR_TONE] == null) ? '' : my_result[index][PL_COLOR_TONE];
						var val_OD_UNIT_PRICE = (my_result[index][OD_UNIT_PRICE] == null) ? '' : my_result[index][OD_UNIT_PRICE];
						var val_OD_QUANTITY = (my_result[index][OSHD_QUANTITY] == null) ? '' : my_result[index][OSHD_QUANTITY];
						var row = "<tr><td>" + val_OD_PRODUCT_CODE + "</td><td>" + val_PL_PRODUCT_NAME + "</td><td>" + val_PL_STANDARD +"</td><td>"+ val_PL_COLOR_TONE +"</td><td>"+ val_OD_UNIT_PRICE +"</td><td>"+ val_OD_QUANTITY +"</td></tr>";
						$(table_name).append(row);
					}
				}
				else
				{
					var row = "<tr><td colspan='6' style ='text-align: center'>No Data!</td></tr>";
					$(table_name).append(row);
				}
				my_result = [];
			}
		});
		// e.preventDefault();
    });

    $("#ship-list-tmp li").on("mouseleave", function (e) {
		e.preventDefault();
		$('#ship-list-tmp li').find('div').each (function() {
			$(this).removeClass('home_js_h_table');
			
		});
    });
   
    $('#ship-list-tmp li').click(function(e) {
		e.preventDefault();
		var id_shipment = $(this).attr('id');
		$.ajax({
			url:edit_flagflicker_shipment,
			data:{id_shipment:id_shipment},
			dataType:'json',
			method:'POST',
			success:function(result){
				// location.reload();
			}
		});
	});
})