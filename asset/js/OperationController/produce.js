$(document).ready(function() {
$('#prod-1 > input').click(function() {
if ($('#prod-1 > input').is(":checked"))
		{
			$('.wrap-input-1 input,.wrap-input-1 select').removeAttr('disabled','disabled');
			$('.wrap-input-2 input,.wrap-input-2 select,.wrap-input-3 input,.wrap-input-3 select,.wrap-input-4 input,.wrap-input-5 input,.wrap-input-6 input,.wrap-input-6 select,.wrap-input-7 input,.wrap-input-8 input,.wrap-input-8 select').attr('disabled','disabled');

		}
 })
$('#prod-2 > input').click(function() {
 if ($('#prod-2  > input').is(":checked"))
		{
			$('.wrap-input-2 input,.wrap-input-2 select').removeAttr('disabled','disabled');
			$('.wrap-input-1 input,.wrap-input-1 select,.wrap-input-3 input,.wrap-input-3 select,.wrap-input-4 input,.wrap-input-5 input,.wrap-input-6 input,.wrap-input-6 select,.wrap-input-7 input,.wrap-input-8 input,.wrap-input-8 select').attr('disabled','disabled');

		}
 })
$('#prod-3  > input').click(function() {
 if ($('#prod-3  > input').is(":checked"))
		{
			$('.wrap-input-3 input,.wrap-input-3 select').removeAttr('disabled','disabled');
			$('.wrap-input-1 input,.wrap-input-1 select,.wrap-input-2 input,.wrap-input-2 select,.wrap-input-4 input,.wrap-input-5 input,.wrap-input-6 input,.wrap-input-6 select,.wrap-input-7 input,.wrap-input-8 input,.wrap-input-8 select').attr('disabled','disabled');

		}
 })
$('#prod-4  > input').click(function() {
 if ($('#prod-4  > input').is(":checked"))
		{
			$('.wrap-input-4 input').removeAttr('disabled','disabled');
			$('.wrap-input-2 input,.wrap-input-2 select,.wrap-input-1 select,.wrap-input-3 input,.wrap-input-3 select,.wrap-input-1 input,.wrap-input-5 input,.wrap-input-6 input,.wrap-input-6 select,.wrap-input-7 input,.wrap-input-8 input,.wrap-input-8 select').attr('disabled','disabled');

		}
 })
$('#prod-5  > input').click(function() {
 if ($('#prod-5  > input').is(":checked"))
		{
			$('.wrap-input-5 input').removeAttr('disabled','disabled');
			$('.wrap-input-2 input,.wrap-input-2 select,.wrap-input-1 select,.wrap-input-3 input,.wrap-input-3 select,.wrap-input-4 input,.wrap-input-1 input,.wrap-input-6 input,.wrap-input-6 select,.wrap-input-6 input,.wrap-input-6 select,.wrap-input-7 input,.wrap-input-8 input,.wrap-input-8 select').attr('disabled','disabled');

		}
 })
$('#prod-6  > input').click(function() {
 if ($('#prod-6  > input').is(":checked"))
		{
			$('.wrap-input-6 input,.wrap-input-6 select').removeAttr('disabled','disabled');
			$('.wrap-input-2 input,.wrap-input-2 select,.wrap-input-1 select,.wrap-input-3 input,.wrap-input-3 select,.wrap-input-4 input,.wrap-input-5 input,.wrap-input-1 input,.wrap-input-7 input,.wrap-input-8 input,.wrap-input-8 select').attr('disabled','disabled');

		}
 })
$('#prod-7  > input').click(function() {
 if ($('#prod-7  > input').is(":checked"))
		{
			$('.wrap-input-7 input,.wrap-input-7 select').removeAttr('disabled','disabled');
			$('.wrap-input-2 input,.wrap-input-2 select,.wrap-input-1 select,.wrap-input-3 input,.wrap-input-3 select,.wrap-input-4 input,.wrap-input-5 input,.wrap-input-6 input,.wrap-input-6 select,.wrap-input-1 input,.wrap-input-8 input,.wrap-input-8 select').attr('disabled','disabled');

		}
 })
$('#prod-8  > input').click(function() {
 if ($('#prod-8  > input').is(":checked"))
		{
			$('.wrap-input-8 input,.wrap-input-8 select').removeAttr('disabled','disabled');
			$('.wrap-input-2 input,.wrap-input-2 select,.wrap-input-1 select,.wrap-input-3 input,.wrap-input-3 select,.wrap-input-4 input,.wrap-input-5 input,.wrap-input-6 input,.wrap-input-6 select,.wrap-input-1 input,.wrap-input-7 input').attr('disabled','disabled');

		}
 })

	function export_1($print,$csv){
		var date_from = $("#ep1_date_from").val();
		var date_to = $("#ep1_date_to").val();
		var date1 = new Date(date_from);
		var date2 = new Date(date_to);
		if(date1 > date2 || date_from == '' || date_to == ''){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
		if(diffDays > 31){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		//var hotel_check = $("#hotel_check").is(":checked");
		//var tenant_check = $("#tenant_check").is(":checked");
		if($csv == false){
			window.open(ep1_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}else{
			window.open(ep1_csv_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}
		
	}

	function export_2($print,$csv){
		var date_from = $("#ep2_date_from").val();
		var date_to = $("#ep2_date_to").val();
		var date1 = new Date(date_from);
		var date2 = new Date(date_to);
		if(date1 > date2 || date_from == '' || date_to == ''){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
		if(diffDays > 31){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var hotel_check = $("#ep2_hotel_check").is(":checked");
		var tenant_check = $("#ep2_tenant_check").is(":checked");
		var check = $("#ep2_select").val();
		if($csv == false){
			if(check == 1)
				window.open(ep2_1_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
			if(check == 2)
				window.open(ep2_2_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}else{
			if(check == 1)
				window.open(ep2_csv_1_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
			if(check == 2)
				window.open(ep2_csv_2_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}
		
	}

	function export_3($print,$csv){
		var date_from = $("#ep3_date_from").val();
		var date_to = $("#ep3_date_to").val();
		var date1 = new Date(date_from);
		var date2 = new Date(date_to);
		if(date1 > date2 || date_from == '' || date_to == ''){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
		if(diffDays > 31){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var cus = $("#ep3_cus").val();
		if($csv == false){
			window.open(ep3_url+"?date_from="+date_from+"&date_to="+date_to+"&cus="+cus+"&print="+$print, '_blank');
		}else{
			window.open(ep3_csv_url+"?date_from="+date_from+"&date_to="+date_to+"&cus="+cus+"&print="+$print, '_blank');
		}
		
	}

	function export_4($print,$csv){
		var date_from = $("#ep4_date_from").val();
		var date_to = $("#ep4_date_to").val();
		var date1 = new Date(date_from);
		var date2 = new Date(date_to);
		if(date1 > date2 || date_from == '' || date_to == ''){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
		if(diffDays > 31){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		if($csv == false){
			window.open(ep4_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}else{
			window.open(ep4_csv_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}
		
	}

	function export_5($print,$csv){
		var date_from = $("#ep5_date_from").val();
		var date_to = $("#ep5_date_to").val();
		var date1 = new Date(date_from);
		var date2 = new Date(date_to);
		if(date1 > date2 || date_from == '' || date_to == ''){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
		if(diffDays > 31){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		if($csv == false){
			window.open(ep5_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}else{
			window.open(ep5_csv_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}
		
	}

	function export_6($print,$csv){
		var date_from = $("#ep6_date_from").val();
		var date_to = $("#ep6_date_to").val();
		var machine = $("#machine").val();
		var laundry = $("#laundry").val();
		var date1 = new Date(date_from);
		var date2 = new Date(date_to);
		if(date1 > date2 || date_from == '' || date_to == ''){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
		if(diffDays > 31){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		if($csv == false){
			if($("#ep6_1").is(":checked"))
				window.open(ep6_1_url+"?date_from="+date_from+"&date_to="+date_to+"&machine="+machine+"&laundry="+laundry+"&print="+$print, '_blank');
			if($("#ep6_2").is(":checked"))
				window.open(ep6_2_url+"?date_from="+date_from+"&date_to="+date_to+"&machine="+machine+"&laundry="+laundry+"&print="+$print, '_blank');
			if($("#ep6_3").is(":checked"))
				window.open(ep6_3_url+"?date_from="+date_from+"&date_to="+date_to+"&machine="+machine+"&laundry="+laundry+"&print="+$print, '_blank');
			if($("#ep6_4").is(":checked"))
				window.open(ep6_4_url+"?date_from="+date_from+"&date_to="+date_to+"&machine="+machine+"&laundry="+laundry+"&print="+$print, '_blank');
		}else{
			if($("#ep6_1").is(":checked"))
				window.open(ep6_csv_1_url+"?date_from="+date_from+"&date_to="+date_to+"&machine="+machine+"&laundry="+laundry+"&print="+$print, '_blank');
			if($("#ep6_2").is(":checked"))
				window.open(ep6_csv_2_url+"?date_from="+date_from+"&date_to="+date_to+"&machine="+machine+"&laundry="+laundry+"&print="+$print, '_blank');
			if($("#ep6_3").is(":checked"))
				window.open(ep6_csv_3_url+"?date_from="+date_from+"&date_to="+date_to+"&machine="+machine+"&laundry="+laundry+"&print="+$print, '_blank');
			if($("#ep6_4").is(":checked"))
				window.open(ep6_csv_4_url+"?date_from="+date_from+"&date_to="+date_to+"&machine="+machine+"&laundry="+laundry+"&print="+$print, '_blank');
		}
		
	}

	function export_7($print,$csv){
		var date_from = $("#ep7_date_from").val();
		var date_to = $("#ep7_date_to").val();
		var date1 = new Date(date_from);
		var date2 = new Date(date_to);
		if(date1 > date2 || date_from == '' || date_to == ''){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
		if(diffDays > 31){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		if($csv == false){
			window.open(ep7_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}else{
			window.open(ep7_csv_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}
		
		
	}

	function export_8($print,$csv){
		var date_from = $("#ep8_date_from").val();
		var date_to = $("#ep8_date_to").val();
		var date1 = new Date(date_from);
		var date2 = new Date(date_to);
		if(date1 > date2 || date_from == '' || date_to == ''){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
		if(diffDays > 31){
			$('#print_pdf').helloWorld('無効な日付が選択されました。',null);
			return;
		}
		if($csv == false){
			if($("#boiler").is(":checked"))
				window.open(ep8_1_url+"?date_from="+date_from+"&date_to="+date_to+"&type=1"+"&print="+$print, '_blank');
			if($("#boiler_old").is(":checked"))
				window.open(ep8_1_url+"?date_from="+date_from+"&date_to="+date_to+"&type=1"+"&print="+$print, '_blank');
			if($("#boiler_graph").is(":checked"))
				window.open(ep8_2_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}else{
			if($("#boiler").is(":checked"))
				window.open(ep8_csv_1_url+"?date_from="+date_from+"&date_to="+date_to+"&type=1"+"&print="+$print, '_blank');
			if($("#boiler_old").is(":checked"))
				window.open(ep8_csv_1_url+"?date_from="+date_from+"&date_to="+date_to+"&type=1"+"&print="+$print, '_blank');
			if($("#boiler_graph").is(":checked"))
				window.open(ep8_csv_2_url+"?date_from="+date_from+"&date_to="+date_to+"&print="+$print, '_blank');
		}
		
		
	}
	$("#print_csv").click(function(){
		if ($('#rd-prod-1').is(":checked")){
			export_1(true,true);
		}
		if ($('#rd-prod-2').is(":checked")){
			export_2(true,true);
		}
		if ($('#rd-prod-3').is(":checked")){
			export_3(true,true);
		}
		if ($('#rd-prod-4').is(":checked")){
			export_4(true,true);
		}
		if ($('#rd-prod-5').is(":checked")){
			export_5(true,true);
		}
		if ($('#rd-prod-6').is(":checked")){
			export_6(true,true);
		}
		if ($('#rd-prod-7').is(":checked")){
			export_7(true,true);
		}
		if ($('#rd-prod-8').is(":checked")){
			export_8(true,true);
		}
	})
	$("#print_pdf").click(function(){
		if ($('#rd-prod-1').is(":checked")){
			export_1(true,false);
		}
		if ($('#rd-prod-2').is(":checked")){
			export_2(true,false);
		}
		if ($('#rd-prod-3').is(":checked")){
			export_3(true,false);
		}
		if ($('#rd-prod-4').is(":checked")){
			export_4(true,false);
		}
		if ($('#rd-prod-5').is(":checked")){
			export_5(true,false);
		}
		if ($('#rd-prod-6').is(":checked")){
			export_6(true,false);
		}
		if ($('#rd-prod-7').is(":checked")){
			export_7(true,false);
		}
		if ($('#rd-prod-8').is(":checked")){
			export_8(true,false);
		}
	})

	$("#preview").click(function(){
		if ($('#rd-prod-1').is(":checked")){
			export_1(false,false);
		}
		if ($('#rd-prod-2').is(":checked")){
			export_2(false,false);
		}
		if ($('#rd-prod-3').is(":checked")){
			export_3(false,false);
		}
		if ($('#rd-prod-4').is(":checked")){
			export_4(false,false);
		}
		if ($('#rd-prod-5').is(":checked")){
			export_5(false,false);
		}
		if ($('#rd-prod-6').is(":checked")){
			export_6(false,false);
		}
		if ($('#rd-prod-7').is(":checked")){
			export_7(false,false);
		}
		if ($('#rd-prod-8').is(":checked")){
			export_8(false,false);
		}
	})
});