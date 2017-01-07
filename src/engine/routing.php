<?php

//Flight::route('/api/@method', function($method){ Flight::api($method); });
//Flight::route('/*', function($route) { var_dump($route); }, true);
//Flight::route('/login', 'login');
//Flight::route('/lk', 'lk');
//Flight::route('/tracker', 'tracker');
//Flight::route('/community', 'community');
//Flight::route('/community/@id', 'community_thread');




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

