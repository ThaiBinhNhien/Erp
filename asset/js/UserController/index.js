$(".user-list table tbody tr").click(function() {
	var id = $(this).find('td').first().text();
	window.location='/master/user/edit?i=' + id;
})