<?php

function get_threads() {
	$db = Flight::db();
	
	$items = array();
	
	$res = $db->query('SELECT * FROM `forum` ORDER BY  `date` DESC ');
	$results = $res->fetchAll();
	foreach($results as $r){
		$item = array();
		$item['head'] = htmlspecialchars($r['head']);
		$item['text'] = htmlspecialchars($r['text']);
		$item['date'] = htmlspecialchars($r['date']);
		$item['poll'] = array();
		htmlspecialchars($r['poll']);
		$x = $db->query('select `name`,`surname` from `user` where `id`=' . $r['creator']);
		$x = $x->fetchAll();
		$item['creator'] = $x[0]['name'] . " " . mb_substr( $x[0]['surname'], 0, 1, "UTF-8") . ".";
		$x = $db->query("select `type`,`name` from `user_data` where `id` in ('" . $r['attachments'] . "')");
		$x = $x->fetchAll();
		$item['attachments'] = array();
		for( $i = 0; $i < count($x); $i++){
			array_push($item['attachments'], '/data/' . $x[$i]['type'] . '/' . $x[$i]['name']);
		}
		array_push($items, $item);
	}
	return json_encode($items, JSON_UNESCAPED_UNICODE);
}


?>     