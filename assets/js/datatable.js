import $ from 'jquery';

$(document).ready( function () {
    $('#datatable').DataTable();

    $('#datatableLocation').DataTable({
    	'order': [0, 'desc']
    });
});