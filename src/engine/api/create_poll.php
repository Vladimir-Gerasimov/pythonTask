<?php
function create_poll() {
	if (isset($_POST['items'])) {
		$items = $_POST['items'];
	
		$db = Flight::db();
		$db->exec('insert into `polls` (`items`, `creator`) values ("' . $items . '", ' . Flight::getGlobal('user_id') . ')');
		
		$res = $db->query('select max(id) from `polls`');
		$res = $res->fetchAll();
		return 'id:' . $res[0][0];
	} else {
		return 'error:no items recieved';
	}
}


?>     