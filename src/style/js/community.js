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
	
	function createTopic( pollId ){
		console.log(4);
		files = Object.keys(_FILENAMES_).join(',');
		$.post('./api/create_topic', { head: $("#head").val(), text: $("#text").val(), poll: pollId, attachments: files}, function(d){
			if( !d.match(/.*error.*/i) ) {
				if( d.match(/id:(\d+)/) ){
					matches = d.match(/id:(\d+)/);
					threadId = matches[matches.length - 1];
					//window.location.href = "community/" + threadId;
				}
			} else {
				// error handling
			}
		});
	}
	
	$("#modal_btn").on('click', function(){
		pollId = -1;
		console.log(1);
		if(pollItems > 0) {
		console.log(2);
			items = [];
			$("[id^=poll_item]").each(function(){
				if( $(this).val() != "" ) {
					items.push( $(this).val() );
				}
			});
			if(items.length > 0){
		console.log(3);
				$.post( './api/create_poll/', {items:JSON.stringify(items)}, function(d){
					if( !d.match(/.*error.*/i) ) {
						if( d.match(/id:(\d+)/) ){
							matches = d.match(/id:(\d+)/);
							pollId = matches[matches.length - 1];
							createTopic(pollId);
						} else {
							////
						}
					} else {
						////
					}
				});
			}
		} else {
			createTopic(pollId);
		}
		
		
		
	});