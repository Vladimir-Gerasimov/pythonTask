<?php
Flight::set('flight.flight.handle_errors', false);
Flight::set('flight.log_errors', true);
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=duk_trunk','root',''));