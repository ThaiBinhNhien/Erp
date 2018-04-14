$('.purchase-confirm').click(function(){
	var order_id = $('#order_id').text();
	var confirm_user = $('#user_login').val();
	$(this).helloWorld('発注伝票を承認します。よろしいでしょうか？',base_url+'purchase',null,
	{
		url : base_url + 'purchase/ajax_confirm_order_purchase',
		data : {
			order_id : order_id,
			confirm_user : confirm_user
		},
		error_message: '発注伝票を承認します。よろしいでしょうか？',
		success_callback_function: "confirm",
        ok_text: "Ok",
        cancel_text: 'キャンセル'
	});
});

$('.del-confirm').click(function(){//xóa xác nhận
	var order_id = $('#order_id').text();
	var confirm_user = $('#user_login').val();
	$(this).helloWorld('発注伝票の承認を取り消します。よろしいでしょうか？',base_url+'purchase',null,
	{
		url : base_url + 'purchase/ajax_confirm_order_purchase',
		data : {
			order_id : order_id,
			confirm_user : confirm_user,
			delete_flag : 1
		},
		error_message: '発注伝票の承認を取り消します。よろしいでしょうか？',
		success_callback_function: "del_confirm",
        ok_text: "Ok",
        cancel_text: 'キャンセル'
	});
});

$('.del-purchase-order').click(function(){
	var order_id = $('#order_id').text();
	$(this).helloWorld('発注伝票を削除します。よろしいですか？',base_url+'purchase',null,
	{
		url : base_url + 'purchase/ajax_del_purchase_order',
		data : {
			order_id : order_id
		},
		error_message: '発注伝票を削除します。よろしいですか？',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
	});
});

function confirm() {
	var order_id = $('#order_id').text();
	var dataString = { 
            username : user_create,
            subject : "発注伝票の承認",
            message : "発注No: "+order_id+"を承認しました。"
        };

        $.ajax({
            type: "POST",
            url: url_add_post_notification,
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){

                if(data.success == true){
                    // Success
                    add_notification_realtime(data);
                }
        
            } ,error: function(xhr, status, error) {
            },
        });
}

function del_confirm() {
	var order_id = $('#order_id').text();
	var dataString = { 
            username : user_create,
            subject : "発注伝票承認の取り消し",
            message : "発注No: "+order_id+" の承認のを取り消しました。"
        };

        $.ajax({
            type: "POST",
            url: url_add_post_notification,
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){

                if(data.success == true){
                    // Success
                    add_notification_realtime(data);
                }
        
            } ,error: function(xhr, status, error) {
            },
        });
}