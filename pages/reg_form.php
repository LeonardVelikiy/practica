<!DOCTYPE html>
<html>
<head>
	<title>Форма</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../styles/form.css">
</head>
<body>
	<div class="form_window_reg">
		<a href="../index.php">
			<div></div>
		</a>
		<div class="form_mname">Регистрация</div>
		<div class="form_place">
			<form>
				<input type="text" name="" placeholder="ФИО" class="form_mitem"><br>
				<input type="text" name="" placeholder="Логин" class="form_mitem"><br>
				<input type="text" name="" placeholder="Email" class="form_mitem"><br>
				<input type="password" name="" placeholder="Пароль" class="form_mitem"><br>
				<input type="password" name="" placeholder="Повторите пароль" class="form_mitem"><br>
				<input type="checkbox" name=""><span class="pers_inf">Согласие на обработку<br>персональных данных</span><br>
				<input type="submit" name="" value="Регистрация" class="form_btn_reg">
			</form>
		</div>
		<div class="form_link"><a href="auth_form.php">Вернуться</a></div>
	</div>
</body>
</html>