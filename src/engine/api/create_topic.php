<?php
function create_topic() {
	if (isset($_POST['head']) && isset($_POST['text']) && isset($_POST['poll']) && isset($_POST['attachments'])) {
		$db = Flight::db();
		
		$files = join('","', explode(',', $_POST['attachments']));
		$res = $db->query('select id from `user_data` where `name` in ("' . $files . '")');
		$res = $res->fetchAll();
		$files = array();
		for( $i = 0; $i < count($res); $i++){
			array_push($files, $res[$i][0]);
		}
		$files = join(',', $files);
		
		$db->exec('insert into `forum` (`head`, `text`, `poll`, `attachments`, `creator`) values ("' . $_POST['head'] . '", "' . $_POST['text'] . '", ' . $_POST['poll'] . ', "' . $files . '", ' . Flight::getGlobal('user_id') . ')');
		$res = $db->query('select max(id) from `forum`');
		$res = $res->fetchAll();
		return 'id:' . $res[0][0];
	} else {
		return 'error:no items recieved';
	}
}


?>     