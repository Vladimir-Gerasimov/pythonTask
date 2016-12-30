	<div class="container">
		<div class="row">
			<?php echo $sidebar; ?>
			<div class="col m9 s12">
				<?php echo $header; ?>
				<?php if(Flight::getGlobal('user_logged')){ ?>
				<script src="style/js/dropzone.js"></script>
				<script type="text/javascript">
				Dropzone.options.issueFiles = {
					maxFilesize: 2,
					acceptedFiles: "image/*,video/*",
					renameFilename: function(name){
						add = "<?php echo Flight::getGlobal('user_id');?>";
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
						<h4 id="modal_head">Сообщить о проблеме</h4>
						<div class="row">
							<div class="input-field col s12">
								<input id="issue" type="text">
								<label class="red-text text-accent-4" for="issue">Кратко опишите проблему</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea id="text" class="materialize-textarea"></textarea>
								<label class="red-text text-accent-4" for="text">Расскажите подробности</label>
							</div>
						</div>
						<div class="row">
							<a id="filesAdd" class="waves-effect waves-light red accent-4 white-text btn"><i class="material-icons left">add_circle_outline</i>Добавить файлы</a>
							<form action="api/file_upload" class="dropzone hide" id="issueFiles"></form>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" id="modal_btn" class="modal-action modal-close waves-effect waves-green btn-flat ">Отправить</a>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a id="create" class="waves-effect waves-light red accent-4 btn-large"><i class="material-icons left">add_circle_outline</i>Сообщить о проблеме </a>
						<script type="text/javascript" src="style/js/issue.js"></script>
					</div>
				</div>
				<?php } ?>
				<?php
				require_once '/engine/api/get_issues.php';
				
				$data = json_decode(get_issues());
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
		$("#filesAdd").on('click', function(){
			$("#issueFiles").toggleClass('hide');
			$(this).toggleClass('hide');
		});
	
		$("#modal_btn").on('click', function() {
			head = $("#issue").val();
			text = $("#text").val();
			files = Object.keys(_FILENAMES_).join(',');
			$.post('api/create_issue/', {head:head, text: text, attachments: files}, function(d){
			if(d.trim() == 0){
					$("#issue").val('');
					$("#text").val('');
					Dropzone.instances[0].removeAllFiles();
					setTimeout(function(){
						window.location.relooad();
					}, 2000);
				}
			});
		});
	</script>