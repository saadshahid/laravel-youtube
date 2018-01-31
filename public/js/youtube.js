// When Enter key is pressed
$(document).keypress(function(e) {
    if(e.which == 13) {
        search()
    }
});

// Search for a specified string.
function search() {
	var url = "youtube?q="+$('#q').val()+"&maxResults="+$('#maxResults').val();
	if ($('#q').val() != "") {
		$.ajax({
			url: url,
			dataType: "json",
			timeout: 10000,
			success: function (response) {
				console.log(response);
				$('#search-list').html(response.htmlBody);
			},
			error: function () {
				alert("Error getting from server")
			}
		}).done(function (resp) {
			
		});
	}
}