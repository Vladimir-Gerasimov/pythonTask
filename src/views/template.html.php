<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
	<title>ДУК "Мой дом" - <?=$page_name ?></title>
	<!-- CSS	-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&amp;subset=cyrillic" rel="stylesheet">
	<link href="style/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="style/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<?=$styles?>
</head>
<body>
	<nav class="white" role="navigation">
		<div class="nav-wrapper container">
			<?=$topbar_left ?>
			<?=$topbar_right ?>

			<ul id="nav-mobile" class="side-nav">
				<?php if( !Flight::getGlobal('user_logged') ) { ?>
				<li><a href="login"><i class="material-icons supervisor_account"></i>Войти</a></li>
				<?php } else { ?>
				<li><a href="lk"><i class="material-icons supervisor_account"></i><?php echo Flight::getGlobal('user_name') . " " . substr( Flight::getGlobal('user_surname'), 0, 1); ?></a></li>
				<?php } ?>
			</ul>
			<a href="#" data-activates="nav-mobile" class="button-collapse red-text text-accent-4"><i class="material-icons">menu</i></a>
		</div>
	</nav>
	
	<!--
	SLIDER SECTION
	-->
	<?=$slide ?>

	<?php if(!empty($promo_1) || !empty($promo_2) || !empty($promo_3) || !empty($promo_4)) { ?>
	<!--
	PROMO SECTION
	-->
	<div class="container">
		<div class="section">
			<div class="row">
				<?=$promo_1?>
				<?=$promo_2?>
				<?=$promo_3?>
				<?=$promo_4?>
			</div>
		</div>
	</div>
	<?php } ?>
	
	<!--
	CONTENT SECTION
	-->
	<div class="container">
		<div class="section">
			<div class="row">
				<?php if(!empty($sidebar_left)) { ?>
				<div class="col m3">
					<?=$sidebar_left?>
				</div>
				<?php } 
				$width = 12;
				!empty($sidebar_left) ? $width -= 3 : $width;
				!empty($sidebar_right) ? $width -= 3 : $width;
				?>
				<div class="col m<?=$width ?>">
					<?=$content?>
				</div>
				<?php if(!empty($sidebar_right)) { ?>
				<div class="col m3">
					<?=$sidebar_right?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<!--
	BASE SECTION
	-->
	<div class="container">
		<div class="section">
			<div class="row">
				<?=$base_1?>
				<?=$base_2?>
				<?=$base_3?>
				<?=$base_4?>
			</div>
		</div>
	</div>
	<footer class="page-footer red">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="white-text">О компании</h5>
          <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="red-text text-accent-4 text-lighten-3" href="#">Our studio</a>
      </div>
    </div>
  </footer>
</body>
</html>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="style/js/materialize.js"></script>
<script src="style/js/init.js"></script>
<?=$scripts?>
