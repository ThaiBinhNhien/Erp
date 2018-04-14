$(".del-export-order").click(function(){
	$(this).helloWorld('出庫伝票を削除します。よろしいですか？',base_url+'purchase/export-purchase',null,{
		url : base_url + 'purchase/ajax_del_export_order',
		data : {
			id : $('#id-export-order').text()
		},
		error_message: '出庫伝票を削除します。よろしいですか？',
		ok_text: "Ok",
        cancel_text: 'キャンセル'
	});
});