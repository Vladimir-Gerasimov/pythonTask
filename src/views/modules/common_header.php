<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
	<title>ДУК "Мой дом"</title>

	<!-- CSS	-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&amp;subset=cyrillic" rel="stylesheet">
	<link href="/style/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="/style/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	<script src="/style/js/materialize.js"></script>
	<script src="/style/js/init.js"></script>
</head>
<body>
	<nav class="white" role="navigation">
		<div class="nav-wrapper container">
			<a id="logo-container" href="/" class="brand-logo red-text text-accent-4"><img src="/style/image/logo_big.png" width="30" class="valign"> ДУК "Мой Дом"</a>
			<ul class="right hide-on-med-and-down">
				<? if( !Flight::getGlobal('user_logged') ) { ?>
				<li><a href="/login" class="red-text text-accent-4"><i class="material-icons left">supervisor_account</i>Войти</a></li>
				<? } else { ?>
				<li><a href="/lk" class="red-text text-accent-4"><i class="material-icons left">supervisor_account</i><? echo Flight::getGlobal('user_name') . " " . mb_substr( Flight::getGlobal('user_surname'), 0, 1, "UTF-8") . "."; ?></a></li>
				<? } ?>
			</ul>

			<ul id="nav-mobile" class="side-nav">
				<? if( !Flight::getGlobal('user_logged') ) { ?>
				<li><a href="/login"><i class="material-icons supervisor_account"></i>Войти</a></li>
				<? } else { ?>
				<li><a href="/lk"><i class="material-icons supervisor_account"></i><? echo Flight::getGlobal('user_name') . " " . substr( Flight::getGlobal('user_surname'), 0, 1); ?></a></li>
				<? } ?>
			</ul>
			<a href="#" data-activates="nav-mobile" class="button-collapse red-text text-accent-4"><i class="material-icons">menu</i></a>
		</div>
	</nav>
