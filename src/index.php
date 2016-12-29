<?php
require 'engine/kernel/flight/Flight.php';
Flight::init();

require 'engine/config.php';
require 'engine/init.php';
require 'engine/routing.php';

Flight::start();
?>
