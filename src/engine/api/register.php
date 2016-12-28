<?php
/*
return codes:
	0 - success
	1 - mail exists
	2 - insert error
*/
function register() {
	if( isset( $_POST['name'] ) && isset( $_POST['surname'] ) && isset( $_POST['mail'] ) && isset( $_POST['pwd'] ) ) {
		$db = Flight::db();
		$res = $db->query('select count(id) from user where mail="' . $_POST['mail'] . '"');
		$res = $res->fetchAll();
		if( $res[0][0] != 0 ) {
			return 1;
		} else {
			try {
				$db->exec('insert into user (`name`,`surname`,`mail`,`pwd`) values ("' . $_POST['name'] . '", "' . $_POST['surname'] . '", "' . $_POST['mail'] . '", "' . hash('md5', $_POST['pwd']) . '")');
				return 0;
			} catch(PDOException $e) {
				return 2;
			}
		}
	}
}
?>