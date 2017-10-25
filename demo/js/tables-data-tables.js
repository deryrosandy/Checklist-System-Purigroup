jQuery(function ($) {
    'use strict';
	
	var table = $('#table-basic').DataTable({
		columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        }]
	});
	

	// Handle click on "Select all" control
	$('#select-all-row').on('click', function(){
		// Get all rows with search applied
		var rows = table.rows({ 'search': 'applied' }).nodes();
		// Check/uncheck checkboxes for all rows in the table
		$('input[type="checkbox"]', rows).prop('checked', this.checked);
	});

	// Handle click on checkbox to set state of "Select all" control
	$('#table-basic').on('change', 'input[type="checkbox"]', function(){
	  // If checkbox is not checked
	  if(!this.checked){
		 var el = $('#example-select-all').get(0);
		 // If "Select all" control is checked and has 'indeterminate' property
		 if(el && el.checked && ('indeterminate' in el)){
			// Set visual state of "Select all" control 
			// as 'indeterminate'
			el.indeterminate = true;
		 }
	  }
	});

	// Handle form submission event
	$('#frm-example').on('submit', function(e){
	  var form = this;

	  // Iterate over all checkboxes in the table
	  table.$('input[type="checkbox"]').each(function(){
		 // If checkbox doesn't exist in DOM
		 if(!$.contains(document, this)){
			// If checkbox is checked
			if(this.checked){
			   // Create a hidden element 
			   $(form).append(
				  $('<input>')
					 .attr('type', 'hidden')
					 .attr('name', this.name)
					 .val(this.value)
			   );
			}
		 } 
	  });
	});

	
    $('#table-basic_wrapper select.form-control').select2({minimumResultsForSearch: -1});
});
// Hidden row details example
jQuery(function () {
    'use strict';
    function format(data) {
        return '<p class="lead">Details</p>' +
            'Rendering engine: ' + data[1] + ' ' + data[4] + '<br>' +
            'Browser: ' + data[2] + '<br>' +
            '&hellip;';
    }

    var $rowDetailsTable = $('#table-hidden-row-details');
    // Insert a 'dt-details-control' column to the table
    $rowDetailsTable.find('thead tr, tfoot tr').each(function () {
        this.insertBefore(document.createElement('th'), this.childNodes[0]);
    });
    $rowDetailsTable.find('tbody tr').each(function () {
        $(this).prepend('<td class="dt-details-control"><i class="fa fa-fw dt-details-toggle"></i></td>');
    });

    var rowDetailsTable = $rowDetailsTable.dataTable({
        'processing': true,
        'aoColumnDefs': [
            { 'bSortable': false, 'aTargets': [ 0 ] }
        ],
        'order': [
            [1, 'asc']
        ]
    });
    $rowDetailsTable.find('tbody').on('click', 'tr td:first-child', function () {
        var tr = $(this).parents('tr');
        var row = $rowDetailsTable.api().row(tr);
        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

        } else {
            tr.addClass('details');
            row.child(format(row.data())).show();

        }
    });

    $('#table-hidden-row-details_wrapper select.form-control').select2({minimumResultsForSearch: -1});
});
