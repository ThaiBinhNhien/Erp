var table = $("#tableLog").DataTable( {
    "scrollY":        "360px",
    "scrollCollapse": true,
    "paging":         false,
    responsive: true,
    searching: false, 
    paging: false,
    "ordering": true, 
    "info":     false,
    "order": [[ 0, "desc" ]],
    "language": {
        "search": "検索:"
      }
}); 

// Scroll
var called_index = 0;
$('#list-table .dataTables_scrollBody').on('scroll', function() {
    var start_index = $('#list-table tbody tr').length;

    var input_search_in = $('#inputLabel3').val();
    var input_search_name = $('#inputLabel4').val();

     if($(this)[0].scrollHeight - $(this).scrollTop() >= ($(this).outerHeight() - 20) && $(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
        if(called_index == start_index)
            return;
        called_index = start_index;
        $.ajax({
            url:url_get_log,
            data:{start_index:start_index},
            dataType:'json',
            method:'GET',
            success:function(result){

            var html = '';
            for(var i=0; i<result.length; i++){
                html += '<tr>';
                html += '<td>'+result[i]['date']+'</td>';
                html += '<td>'+result[i]['user']+'</td>';
                html += '<td>'+result[i]['table']+'</td>';
                html += '<td>'+result[i]['name_access']+'</td>';
                html += '<td>'+result[i]['infor']+'</td>';
                html += '</tr>';
            }
                
            $("#list-table tbody").append(html);
            // Adjust
            var table = $('#list-table table').DataTable();
            table.columns.adjust();

            }
        });
    }
});