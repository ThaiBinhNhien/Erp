var called_index = 0;
$(document).ready(function(){
	jQuery('#in_from_date').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#in_to_date');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#in_to_date').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#in_from_date');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
	}).attr('readonly','readonly');
	

	LoadData();
	$('#create_in_product').inputpicker({
            width:'250px',
            url: get_product_selectbox,
            urlParam : {"type_product":2},
            fields:[{"name":"販売商品コード", "text":"売上商品コード"}, {"name":"販売商品名", "text":"売上商品名"}, {"name":"色調", "text":"色調"}],
            fieldText:'販売商品名',
            fieldValue:'商品ID',
            filterOpen: true,
            autoOpen: true,
            headShow: true,
            pagination: true,   // false: no
            pageMode: '',  // '' or 'scroll'
            pageField: 'p',
            pageLimitField: 'per_page',
            limit: PAGE_SIZE_SELECTBOX,
            pageCurrent: 1,
        });
}); 

// // Load Data
function LoadData(val_async){
	// value for async
    if(val_async == "" || val_async == null) {
        val_async = true;
    } else {
        val_async = false;
	}
	
	var in_base  		= $("#in_base").val();
	var in_from_date 	= $("#in_from_date").val();
	var in_to_date      = $("#in_to_date").val();
	var in_product      = $("#in_product").val();
		$.ajax({
			url:catViewUrl,
			data:{in_base: in_base,in_from_date : in_from_date, in_to_date: in_to_date, in_product : in_product, start_index:0},
			async:val_async,
			dataType:'json',
			method:'GET',
			success:function(result){
				$("#cat-table").css("display","block");
				var tables = $.fn.dataTable.fnTables(true);

				$(tables).each(function () {
				    $(this).dataTable().fnDestroy();
				});
				//$("#table_header").parent().parent().parent().attr("id","product-table");
				var html = '';
				for(var i=0; i<result.length; i++){
					html += '<tr data-id='+result[i]['id'] +'>';
					html += '<td>'+(result[i]['id'] == null? "" : result[i]['id'])+'</td>';
					html += '<td>'+(result[i]['in_base'] == null? "" : result[i]['in_base'])+'</td>';
					html += '<td>'+(result[i]['in_product'] == null? "" : result[i]['in_product'])+'</td>';
					html += '<td>'+(result[i]['in_initial_amount'] == null? "" : result[i]['in_initial_amount'])+'</td>';
					html += '<td>'+(result[i]['in_date'] == null? "" : result[i]['in_date'])+'</td>';
					html += '<td ><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';
                	html += '</tr>';
				}

				$("#detail_data").html(html);
				//if(isDatatable == true) {
			 	$('.datatable').DataTable( {
					"scrollY":        "360px",
					"scrollCollapse": true,
					"paging":         false,
					"responsive": true,
					"searching": false, 
					"ordering": false,
					"info":     false,
					"destroy": true,
					
				} ); 
				called_index = 0;
				renewScroll();

			//}
				
			},
			error:function(result) {
                var html = '';

				html = '<tr class="odd row-empty"><td valign="top" colspan="6" class="dataTables_empty">'+message_empty_data+'</td></tr>';
	            $("#detail_data").html(html);
            },
		})
	
}

