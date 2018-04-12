$('.del-sale').click(function(){
	var invoice_id = $('#invoice_no').val();
	$(this).helloWorld('請求書を削除します。よろしいですか？',base_url+"sale/created_sale",null,{
        url: base_url+"sale/ajax_del_sale",
        data : {
            invoice_id : invoice_id
        },
        error_message: '請求書を削除します。よろしいですか',
        ok_text: "Ok",
        cancel_text: 'キャンセル'
    });
});