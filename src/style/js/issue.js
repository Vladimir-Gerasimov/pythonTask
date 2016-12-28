(function($){
  $(function(){
		$('.modal').modal();
		$("#create").on('click', function(){
			$("#modal").modal("open");
		});
  }); // end of document ready
})(jQuery); // end of jQuery name space