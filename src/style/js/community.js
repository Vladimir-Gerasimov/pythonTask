$("#create").on('click', function(){
	$("#modal").modal("open");
});

Dropzone.options.issueFiles = {
	maxFilesize: 2,
	acceptedFiles: "image/*,video/*",
	renameFilename: function(name){
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for( var i=0; i < 6; i++ ) {
			text += possible.charAt(Math.floor(Math.random() * possible.length));
		}
		return text + "_" + name;
	}
};

pollItems = 0;
$("#newPollItem").on('click', function() {
	$("#poll_container").append("<div class='input-field col s12 m8'>\n<input id='poll_item_" + pollItems + "' type='text'>\n<label class='red-text text-accent-4' for='poll_item_" + pollItems + "'>Новый пункт</label>\n</div>");
	pollItems++;
});
	
$("#filesAdd").on('click', function(){
	$("#issueFiles").toggleClass('hide');
	$(this).toggleClass('hide');
});
$("#pollAdd").on('click', function(){
	$("#poll").toggleClass('hide');
	$(this).toggleClass('hide');
	pollItems = 1;
});
	
function createTopic(pollId){
	files = JSON.stringify(Object.keys(_FILENAMES_));
	$.post('./api/CreateThread', { head: $("#head").val(), text: $("#text").val(), poll: pollId, attachments: files}, function(d){
		if(d["code"] == 0) {
			//window.location.href = "community/" + d["data"]["id"];
		} else {
			// error handling
		}
	});
}
	
$("#modal_btn").on('click', function(){
	pollId = -1;
	if(pollItems > 0) {
		items = [];
		$("[id^=poll_item]").each(function(){
			if( $(this).val() != "" ) {
				items.push( $(this).val() );
			}
		});
		if(items.length > 0){
			$.post( './api/CreatePoll', {items:JSON.stringify(items)}, function(d){
				if(d["code"] == 0) {
					createTopic(d["data"]["id"]);
				} else {
					// error handling
				}
			});
		}
	} else {
		createTopic(pollId);
	}
});