<?php
/*
return codes:
	0 - success
	1 - mail exists
	2 - insert error
*/
function auth() {
	if( isset( $_POST['mail'] ) && isset( $_POST['pwd'] ) ) {
		$db = Flight::db();
		$res = $db->query('select * from user where mail="' . $_POST['mail'] . '"', PDO::FETCH_ASSOC);
		$res = $res->fetchAll();
		if( count($res) == 0 ) {
			return 1;
		} else {
			if( hash('md5', $_POST['pwd']) == $res[0]['pwd'] ) {
				Flight::setGlobal('user_logged', true);
				Flight::setGlobal('user_name', $res[0]['name']);
				Flight::setGlobal('user_surname', $res[0]['surname']);
				Flight::setGlobal('user_id', $res[0]['id']);
				return 0;
			} else {
				return 2;
			}
		}
	} else {
		return 2;
	}
}
?>