<?php
Flight::set('flight.flight.handle_errors', false);
Flight::set('flight.log_errors', true);
Flight::set('flight.base_url', '/src/caretakers/src/');
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=duk_trunk','root',''));

Flight::map('api', function($method) {
	header('Content-type: text/json; charset=UTF-8');
	$response = json_encode(array());
	if(method_exists(API, $method)){
		$response = API::$method();
	}
	echo $response;
});

Flight::route('/api/@method', array('Flight', 'api'));

// TODO: the following needs to be redesigned
$Pages = DB::getPages();
if($Pages === 1) {
	Flight::error(new Exception("There was an error during pages extraction"));
} else if($Pages === 2) {
	Flight::error(new Exception("No pages found"));
} else {
	foreach($Pages as $Page) {
		$route = explode('/', $Page->getRoute());
		$route = array_merge($route, explode('/', $Page->getParams()));
		$pageId = $Page->getId();
		$pageName = $Page->getName();
		$View = new View($pageId, $pageName);
		// Replacing possible groups of "///..." to one single "/" with preg_replace
		Flight::route(preg_replace('/\/+/', '/', join('/', $route)), array($View, 'createView'));
	}
}