$(document).ready(function(){
	$(document).on("click",".delete-cat",function(){
		var id = $(this).data("id");
		var data = {id:id}
		var msg = String.format(message_confirm_delete_field, $('table thead tr th:first').html()+" : "+ id);
		$(this).parent().parent().attr("data-delete","1");
		$(this).parent().parent().siblings().attr("data-delete","0"); 
		$(this).helloWorld(msg,null,null,{url:delUrl,data:data,error_message:'',success_callback_function:"remove_record"});
	});
	window.remove_record = function remove_record(){
		$("#detail_data").find("tr[data-delete=1]").remove();
	}

	var count_product = 1;
	$("#addRow").click(function(){
		var html = "<div class='detail"+count_product+" recordAdd'>";

	 	html += '<div class="col-sm-12 col-md-6 col-lg-6">'+
                    '<div class="form-group">' +
                        '<label class="col-md-4 control-label">売上商品名:<span class="label-form-request">*</span></label>' +
                        '<div class="col-md-8">'+
                            '<input class="form-control listProduct" name="create_in_product['+count_product+ ']" id="create_in_product'+count_product+ '"  value="" />' +
                                '<span></span>' +
                        '</div>' +
                    '</div>' +
                '</div>';
        html += '<div class="col-sm-12 col-md-6 col-lg-6">'+
                    '<div class="form-group">' +
                        '<label class="col-md-3 control-label">棚卸:<span class="label-form-request">*</span></label>' +
                        '<div class="col-md-8">'+
                             '<input id="create_initial_amount" name="create_initial_amount['+count_product+ ']" class="form-control">'
                        '</div>' +
                    '</div>' +
                '</div>';      
        html += '<div><a class="btnDeleteProduct" data-id="'+count_product+'"><img class="imageAdd" src='+assetImgUrl+'del.png></a></div>';
	    html +='</div>';
	   	
	    $('#form .row').append(html);
	    
	    $('.detail'+count_product +' .listProduct').inputpicker({
            width:'250px',
            url: get_product_selectbox,
            urlParam : {"type_product":2},
            fields:[{"name":"販売商品コード", "text":"売上商品コード"}, {"name":"販売商品名", "text":"売上商品名"}, {"name":"色調", "text":"色調"}],
            fieldText:'販売商品名',
            fieldValue:'商品ID',
            filterOpen: true,
            autoOpen: true,
            headShow: true,
            pagination: true,   // false: no
            pageMode: '',  // '' or 'scroll'
            pageField: 'p',
            pageLimitField: 'per_page',
            limit: PAGE_SIZE_SELECTBOX,
            pageCurrent: 1,
        });
	   

	    count_product++;
	})
	// Click Delete Add
	$(document).on("click", ".btnDeleteProduct", function(){
	    var id = $(this).data("id");
	    $('.detail'+id).remove();
	});
	window.add_record = function add_record(data,result){
		// reset data list
		$('form')[0].reset();
		LoadData("false");
		
		$('#create-form').modal('toggle');
		var d = result.data;

		$.each(d, function(i, e){

			var in_base = e['in_base'];
			var in_date = e['in_date'];
			var in_product = e['in_product'];
			var in_date = e['in_date'];
			var id = e['id'];
			var in_initial_amount = e['in_initial_amount'];
			$("tr[data-id="+id+"]").remove();
			
			var html = "<tr data-id="+id +">";
			html += '<td>'+id+'</td>';
			html += '<td>'+in_base+'</td>';
			html += '<td>'+in_product+'</td>';
			html += '<td>'+in_initial_amount+'</td>';
			html += '<td>'+in_date+'</td>';
			html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+id+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';	
			html += "</tr>";
			$('#detail_data').prepend(html);
	    });			
	}
	$(document).on("click", "#save", function(){
	//$("#save").click(function(){

			$("[name^=create_initial_amount]").each(function () {
			    $(this).rules("add", {
			        required: true,
            		number: true, 
				    min: 0,
				    max: 2147483647,
			    });
			    $(this).tooltip({
			    	trigger: 'manual',
			        placement:'bottom'
			    });
			});
			$("[name^=create_in_product]").each(function () {
			    $(this).rules("add", {
			        required: true
			    });
			});
			
            var lstProduct = [];
            var data = {};  
            data.in_base 		= $("#create_in_base").val();
            data.name_in_base 	=  $("#create_in_base option:selected").text();
			data.in_date 		= $("#create_in_date").val();
			data.in_product 	= $("#create_in_product").val();
			data.name_in_product 	=  $("input#inputpicker-1").val();
			data.in_initial_amount  = $("#create_initial_amount").val();
			//get list:
			var item ={
					'product': data.in_product ,
					'name_product': data.name_in_product,
					'amount' : data.in_initial_amount,
			};	
			lstProduct.push(item);	
			//push detail added
			var index= 1;
			var indexProduct= 2;
			$(".recordAdd").each(function(){
				var item ={
					'product': $(this).find('input[name="create_in_product['+index+']"]').val(),
					'name_product' : $(this).find('input#inputpicker-'+ indexProduct).val(),
					'amount' : $(this).find('input[name="create_initial_amount['+index+']"]').val(),
				};	
				
				lstProduct.push(item);
				index++;
				indexProduct++;
			});
			//'amount' : $(this).find('input[name="create_initial_amount['+index+']"]').val(),
			data = {meta:data,detail:lstProduct};
			if(raiseValidateCreate() == false)
                  return false;

            $("#save").helloWorld(message_confirm_save_field ,null,null,{url:createUrl,data:data,error_message:'',success_callback_function:"add_record", is_master: true});  
            
    })

	function raiseValidateCreate(){
		if($('#form').valid() && $('#form').data("validator")){
			return true;
		}
		return false;
	}
    function raiseValidateEdit(){
            if($('#edit_form').valid() && $('#edit_form').data("validator")){
                  return true;
            }
            return false;
      }

     window.edit_record = function edit_record(data,result){
		$('#edit-form').modal('toggle');
		var id = $("#dp_id").val();
		var editTr = $("#detail_data").find("tr[data-id="+id+"]");
		editTr.find("td:eq(0)").text($("#dp_id").val());
		editTr.find("td:eq(1)").text($("#edit_in_base option:selected").text());
		editTr.find("td:eq(2)").text($("#edit_in_product option:selected").text());
		editTr.find("td:eq(3)").text($("#edit_initial_amount").val());
		editTr.find("td:eq(4)").text($("#edit_in_date").val());
			
	}   
	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;
            var data = {};
            data.id 			= $("#dp_id").val();
			data.in_initial_amount = $("#edit_initial_amount").val();
			$("#save").helloWorld(message_confirm_save_field ,null,null,{url:edit_CatUrl,data:data,error_message:'',success_callback_function:"edit_record", is_master: true});
            
      });
	$(".addModal").click(function(){
		$("#form .tooltip").remove();
    	$("#form")[0].reset();
    	$(".recordAdd").remove();
    	
    });
	$(document).on("click",".edit",function(){
		$("#edit_form .tooltip").remove();
		$("#edit_form")[0].reset();
		$(".recordAdd").remove();
		var id =$(this).parent().parent().find("td:eq(0)").text().trim();
		var in_base =$(this).parent().parent().find("td:eq(1)").text().trim();
		var in_product =$(this).parent().parent().find("td:eq(2)").text().trim();
		var in_initial_amount =$(this).parent().parent().find("td:eq(3)").text().trim();
		var in_date =$(this).parent().parent().find("td:eq(4)").text().trim();
        $("#dp_id").val(id);
        $("#edit_in_base").val(in_base);
        $("#edit_in_product").val(in_product);
        $("#edit_initial_amount").val(in_initial_amount);
        $("#edit_in_date").val(in_date);
       
		$('select#edit_in_product option').each(function () {
		    if ($(this).text().toLowerCase() == in_product.toLowerCase()) {
		        $(this).prop('selected','selected');
		        return;
		    }
		});
		$('select#edit_in_base option').each(function () {
		    if ($(this).text().toLowerCase() == in_base.toLowerCase()) {
		        $(this).prop('selected','selected');
		        return;
		    }
		});
    })

	$("#edit_form").validate({
            rules : {
            	edit_initial_amount:{
            		required: true,
            		number: true, 
				    min: 0,
				    max: 2147483647,
            	},
            	
            },
            tooltip_options: {  // <- totally invalid option
		       
		       edit_initial_amount: {
		            placement: 'bottom',html:true
		        },

		       
			}
      });

	$("#form").validate({
            rules : {
            	create_in_base:{
            		required:true
            	},
            	create_in_product:{
            		required:true,
            	},
            	create_in_date:{
            		required:true
            	},
            	create_initial_amount:{
            		required: true,
            		number: true, 
				    min: 0,
				    max: 2147483647,
            	},
            	//create_initial_amount:VALIDATION_POSITIVE,
            	'inputpicker-1':{
            		required:true,
            	},
            },
            tooltip_options: {  // <- totally invalid option
		        create_in_base: {
		            placement: 'bottom',html:true
		        },
		        create_in_product: {
		            placement: 'bottom',html:true
		        },
		        create_in_date: {
		            placement: 'bottom',html:true
		        },
		        create_initial_amount: {
		            placement: 'bottom'
		        },
		      	'inputpicker-1':{
		            placement: 'bottom'
		        },
			}
    });
	$("#search").click(function(){
		LoadData();
	});

});
	

  function renewScroll(){
 	$('#cat-table .dataTables_scrollBody').on('scroll', function() {
	  //Return number tr row in tbody

		var start_index = $('#cat-table tbody tr').length;
		var in_base  		= $("#in_base").val();
		var in_from_date 	= $("#in_from_date").val();
		var in_to_date      = $("#in_to_date").val();
		var in_product      = $("#in_product").val();
	  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
	      $.ajax({
	              url:catViewUrl,
				  data:{in_base: in_base,in_from_date : in_from_date, in_to_date: in_to_date, in_product : in_product, start_index:start_index},
	              type: 'GET',
	              dataType:'json',
	              success: function(result) {
		              if(result.length>0){
			              for(var i=0; i<result.length; i++){
							var html = '<tr data-id='+result[i]['id'] +'>';
							html += '<td>'+(result[i]['id'] == null? "" : result[i]['id'])+'</td>';
							html += '<td>'+(result[i]['in_base'] == null? "" : result[i]['in_base'])+'</td>';
							html += '<td>'+(result[i]['in_product'] == null? "" : result[i]['in_product'])+'</td>';
							html += '<td>'+(result[i]['in_initial_amount'] == null? "" : result[i]['in_initial_amount'])+'</td>';
							html += '<td>'+(result[i]['in_date'] == null? "" : result[i]['in_date'])+'</td>';
							html += '<td ><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+result[i]['category_id']+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';
		                	html += '</tr>';
		                	$('#detail_data').append(html);
						}
						// Adjust
						var table = $('#cat-table table').DataTable();
						table.columns.adjust();
		              
		              }
	              }
	       });
	    };
	});
 }

