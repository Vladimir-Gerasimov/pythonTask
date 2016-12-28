<?php
function file_upload() {
	$ds = DIRECTORY_SEPARATOR;
	$storeFolder = '..' . $ds . '..' . $ds . 'data' . $ds;
	if (!empty($_FILES)) {
		for( $i = 0; $i < count($_FILES['file']['tmp_name']); $i++) {
			
			$type = explode('/', $_FILES['file']['type'][$i])[0];
			
			$tempFile = $_FILES['file']['tmp_name'][$i];
			$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $type . $ds;
			$targetFile = $targetPath . $_FILES['file']['name'][$i];
			move_uploaded_file($tempFile,$targetFile);
						
			$db = Flight::db();
			$db->exec('insert into `user_data` (`user_id`, `type`, `name`) values (' . Flight::getGlobal('user_id') . ', "' . $type . '", "' . $_FILES['file']['name'][$i] . '")');
		}
		return 0;
	} else {
		return 1;
	}
}
?>     