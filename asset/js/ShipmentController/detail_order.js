

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

$(document).on("click","#btnExportCsv", function(){
	var TotalContainer = $('#shipmentTotal').val();
	var Weight = $('#shipmentWeight').val();
	var truck = $('#shipmentTruck_Main').val();
	var Nonsense = $('#shipmentTruck_Aid').val();
	var getUrl = urlExportCsvDetail.split("?")[0];
	getUrl = getUrl + '?id=' + id_export_detail + '&csv=true&TotalContainer=' + 
	TotalContainer + '&Weight=' + Weight + '&truck=' + truck + '&Nonsense=' + 
	Nonsense;
	window.open(getUrl, '_blank');
});