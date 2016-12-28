<?php

Flight::route('/', 'index');
Flight::route('/login', 'login');
Flight::route('/lk', 'lk');
Flight::route('/tracker', 'tracker');
Flight::route('/community', 'community');
Flight::route('/community/@id', 'community_thread');

Flight::route('/api/@method', 'api');



function index() {
	Flight::render('home.php');
};

function login() {
	Flight::render('login.php');
};

function lk() {
	Flight::render('lk.php');
};

function tracker() {
	Flight::render('tracker.php');
};


function community() {
	Flight::render('community.php');
};

function community_thread($id) {
	Flight::render('thread.php', array('id' => $id));
};



function api( $method ) {
	$modFileName = "/api/". $method . ".php";
	$response = "";
	if( file_exists( dirname(__file__) . $modFileName ) ) {
		include_once( dirname(__file__) . $modFileName );
		if( is_callable( $method ) ) {
			$response = $method();
		}
	}
	echo "" . $response . "";
}

?>