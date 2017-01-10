<h2><?=$page_name?></h2>
<?php if(Flight::getGlobal('user_logged')){ ?>
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
			<form action="api/FileUpload" class="dropzone hide" id="issueFiles"></form>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#" id="modal_btn" class="modal-action modal-close waves-effect waves-green btn-flat ">Отправить</a>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<a id="create" class="waves-effect waves-light red accent-4 btn-large"><i class="material-icons left">add_circle_outline</i>Сообщить о проблеме </a>
	</div>
</div>
<?php } ?>
<?php
$issues = API::GetIssues();
$data = json_decode($issues);
if($data->code == 0) {
	foreach($data->data as $item ) {
		echo "<div class='col s12'>
				<h4 class='header'>" . $item->head . "</h4>
				<div class='card horizontal'>";
					if( count($item->files) > 0 ) {
					echo "<div class='card-image' style='background-image: url(data/" . $item->files[0]->type . "/" . $item->files[0]->name .");'>
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
								Создал <a href=\"users/" . $item->creator . "\">" . DB::getUserById($item->creator)->getUsernameShorten() . "</a> " . $item->date . "
							</div>
						</div>
					</div>
				</div>
			</div>";
	}
}

?>