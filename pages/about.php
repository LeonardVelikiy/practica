<!DOCTYPE html>
<html>
<head>
	<title>Благоустройство города</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../styles/about.css">
</head>
<body>
<div id=auth_dark>
<div class="form_window_auth">
		<a href="#">
			<div class="close_btn"></div>
		</a>
		<div class="form_mname">Вход</div>
		<div class="form_place">
			<form method="POST">
				<input type="text" name="login" placeholder="Логин" class="form_mitem"><br>
				<input type="text" name="pass" placeholder="Пароль" class="form_mitem"><br>
				<input type="submit" name="auth" value="Вход" class="form_btn">
			
			<?php
			$login=$_POST['login'];
			$pass=$_POST['pass'];
			$add=$_POST['auth'];
			if ($add) {
				$_SESSION['login']=$login;
				$_SESSION['pass']=$pass;
				$_SESSION['auth']=$add;
			}
			if($add)
			{
				$str_auth="SELECT * FROM `users` WHERE `login` = '$_SESSION[login]' AND `pass` = '$_SESSION[pass]'";
				$run_auth=mysqli_query($connect,$str_auth);
				$check_users=mysqli_num_rows($run_auth);

				if ($check_users) 
					{
						$user= mysqli_fetch_assoc($run_auth);
						if ($user['role']==0) 
						{
							 echo '<script>location.replace("../pages/profile.php");</script>'; exit;
						}else
						{
							 echo '<script>location.replace("../pages/administration.php");</script>'; exit;
						}
									
					}else
					{
						echo '<script>location.replace("/");</script>'; exit;
					
						unset($_SESSION);
					}

			}


			?>
			</form>
		</div>
		<div class="form_link"><a href="#reg_dark">Регистрация</a></div>
	</div>
</div>
	<div class="wrapper">
		<div class="head">
		<a href="../index.php">
				<span class="link_i">Главная</span>
			</a>
			<div class="logo"></div>
			<a href="about.php">
				<span class="link_f">О сервисе</span>
			</a>
			<a href="all_messages.php">
				<span class="link_s">Все сообщения</span>
			</a>
			
			<?php
			if ($_SESSION['login'] == NULL) {
			echo "<a href=#auth_dark>
				<div class=auth>Войти</div>
			</a>";
			}
			else
			{
				echo "<a href=../pages/profile.php><div class=kab>Мой кабинет</div></a><form method=POST><input type=submit name=exit value=Выход class=exit></form>";
			}
			$exit=$_POST['exit'];
			if ($exit) {
				session_destroy();
				echo '<script>location.replace("index.php");</script>';
				exit();
			}
			?>
		</div>
		<div class="about_text">О сервисе</div>
		<div class="about_text_place">
			Сервис создан для оперативного решения проблем, которые касаются улучшения качества жизни в городе, развития инфраструктуры, транспорта, благоустройства.
			<br><br>
			Сервис позволяет создать электронное сообщение, которое будет доставлено в органы власти, отвечающие за решение проблемы гражданина. К тексту сообщения можно приложить фото-/видеоматериалы, указать точный адрес возникшей проблемы на карте.
			<br><br>
			Важно! При подаче сообщения необходимо выбрать категорию, к которой относится описываемая проблема. Если ваше сообщение не попадает под предлагаемые категории, необходимо обратиться в Интернет-приемную.
			<br><br>
			Список актуальных на сегодня категорий представлен здесь. По мере развития сервиса список будет пополняться.
			<br><br>
			После получения ответа от представителей власти, заявитель может оценить качество выполненной работы по пятибалльной шкале.
			<br><br>
			Для работы с сервисом пользователям необходимо авторизоваться в ней с помощью подтвержденной учетной записи на Госуслугах (ЕСИА).
			<br><br>
			Если у Вас нет регистрации на Госуслугах (ЕСИА) или Ваша учетная запись не подтверждена, требуется зарегистрироваться (подтвердить учетную запись) в любом Центре обслуживания пользователей.
			<br><br>
			Представленная при регистрации информация хранится и обрабатывается с соблюдением требований российского законодательства о защите персональных данных. Общий размер одного сообщения (комментария) не может превышать две тысячи знаков. Сообщения (комментарии) проходят премодерацию. Сообщение (комментарий) не будут опубликованы, если они:
			<br><br>
			<ul class="list">
				<li>нарушают законодательство РФ;</li>
				<li>содержат жалобы, просьбы личного характера, сообщения и прошения, связанные с персональными жизненными ситуациями, требующие обязательного ответа (такие обращения необходимо направлять в Интернет-приемную Администрации 	Ижевска).</li>
			</ul>
			<br>
			Сообщение может быть отредактировано модератором без нарушения общего смысла и логики комментария, в нём могут быть исправлены явные опечатки. Регистрация пользователей, систематически нарушающих правила раздела, может быть аннулирована. Не публикуются сообщения, содержащие ссылки на сторонние сайты, ненормативную лексику и/или грубые выражения (в том числе в замаскированной форме) и т.п.
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>