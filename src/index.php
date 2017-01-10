<?php
require 'engine/kernel/flight/Flight.php';
Flight::init();

require 'engine/classes/User.php';
require 'engine/classes/File.php';
require 'engine/classes/FileFactory.php';
require 'engine/classes/IssueFactory.php';
require 'engine/classes/ThreadsFactory.php';
require 'engine/classes/Poll.php';
require 'engine/classes/Thread.php';
require 'engine/classes/Issue.php';
require 'engine/classes/Position.php';
require 'engine/classes/Page.php';
require 'engine/classes/Module.php';
require 'engine/classes/ModuleFactory.php';
require 'engine/classes/PageFactory.php';

require 'engine/DB.php';
require 'engine/API.php';
require 'engine/View.php';

require 'engine/Init.php';

Flight::start();