<?php
function create_issue() {
	if (isset($_POST['head']) && isset($_POST['text']) && isset($_POST['attachments'])) {
		$db = Flight::db();
		$files = join('","', explode(',', $_POST['attachments']));
		$res = $db->query('select id from `user_data` where `name` in ("' . $files . '")');
		$res = $res->fetchAll();
		$files = array();
		for( $i = 0; $i < count($res); $i++){
			array_push($files, $res[$i][0]);
		}
		$files = join(',', $files);
		$db->exec('insert into `issues` (`head`, `text`, `attachments`, `creator`) values ("' . $_POST['head'] . '", "' . $_POST['text'] . '", "' . $files . '", ' . Flight::getGlobal('user_id') . ')');
		return 0;
	} else {
		return 1;
	}
}


?>     