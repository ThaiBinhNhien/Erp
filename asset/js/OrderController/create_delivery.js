$(document).ready(function() {
    $('.orderDate, .orderToDate').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy年mm月dd日 (DD)',
        dayNames: ['日', '月', '火', '水', '水', '金', '土']
    }).attr('readonly','readonly');
    $('.orderDate').datepicker('setDate', 'today');
    $('.orderToDate').datepicker('setDate', 'today + 1');
});

// Save
$(document).on('click', '#btnSave', function() {

});