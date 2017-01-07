(function($){
	$(function(){
		$('.modal').modal();
	});
})(jQuery);
$("#filesAdd").on('click', function(){
	$("#issueFiles").toggleClass('hide');
	$(this).toggleClass('hide');
});
	
$("#modal_btn").on('click', function() {
	head = $("#issue").val();
	text = $("#text").val();
	files = JSON.stringify(Object.keys(_FILENAMES_));
	$.post('./api/CreateIssue/', {head:head, text: text, attachments: files}, function(d){
		if(d["code"] == 0) {
			$("#issue").val('');
			$("#text").val('');
			Dropzone.instances[0].removeAllFiles();
			setTimeout(function(){
				//window.location.relooad();
			}, 2000);
		} else {
			// TODO: need to edit the code below
			/*$("#modal_head").text("Внимание!");
			$("#modal_text").text(d["error"]);
			$("#modal_btn").addClass('white-text');
			$("#modal_btn").removeClass('green');
			$("#modal_btn").addClass('red accent-4');
			$('#modal').modal('open');
			*/
			console.log(d);
		}
	});
});

$("#create").on('click', function(){
	$("#modal").modal("open");
});
Dropzone.options.issueFiles = {
	maxFilesize: 2,
	acceptedFiles: "image/*,video/*",
	renameFilename: function(name){
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for(var i=0; i < 6; i++) {
			text += possible.charAt(Math.floor(Math.random() * possible.length));
		}
		return text + "_" + name;
	}
};