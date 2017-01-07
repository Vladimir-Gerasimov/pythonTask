<ul class="right hide-on-med-and-down">
	<?php if( !Flight::getGlobal('user_logged') ) { ?>
	<li><a href="login" class="red-text text-accent-4"><i class="material-icons left">supervisor_account</i>Войти</a></li>
	<?php } else { ?>
	<li><a href="lk" class="red-text text-accent-4"><i class="material-icons left">supervisor_account</i><?php echo Flight::getGlobal('user_name') . " " . mb_substr( Flight::getGlobal('user_surname'), 0, 1, "UTF-8") . "."; ?></a></li>
	<?php } ?>
</ul>
