var called_index = 0;
$(document).ready(function(){
	jQuery('#di_from_date').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('#di_to_date');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');

	jQuery('#di_to_date').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('#di_from_date');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
	}).attr('readonly','readonly');


	LoadData();

	$('#create_di_product').inputpicker({
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
// Load Data
function LoadData(val_async){
	// value for async
    if(val_async == "" || val_async == null) {
        val_async = true;
    } else {
        val_async = false;
	}
	
	var di_base  		= $("#di_base").val();
	var di_from_date 	= $("#di_from_date").val();
	var di_to_date      = $("#di_to_date").val();
	var di_product      = $("#di_product").val();
		$.ajax({
			url:catViewUrl,
			data:{di_base: di_base,di_from_date : di_from_date, di_to_date: di_to_date, di_product : di_product, start_index:0},
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
					html += '<td>'+(result[i]['id'] = null ? "" : result[i]['id'])+'</td>';
					html += '<td>'+(result[i]['di_base'] = null ? "" : result[i]['di_base'])+'</td>';
					html += '<td>'+(result[i]['di_product'] = null ? "" : result[i]['di_product'])+'</td>';
					html += '<td>'+(result[i]['di_disposal_amount'] = null ? "" : result[i]['di_disposal_amount'])+'</td>';
					html += '<td>'+(result[i]['di_date'] = null ? "" : result[i]['di_date'])+'</td>';
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
                            '<input class="form-control listProduct" name="create_di_product['+count_product+ ']" id="create_di_product'+count_product+ '"  value="" />' +
                                '<span></span>' +
                        '</div>' +
                    '</div>' +
                '</div>';
        html += '<div class="col-sm-12 col-md-6 col-lg-6">'+
                    '<div class="form-group">' +
                        '<label class="col-md-3 control-label">廃棄数:<span class="label-form-request">*</span></label>' +
                        '<div class="col-md-8">'+
                             '<input  id="create_disposal_amount" name="create_disposal_amount['+count_product+ ']" class="form-control">'
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

			var di_base = e['di_base'];
			var di_product = e['di_product'];
			var di_date = e['di_date'];
			var id = e['id'];
			var di_disposal_amount = e['di_disposal_amount'];
			$("tr[data-id="+id+"]").remove();

			var html = "<tr data-id="+id +">";
			html += '<td>'+id+'</td>';
			html += '<td>'+di_base+'</td>';
			html += '<td>'+di_product+'</td>';
			html += '<td>'+di_disposal_amount+'</td>';
			html += '<td>'+di_date+'</td>';
			html += '<td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src='+assetImgUrl+'edit.png></a> <a data-id="'+id+'" class="delete-cat" href="#"><img src='+assetImgUrl+'del.png></a></td>';	
			html += "</tr>";
			$('#detail_data').prepend(html);
	    });

	}
	$("#save").click(function(){
			$("[name^=create_disposal_amount]").each(function () {
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

            if(raiseValidateCreate() == false)
                  return false;
            
            var data = {};
            var lstProduct = [];
            
            data.di_base 		= $("#create_di_base").val();
            data.name_di_base 	=  $("#create_di_base option:selected").text();
			data.di_date 		= $("#create_di_date").val();
			data.di_product 	= $("#create_di_product").val();

			data.name_di_product 	= $("input#inputpicker-1").val();
			//alert("data= "+data.di_product);
			data.di_disposal_amount = $("#create_disposal_amount").val();
			//get list:
			var item ={
					'product': data.di_product ,
					'name_product': data.name_di_product,
					'amount' : data.di_disposal_amount,
			};	
			lstProduct.push(item);	
			//push detail added
			var index= 1;
			var indexProduct= 2;
			$(".recordAdd").each(function(){
				var item ={
					'product': $(this).find('input[name="create_di_product['+index+']"]').val(),
					'name_product' : $(this).find('input#inputpicker-'+ indexProduct).val(),
					'amount' : $(this).find('input[name="create_disposal_amount['+index+']"]').val(),
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
		editTr.find("td:eq(1)").text($("#edit_di_base option:selected").text());
		editTr.find("td:eq(2)").text($("#edit_di_product option:selected").text());
		editTr.find("td:eq(3)").text($("#edit_disposal_amount").val());
		editTr.find("td:eq(4)").text($("#edit_di_date").val());
			
	}  
	$("#edit").click(function(){
		if(raiseValidateEdit() == false)
                  return false;

            var data = {};
            data.id 			= $("#dp_id").val();
			data.di_disposal_amount = $("#edit_disposal_amount").val();
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
		var di_base =$(this).parent().parent().find("td:eq(1)").text().trim();
		var di_product =$(this).parent().parent().find("td:eq(2)").text().trim();
		var di_disposal_amount =$(this).parent().parent().find("td:eq(3)").text().trim();
		var di_date =$(this).parent().parent().find("td:eq(4)").text().trim();
        $("#dp_id").val(id);
        $("#edit_di_base").val(di_base);
        $("#edit_di_product").val(di_product);
        $("#edit_disposal_amount").val(di_disposal_amount);
        $("#edit_di_date").val(di_date);
       
		$('select#edit_di_product option').each(function () {
		    if ($(this).text().toLowerCase() == di_product.toLowerCase()) {
		        $(this).prop('selected','selected');
		        return;
		    }
		});
		$('select#edit_di_base option').each(function () {
		    if ($(this).text().toLowerCase() == di_base.toLowerCase()) {
		        $(this).prop('selected','selected');
		        return;
		    }
		});
    })

	$("#edit_form").validate({
            rules : {
            	
            	edit_disposal_amount:{
            		required: true,
            		number: true, 
				    min: 0,
				    max: 2147483647,
            	},
            	
            },
            tooltip_options: {  // <- totally invalid option
		       
		       edit_disposal_amount: {
		            placement: 'bottom',html:true
		        },
		       
			}
      });

	$("#form").validate({
            rules : {
            	create_di_base:{
            		required:true
            	},
            	create_di_product:{
            		required:true,
            	},
            	create_di_date:{
            		required:true
            	},
        //     	create_disposal_amount:{
        //     		required: true,
        //     		number: true, 
				    // min: 0,
				    // max: 2147483647,
        //     	},
            	
            },
            tooltip_options: {  // <- totally invalid option
		        create_di_base: {
		            placement: 'top'
		        },
		        create_di_product: {
		            placement: 'bottom',html:true
		        },
		        create_di_date: {
		            placement: 'top'
		        },
		        // create_disposal_amount: {
		        //     placement: 'bottom'
		        // },
		       
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
		var di_base  		= $("#di_base").val();
		var di_from_date 	= $("#di_from_date").val();
		var di_to_date      = $("#di_to_date").val();
		var di_product      = $("#di_product").val();
	  	if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
		 	if(called_index == start_index)
		 		return;
		 	called_index = start_index;
	      $.ajax({
	              url:catViewUrl,
				  data:{di_base: di_base,di_from_date : di_from_date, di_to_date: di_to_date, di_product : di_product, start_index:start_index},
	              type: 'GET',
	              dataType:'json',
	              success: function(result) {
		              if(result.length>0){
			              for(var i=0; i<result.length; i++){
							var html = '<tr data-id='+result[i]['id'] +'>';
							html += '<td>'+(result[i]['id'] = null ? "" : result[i]['id'])+'</td>';
							html += '<td>'+(result[i]['di_base'] = null ? "" : result[i]['di_base'])+'</td>';
							html += '<td>'+(result[i]['di_product'] = null ? "" : result[i]['di_product'])+'</td>';
							html += '<td>'+(result[i]['di_disposal_amount'] = null ? "" : result[i]['di_disposal_amount'])+'</td>';
							html += '<td>'+(result[i]['di_date'] = null ? "" : result[i]['di_date'])+'</td>';
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

