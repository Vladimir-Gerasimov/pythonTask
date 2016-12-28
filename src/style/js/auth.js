(function($){
  $(function(){
	reg_name = 0;
	reg_surname = 0;
	reg_mail = 0;
	reg_pwd = 0;
	reg_pwd_conf = 0;
	
	login_mail = 0;
	login_pwd = 0;
	
	$("input").on('blur', function(){
		val = $(this).val();
		id = $(this).attr('id');
		type = $(this).attr('type');
		if(type == 'text'){
			if(val.match(/^[а-я]+$|^[a-z]+$/i)){
				val = val.toLowerCase();
				x = val.charAt(0).toUpperCase();
				val = x.concat( val.slice(1) );
				$(this).val(val);
				
				$(this).removeClass('invalid');
				$(this).addClass('valid');
				$("#" + id + "_ok").removeClass('hide');
				$("#" + id + "_fail").addClass('hide');
				if(id == 'name') {reg_name = 1;}
				if(id == 'surname') {reg_surname = 1;}				
			} else {
				$(this).removeClass('valid');
				$(this).addClass('invalid');
				$("#" + id + "_ok").addClass('hide');
				$("#" + id + "_fail").removeClass('hide');
				if(id == 'name') {reg_name = 0;}
				if(id == 'surname') {reg_surname = 0;}
			}
		}
		if(type == 'email'){
			if(val.match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){				
				$(this).removeClass('invalid');
				$(this).addClass('valid');
				$("#" + id + "_ok").removeClass('hide');
				$("#" + id + "_fail").addClass('hide');
				if(id == 'email_reg') {reg_mail = 1;}
				if(id == 'email') {login_mail = 1;}
			} else {
				$(this).removeClass('valid');
				$(this).addClass('invalid');
				$("#" + id + "_ok").addClass('hide');
				$("#" + id + "_fail").removeClass('hide');
				if(id == 'email_reg') {reg_mail = 0;}
				if(id == 'email') {login_mail = 0;}
			}
		}
		if(type == 'password' && !id.match(/_conf$/)){
			nums = 0;
			letters = 0;
			length = 0;
			if(val.length >= 8) { length = 1; }
			if(val.match(/[0-9]+/)) { nums = 1; }
			if(val.match(/[a-z]+/i)) { letters = 1; }
			if(val.match(/[^a-z0-9]/i)) { letters = 0; }
			
			if(length && nums && letters){				
				$(this).removeClass('invalid');
				$(this).addClass('valid');
				$("#" + id + "_ok").removeClass('hide');
				$("#" + id + "_fail").addClass('hide');
				if(id == 'password_reg') {reg_pwd = 1;}
				if(id == 'password') {login_pwd = 1;}
			} else {
				$(this).removeClass('valid');
				$(this).addClass('invalid');
				$("#" + id + "_ok").addClass('hide');
				$("#" + id + "_fail").removeClass('hide');
				if(id == 'password_reg') {reg_pwd = 0;}
				if(id == 'password') {login_pwd = 0;}
			}
		}
		if(type == 'password' && id.match(/_conf$/)){
			pwd = $("#password_reg").val()
			if(val == pwd){				
				$(this).removeClass('invalid');
				$(this).addClass('valid');
				$("#" + id + "_ok").removeClass('hide');
				$("#" + id + "_fail").addClass('hide');
				reg_pwd_conf = 1;
			} else {
				$(this).removeClass('valid');
				$(this).addClass('invalid');
				$("#" + id + "_ok").addClass('hide');
				$("#" + id + "_fail").removeClass('hide');
				reg_pwd_conf = 0;
			}
		}
	});
	
    $("#reg").on('click', function(){
		if(reg_name && reg_surname && reg_mail && reg_pwd && reg_pwd_conf) {
			name = $("#name").val();
			surname = $("#surname").val();
			mail = $("#email_reg").val();
			pwd = $("#password_reg").val();
			$.post('/api/register/', {name: name, surname: surname, mail: mail, pwd: pwd}, function(data){
				if( data != 0 && data != 1 ) {
					$("#modal_head").text("Внимание!");
					$("#modal_text").text("Произошла ошибка при регистрации. Пожалуйста, попробуйте позже.");
					$("#modal_btn").addClass('red accent-4');
				} else if( data == 1 ) {
					$("#modal_head").text("Внимание!");
					$("#modal_text").text("Введенный e-mail уже зарегистрирован. Попробуйде другой или пройдите авторизацию.");
					$("#modal_btn").addClass('red accent-4');
				} else if( data == 0 ) {
					$("#modal_head").text("Поздравляем!");
					$("#modal_text").text("Регистрация успешно завершена, сейчас вы будете перенаправлены в личный кабинет.");
					$("#modal_btn").addClass('green');
				}
				$('#modal').modal('open');
				setTimeout(function(){
					if(data == 0){
						$.post('/api/auth/', {mail:mail, pwd: pwd}, function(d){
							if(d == 0) {
								window.location.href = "/lk";
							} else if(d == 1){
								$('#modal').modal('close');
								$("#modal_head").text("Внимание!");
								$("#modal_text").text("Email не зарегистрирован");
								$("#modal_btn").addClass('red accent-4');
								$('#modal').modal('open');
							} else {
								$('#modal').modal('close');
								$("#modal_head").text("Внимание!");
								$("#modal_text").text("Произошла ошибка при авторизации. Пожалуйста, попробуйте позже.");
								$("#modal_btn").addClass('red accent-4');
								$('#modal').modal('open');
							}
						});
					}
				}, 1000);
			});
		} else {
			$("i.material-icons.red-text").effect('shake');
		}
		
	});
	
	$("#login").on('click', function(){
		if( login_mail && login_pwd ) {
			mail = $("#email").val();
			pwd = $("#password").val();
			$.post('/api/auth/', {mail:mail, pwd: pwd}, function(d){
				if(d == 0) {
					window.location.href = "/lk";
				} else if(d == 1){
					$('#modal').modal('close');
					$("#modal_head").text("Внимание!");
					$("#modal_text").text("Email не зарегистрирован");
					$("#modal_btn").addClass('red accent-4');
					$('#modal').modal('open');
				} else {
					$('#modal').modal('close');
					$("#modal_head").text("Внимание!");
					$("#modal_text").text("Произошла ошибка при авторизации. Пожалуйста, попробуйте позже.");
					$("#modal_btn").addClass('red accent-4');
					$('#modal').modal('open');
				}
			});
		} else {
			$("i.material-icons.red-text").effect('shake');
		}
	});
	
  });
})(jQuery);