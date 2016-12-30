
  <div class="container">

      
		  <div class="row">
			<? echo $sidebar; ?>
			<div class="col m9 s12">
				<? echo $header; ?>
		  <? if(Flight::getGlobal('user_logged')){ ?>
				<script src="style/js/dropzone.js"></script>
				<script type="text/javascript">
				Dropzone.options.issueFiles = {
					maxFilesize: 2,
					acceptedFiles: "image/*,video/*",
					renameFilename: function(name){
						add = "<? echo Flight::getGlobal('user_id');?>";
						var text = "";
						var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
						for( var i=0; i < 6; i++ ) {
							text += possible.charAt(Math.floor(Math.random() * possible.length));
						}
						return add + "_" + text + "_" + name;
					}
				};

				</script>
				<div id="modal" class="modal modal-fixed-footer">
					<div class="modal-content">
						<h4 id="modal_head">Создать тему</h4>
						<div class="row">
							<div class="input-field col s12">
								<input id="head" type="text">
								<label class="red-text text-accent-4" for="issue">Заголовок</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea id="text" class="materialize-textarea"></textarea>
								<label class="red-text text-accent-4" for="text">Сообщение</label>
							</div>
						</div>
						<div class="row">
							<a id="pollAdd" class="waves-effect waves-light red accent-4 white-text btn"><i class="material-icons left">add_circle_outline</i>Добавить опрос</a>
							<div id="poll" class="col s12 hide">
								<div id="poll_container" class="row">
									<h5>Опрос</h5>
									<div class="input-field col s12 m8">
										<input id="poll_item_0" type="text">
										<label class="red-text text-accent-4" for="poll_item_0">Новый пункт</label>
									</div>
								</div>
								<div class="row">
									<a id="newPollItem" class="btn btn-flat waves-effect waves-light "><i class="material-icons left">add</i>Добавить пункт</a>
								</div>
							</div>
						</div>
						<div class="row">
							<a id="filesAdd" class="waves-effect waves-light red accent-4 white-text btn"><i class="material-icons left">add_circle_outline</i>Добавить файлы</a>
							<form action="api/file_upload" class="dropzone hide" id="issueFiles"></form>
						</div>
					</div>
					<div class="modal-footer">
						<a id="modal_btn" class="modal-action modal-close waves-effect waves-green btn-flat ">Отправить</a>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a id="create" class="waves-effect waves-light red accent-4 btn-large"><i class="material-icons left">add_circle_outline</i>Создать тему</a>
						<script type="text/javascript" src="style/js/issue.js"></script>
					</div>
				</div>
				<? } ?>
				
				<?
				require_once '/engine/api/get_threads.php';
				
				$data = json_decode(get_threads());
				foreach( $data as $item ) {
					echo "<div class='col s12'>
							<h2 class='header'>" . $item->head . "</h2>
							<div class='card horizontal'>";
								if( count($item->attachments) > 0 ) {
								echo "<div class='card-image' style='background-image: url(" . $item->attachments[0] . ");'>
								</div>";
								}
								echo "<div class='card-stacked'>
									<div class='card-content'>
										<p>" . $item->text . "</p>
									</div>
									<div class='card-action'>
										<div class='col s4'>
											<a href='#'>Перейти</a>
										</div>
										<div class='col s8 right-align'>
											Создал " . $item->creator . " " . $item->date . "
										</div>
									</div>
								</div>
							</div>
						</div>";
				}
				
				?>
				
		  </div>
        </div>
  </div>
  
  <script type="text/javascript">
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
  </script>
