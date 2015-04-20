function refreshTable(){
    $('.results').load('data/table.php', function(){
       setTimeout(refreshTable, 5000);
    });
}

$(document).ready(function(){
	$('.all-pledges').wrap('<div class="results"></div>');
  refreshTable();
});