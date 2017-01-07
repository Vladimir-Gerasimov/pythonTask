<h2><?=$page_name?></h2>
<? if(Flight::getGlobal('user_logged')){ ?>
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
			<form action="api/FileUpload" class="dropzone hide" id="issueFiles"></form>
		</div>
	</div>
	<div class="modal-footer">
		<a id="modal_btn" class="modal-action modal-close waves-effect waves-green btn-flat ">Отправить</a>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<a id="create" class="waves-effect waves-light red accent-4 btn-large"><i class="material-icons left">add_circle_outline</i>Создать тему</a>
	</div>
</div>
<?php } 

$threads = API::GetThreads();
$data = json_decode($threads);
if($data->code == 0) {
	foreach($data->data as $item) {
		echo "<div class='col s12'>
				<h4 class='header'>" . $item->head . "</h4>
				<div class='card horizontal'>";
					if(count($item->files) > 0 ) {
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