
	<div class="container">
		<div class="section">

			<!--	 Icon Section	 -->
			<div class="row">
				<div class="col s12 m6 offset-m3">
					<div class="icon-block">
						<h2 class="center red-text text-accent-4"><i class="material-icons">perm_identity</i></h2>
						<h5 class="center">Войти в личный кабинет</h5>
						<div class="row ">
							<div class="col s12">
								<ul class="tabs tabs-fixed-width">
									<li class="tab col s3"><a class="active red-text text-accent-4" href="#login_form">Вход</a></li>
									<li class="tab col s3"><a class="red-text text-accent-4" href="#reg_form">Регистрация</a></li>
								</ul>
							</div>
							<div id="login_form" class="col s12">
								<div class="row valign-wrapper">
									<div class="input-field col s11">
										<input id="email" type="email" class="with_icon">
										<label for="email" class="red-text text-accent-4">Email</label>
									</div>
									<div class="col s1 flow-text">
										<i id="email_ok" class="material-icons right green-text hide">done</i>
										<i id="email_fail" class="material-icons right red-text hide">error</i>
									</div>
								</div>
								<div class="row valign-wrapper">
									<div class="input-field col s11">
										<input id="password" type="password" class="with_icon">
										<label for="password" class="red-text text-accent-4">Пароль</label>
									</div>
									<div class="col s1 flow-text">
										<i id="password_ok" class="material-icons right green-text hide">done</i>
										<i id="password_fail" class="material-icons right red-text hide">error</i>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12 center-align">
										<a href="/pwd_recovery" class="red-text text-accent-4">Забыли пароль?</a>
									</div>
								</div>
								<div class="row">
									<div class="col s12 m12 center-align">
										<a class="waves-effect waves-light btn-large red accent-4" id="login"><i class="material-icons left">input</i>Войти</a>
									</div>
								</div>
							</div>
							<div id="reg_form" class="col s12">
								<div class="row valign-wrapper">
									<div class="input-field col s11">
										<input placeholder="Имя" id="name" type="text" class="with_icon">
										<label for="name" class="red-text text-accent-4">Имя</label>
									</div>
									<div class="col s1 flow-text">
										<i id="name_ok" class="material-icons right green-text hide">done</i>
										<i id="name_fail" class="material-icons right red-text hide">error</i>
									</div>
								</div>
								<div class="row valign-wrapper">
									<div class="input-field col s11">
										<input placeholder="Фамилия" id="surname" type="text" class="with_icon">
										<label for="surname" class="red-text text-accent-4">Фамилия</label>
									</div>
									<div class="col s1 flow-text">
										<i id="surname_ok" class="material-icons right green-text hide">done</i>
										<i id="surname_fail" class="material-icons right red-text hide">error</i>
									</div>
								</div>
								<div class="row valign-wrapper">
									<div class="input-field col s11">
										<input id="email_reg" type="email" class="with_icon">
										<label for="email_reg" class="red-text text-accent-4">Email</label>
									</div>
									<div class="col s1 flow-text">
										<i id="email_reg_ok" class="material-icons right green-text hide">done</i>
										<i id="email_reg_fail" class="material-icons right red-text hide">error</i>
									</div>
								</div>
								<div class="row valign-wrapper">
									<div class="input-field col s11">
										<input id="password_reg" type="password" class="with_icon tooltipped" data-tooltip="<div class='left-align'>Не короче 8 символов<br>Должен содержать только латинские буквы<br>Должен содержать цифры</div>" data-position="right" data-html="true">
										<label for="password_reg" class="red-text text-accent-4">Пароль</label>
									</div>
									<div class="col s1 flow-text">
										<i id="password_reg_ok" class="material-icons right green-text hide">done</i>
										<i id="password_reg_fail" class="material-icons right red-text hide">error</i>
									</div>
								</div>
								<div class="row valign-wrapper">
									<div class="input-field col s11">
										<input id="password_reg_conf" type="password" class="with_icon">
										<label for="password_reg_conf" class="red-text text-accent-4">Пароль еще раз</label>
									</div>
									<div class="col s1 flow-text">
										<i id="password_reg_conf_ok" class="material-icons right green-text hide">done</i>
										<i id="password_reg_conf_fail" class="material-icons right red-text hide">error</i>
									</div>
								</div>
								<div class="row">
									<div class="col s12 m12 center-align">
										<a class="waves-effect waves-light btn-large red accent-4" id="reg"><i class="material-icons left">offline_pin</i>Зарегистрироваться</a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="progress hide">
								<div class="indeterminate"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h4 id="modal_head"></h4>
			<p id="modal_text"></p>
		</div>
		<div class="modal-footer">
			<a href="#" id="modal_btn" class="modal-action modal-close waves-effect waves-green btn-flat ">ОК</a>
		</div>
	</div>
<script>
	$(document).ready(function(){
		$('ul.tabs').tabs();
		$('.modal').modal();
	});
</script>
<script type="text/javascript" src="/style/js/auth.js"></script>
