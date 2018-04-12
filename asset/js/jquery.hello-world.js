	var ajax_url = '';
	var ajax_data = null;
	var my_error_message = '';
	var link_redirect = '';
	var this_element = null;
	var cancel_callback_function = null; 
	var success_callback_function = null;
	var success_callback_data = null;
	var not_ajax = false;
	var is_master= false;
	(function($) {
	    jQuery.fn.helloWorld = function(content, link1, link2, options) {
	        var settings = $.extend({
	            // These are the defaults.
	            url: "",
	            data: null,
	            error_message: "",
	            ok_text: "Ok",
	            cancel_text: "キャンセル",//キャンセル ~ Cancel
	            cancel_callback_function: null,
	            success_callback_function: null,
	            success_callback_data: null,
	            not_ajax: false,
	            is_master: false,
	        }, options);
	        this_element = $(this);
	        //console.log(arguments.length);
	        if (arguments.length == 1) {
	            $('#dialog-form').remove();
	            $('#cover').remove();
	            var click_html = link1 != null ? '' + "''" : 'onclick="close_popup()"';
	            $('body').append('<div id="dialog-form" style="display:block"><a href="#" class="cancel"><span class="top-right"></span>&times;</a><h3>Hellow world</h3><center><button ' + click_html + ' id="yes">' + settings.ok_text + '</button>');
	            $('body').append('<div id="cover" style="display:block">');
	            $('#dialog-form h3').text(content);
	        }
	        if (arguments.length == 2) {
	            $('#dialog-form').remove();
	            $('#cover').remove();
	            var click_html = link1 != null ? 'onclick=location.href=' + "'" + link1 + "'" : 'onclick="close_popup()"';
	            $('body').append('<div id="dialog-form" style="display:block"><a href="#" class="cancel"><span class="top-right"></span>&times;</a><h3>Hellow world</h3><center><button ' + click_html + ' id="yes">' + settings.ok_text + '</button>');
	            $('body').append('<div id="cover" style="display:block">');
	            $('#dialog-form h3').text(content);
	        }
	        if (arguments.length == 3) {
	            $('#dialog-form').remove();
	            $('#cover').remove();
	            var link1_html = link1 != null ? 'onclick=location.href=' + "'" + link1 + "'" : 'onclick="close_popup()"';
	            var link2_html = link2 != null ? 'onclick=location.href=' + "'" + link2 + "'" : 'onclick="close_popup()"';
	            $('body').append('<div id="dialog-form"><a href="#" class="cancel"><span class="top-right"></span>&times;</a><h3>Hellow world</h3><center><button ' + link1_html + ' id="yes">' + settings.ok_text + '</button><button ' + link2_html + ' id="no">' + settings.cancel_text + '</button></center>');
	            $('body').append('<div id="cover">');
	            $('#dialog-form h3').text(content);
	        }

	        if (arguments.length == 4) {
	            $('#dialog-form').remove();
	            $('#cover').remove();
	            $('body').append('<div id="dialog-form" style="display:block"><a href="#" class="cancel"><span class="top-right"></span>&times;</a><h3>Hellow world</h3><center><button id="confirm_yes">' + settings.ok_text + '</button><button id="confirm_no">' + settings.cancel_text + '</button>');
	            $('body').append('<div id="cover" style="display:block">');
	            $('#dialog-form h3').html(content);
	            ajax_url = settings.url;
	            ajax_data = settings.data;
	            my_error_message = settings.error_message;
	            cancel_callback_function = settings.cancel_callback_function;
	            success_callback_function = settings.success_callback_function;
	            success_callback_data = settings.success_callback_data;
	            link_redirect = link1;
	            not_ajax = settings.not_ajax;
	            is_master = settings.is_master;
	        }

		}
		

		jQuery.fn.helloWorldOpenWindow = function(content, link) {
			$('#dialog-form').remove();
			$('#cover').remove();
			$('body').append('<div id="dialog-form" style="display:block"><a href="#" class="cancel"><span class="top-right"></span>&times;</a><h3>Hellow world</h3><center><a href="'+link+'" class="btn-from-ok-popup" target="_blank" onclick="close_popup()">Ok</a>');
			$('body').append('<div id="cover" style="display:block">');
			$('#dialog-form h3').text(content);
		}
		
		jQuery.fn.helloWorldOpenConfirm = function(content, value_confirm) {
			$('#dialog-form').remove();
			$('#cover').remove();
			$('body').append('<div id="dialog-form" style="display:block"><a href="#" class="cancel"><span class="top-right"></span>&times;</a><h3>Hellow world</h3><center><a class="btn-from-ok-popup" id="open_popup_confirm" data-value="'+value_confirm+'">Ok</a><button id="confirm_no">キャンセル</button>');
			$('body').append('<div id="cover" style="display:block">');
			$('#dialog-form h3').text(content);
	    }


	    $(document).on("click", "#confirm_yes", function() {
	        var mythis = $(this);
	        if(not_ajax == true){
	        	if (success_callback_function !== null) {
		        	window[success_callback_function](success_callback_data);
		        }
		        close_popup();
	        	return;
	        }
	        $.ajax({
	            url: ajax_url,
	            data: ajax_data,
	            dataType: 'json',
	            method: 'POST',
	            success: function(result) {
	                if (result.success != false) {
	                	if(!isUndefined(result.prevent_redirect) && result.prevent_redirect == true) {
	                		this_element.helloWorld(result.message, null);
	                	}
	                    else {
	                    	if(link_redirect != null)
	                    		location.href = link_redirect;
	                    	else{
	                    		
	                    		if(is_master == false){
	                    			this_element.helloWorld(result.message, null);
	                    		}else{
	                    			close_popup();
	                    		}

	                    	}
	                    }
	                    if (success_callback_function !== null) {
				            window[success_callback_function](success_callback_data,result);
				        }
	                } else {
	                	if(is_master == true){
	                		//custom msg for initial_inventory and disposal_inventory
	                		var msg= result.message;
	                		if(result.name_product != ''){
			            		msg = String.format(msg,result.name_product);
			            		result.message =msg;
			            	}
	                	}
	                    this_element.helloWorld(result.message, null);
	                }
	            },
	            error: function(request, error) {
	            	console.log(error);
	                this_element.helloWorld(my_error_message, null);
	            }
	        })
	    });
	    $(document).on("click", "#confirm_no", function() {
	        $('#dialog-form').remove();
	        $('#cover').remove();
	        if (cancel_callback_function !== null) {
	            window[cancel_callback_function]();
	        }
	    });


	}(jQuery));

	function close_popup() {
	    $('#dialog-form').remove();
	    $('#cover').remove();
	}

	function open_popup() {
	    $('#dialog-form').remove();
		$('#cover').remove();
	}

	function isUndefined(value) {
	    var undefined = void (0);
	    return value === undefined;
	}