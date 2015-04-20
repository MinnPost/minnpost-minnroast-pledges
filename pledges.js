function refreshTable(details) {
	if (details == true) {
		$('.results').load('data/table.php', function(){
			setTimeout(refreshTable, 5000);
		});
	} else {
		$('.results').load('data/div.php', function(){
			setTimeout(refreshTable, 5000);
		});
	}
}

$(document).ready(function() {
	if ($('.all-pledges').length > 0) {
		$('.all-pledges').wrap('<div class="results"></div>');
		refreshTable(true);
	} else {
		$('.total-pledges').wrap('<div class="results"></div>');
		refreshTable(false);
	}
});