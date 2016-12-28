<?php
/// 0 - success
/// 1 - error
/// 2 - file not found
/// 3 - no param
function remove_file() {
	$ds = DIRECTORY_SEPARATOR;
	if (isset($_POST['file'])) {
		$db = Flight::db();
		$res = $db->query('select type from `user_data` where `name`="' . $_POST['file'] . '"');
		$type = $res->fetchAll()[0][0];
		$storeFolder = '..' . $ds . '..' . $ds . 'data' . $ds . $type;
		$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds . $_POST['file'];
		if(file_exists($targetPath)){
			unlink($targetPath);
			if(file_exists($targetPath)) {
				return 1;
			}
			
			$db->exec('delete from `user_data` where `user_id`=' . Flight::getGlobal('user_id') . ' and `name`="' . $_POST['file'] . '"');
			return 0;
		} else {
			return 2;
		}
	} else {
		return 3;
	}
}


?>     