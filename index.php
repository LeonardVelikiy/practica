<?php
session_start();
include '../pages/db.php' ;
require 'pages/cookies.php';
require 'pages/rb.php';
R::setup( 'mysql:host=localhost;dbname=cn31570_practica','cn31570_practica', 'practica' );
$connect=mysqli_connect('localhost','cn31570_practica','practica','cn31570_practica'); 
$query = mysqli_query($connect, "SELECT COUNT(*) FROM `applications` WHERE `status`='Выполнено'");
	$count = mysqli_fetch_row($query)[0];
	$query_all = mysqli_query($connect, "SELECT COUNT(*) FROM `applications`");
	$count_all = mysqli_fetch_row($query_all)[0];

if ( !R::testconnection() )
{
        exit ('Нет соединения с базой данных');
}
 
$cookie_key = 'online-cache';
 

$ip = $_SERVER['REMOTE_ADDR']; 
 

$online = R::findOne('online', 'ip = ?', array($ip)); 
 
if ( $online )
{
    $do_update = false;
    if ( CookieManager::stored($cookie_key) )
        {
            $c = (array) @json_decode(CookieManager::read($cookie_key), true);
            if ( $c )
            {
                if( $c['lastvisit'] < (time() - (60 * 1)) ) 
                {
                    $do_update = true;
                }
            } else
            {
                $do_update = true;
            }
 
        } else{
                $do_update = true;      
        }
        if ( $do_update )
        {
                $time = time();
                $online->lastvisit = $time;
                R::store($online);
                CookieManager::store($cookie_key, json_encode(array(
                    'id' => $online->id,
                    'lastvisit' => $time)));
                 
        }
 
} else{
    $time = time();
    $online = R::dispense('online');
    $online->lastvisit = $time;
    $online->ip = $ip;
    R::store($online);
    CookieManager::store($cookie_key, json_encode(array(
        'id' => $online->id,
        'lastvisit' => $time)));
}
 

$online_count = R::count('online', "lastvisit > " . ( time() - (360) ));

?>
<!DOCTYPE html>
<html>
<head>
	<title>Благоустройство города</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
<div id=reg_dark>
<div class="form_window_reg">
		<a href="#">
			<div class="close_btn"></div>
		</a>
		<div class="form_mname">Регистрация</div>
		<div class="form_place">
			<form method="POST">
				<input type="text" name="first_last_name" placeholder="ФИО" class="form_mitem"><br>
				<input type="text" name="login" placeholder="Логин" class="form_mitem"><br>
				<input type="text" name="Email" placeholder="Email" class="form_mitem"><br>
				<input type="password" name="pass" placeholder="Пароль" class="form_mitem"><br>
				<input type="password" name="copy_pass" placeholder="Повторите пароль" class="form_mitem"><br>
				<input type="checkbox" name="cb"><span class="pers_inf">Согласие на обработку<br>персональных данных</span><br>
				<input type="submit" name="reg" value="Регистрация" class="form_btn_reg">
				<?php
				$first_last_name=$_POST['first_last_name'];
				$login=$_POST['login'];
				$Email=$_POST['Email'];
				$pass=$_POST['pass'];
				$copy_pass=$_POST['copy_pass'];
				$cb=$_POST['cb'];
				$reg=$_POST['reg'];
				if ($reg){
				$_SESSION['login']=$login;
				$_SESSION['pass']=$pass;
				}
				if($reg)
				{	
					if($copy_pass == $pass)
					{
							if($first_last_name and $login and $Email and $cb) 
							{
							$str_user_plus=mysqli_query($connect, "INSERT INTO `users` (`first_last_name`, `mail`, `pass`, `login`) VALUES ('$first_last_name','$Email','$_SESSION[pass]','$_SESSION[login]');");
							if ($str_user_plus){
							echo '<script>location.replace("../pages/profile.php");</script>'; exit;
							}
							else
							{
								echo "Ошибка регистрации";
							}
							}else
							{
								echo'<br>заполните все поля<br>';
							}
					}
					
				}
				?>
			</form>
		</div>
		<div class="form_link"><a href="#auth_dark">Войти</a></div>
	</div>
</div>
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
			$auth=$_POST['auth'];
			if ($auth) {
				$_SESSION['login']=$login;
				$_SESSION['pass']=$pass;
	}

			if($auth)
			{
				$str_auth="SELECT * FROM `users` WHERE `login` = '$_SESSION[login]' AND `pass` = '$_SESSION[pass]'";
				$run_auth=mysqli_query($connect,$str_auth);

				$check_users=mysqli_num_rows($run_auth);

				if ($check_users) 
					{
						$user= mysqli_fetch_assoc($run_auth);
						if ($user['role']==0) 
						{
							 echo '<script>location.replace("../pages/profile.php")</script>'; exit();
						}
						else
						{
							 echo '<script>location.replace("../pages/administration.php")</script>'; exit();
						}
									
					}
					else
					{
						session_destroy();
						exit();
					}

			}


			?>
			</form>
		</div>
		<div class="form_link"><a href="#reg_dark">Регистрация</a></div>
	</div>
</div>
<div id="lock">
	<div id="okno2">
		<a href="index.php#">
		<div class="close_btn1"></div>
	</a>
	<div class=text>Заявка отправлена</div>
	</div>
	</div>
<div id="dark">
	<div id="okno">
		<a href=#>
		<div class="close_btn1"></div>
	</a>
		<form method="POST" enctype="multipart/form-data">
		<input type="file" name="рhoto_start" class="form_mitem1" id="form_mitem1" accept=".jpg"></input><br><br>
		<input type="text" name="title" class="form_mitem2" placeholder="Название"><br><br>
		<input type="text" name="city" class="form_mitem2" placeholder="Город"><br><br>
		<input type="text" name="district" class="form_mitem2" placeholder="Район"><br><br>
		<input type="text" name="street" class="form_mitem2" placeholder="Улица"><br><br>
		<input type="text" name="house" class="form_mitem2" placeholder="Дом"><br><br>
		<textarea name="description"  class="form_mitem3" placeholder="Описание"></textarea><br><br>
		<select name="category" class="form_mitem4"><option name="option">Выберите категорию</option>
		<?php
		$str_out_categoty="SELECT * FROM `category`";
		$run_out_categoty=mysqli_query($connect,$str_out_categoty);
		while ($out=mysqli_fetch_array($run_out_categoty)){
			echo "<option>$out[category]</option>";
		}
		?></select><br><br>
		<input class="form_btn_call" type="submit" name="add" value="Сообщить">
		<?php 
				$ex=$_POST['ex'];
				$option=$_POST['option'];
				$title=$_POST['title'];
				$city=$_POST['city'];
				$district=$_POST['district'];
				$street=$_POST['street'];
				$house=$_POST['house'];
				$description=$_POST['description'];
				$category=$_POST['category'];
				$date_start=time();
				$status="Новая";
				$add=$_POST['add'];
				$file_get= $_FILES['рhoto_start']['name'];
			$temp= $_FILES['рhoto_start']['tmp_name'];
			$file_to_saved= "images/".time().$file_get;
				$imageFileType = 
strtolower(pathinfo($file_to_saved,PATHINFO_EXTENSION));

		if($add){

			$str_add_application="INSERT INTO `applications` (`user`, `рhoto_start`, `title`, `city`, `district`, `street`, `house`, `description`, `category`, `status`, `date_start`) VALUES ('$_SESSION[login]', '$file_to_saved', '$title', '$city', '$district', '$street', '$house', '$description', '$category', '$status', '$date_start')";
			
	if ($_FILES && $title && $city && $district && $street && $house && $category != $option) {
		if($imageFileType != "jpg" && $imageFileType != "jpeg") {
			echo "Только файлы jpg и jpeg";
		}
		else{
		
			move_uploaded_file($temp, $file_to_saved);
			$run_str_add_application=mysqli_query($connect, $str_add_application);
	if($run_str_add_application)
	{
		
		echo '<script>location.replace("/#lock");</script>'; exit();

}
	
	else
	{
		echo "Ошибка добавления";
	}
}
}
else
{
	echo "Заполните поля";
	
}
		}
		?></form></div></div>
	<div class="wrapper">
		<div class="head">
		<a href="../index.php">
				<span class="link_i">Главная</span>
			</a>
			<a href="/"><div class="logo"></div></a>
			<a href="pages/about.php">
				<span class="link_f">О сервисе</span>
			</a>
			<a href="pages/all_messages.php">
				<span class="link_s">Все сообщения</span>
			</a>
			<?php
			if ($_SESSION['login'] == NULL) {
				echo "<a href=index.php#auth_dark>
				<div class=auth>Войти</div>
			</a>";
			}
			else
			{
				
			if ($user['role']=0){
				echo "<a href=../pages/profile.php><div class=kab>Мой кабинет</div></a><form method=POST><input type=submit name=exit value=Выход class=exit></form>";
				}
				else
				{
					echo "<a href=../pages/administration.php><div class=kab>Мой кабинет</div></a><form method=POST><input type=submit name=exit value=Выход class=exit></form>";
				}
			}
			$exit=$_POST['exit'];
			if ($exit) {
				session_destroy();
				echo '<script>location.replace("/");</script>';
				exit();
			}
			?>
		</div>
		<div class="checker">
			<div>
				<div><?php echo "$online_count"?></div>
				<div>Заинтересованых<br>граждан</div>
			</div>
			<div>
				<div><?php echo "$count";?></div>
				<div>Решенных<br>проблем</div>
			</div>
			<div>
				<div><?php echo "$count_all";?></div>
				<div>Всего<br>проблем</div>
			</div>
		</div>
		<div class="tagline">
			<div></div>
			<div><a href="index.php#dark">Сообщить о проблеме</a></div>
		</div>
		<div class="solved_text">Последние решенные проблемы</div>
		<div class="solved_p_item">
		<?php
		$str_out_application="SELECT * FROM `applications` WHERE `status`='Выполнено' ORDER BY `date_end` DESC";
		$run_out_application=mysqli_query($connect,$str_out_application);
		$int_out_application=mysqli_num_rows($run_out_application);
		$page_number=$_GET['page_number'];
					if ($page_number == NULL)
						{
						$page_number=0;
					}
					$application_in_tape=8;
					$sql_page_number=$page_number*$application_in_tape;
					$str_out_application_pag="SELECT * FROM `applications` WHERE `status`='Выполнено' ORDER BY `date_end` DESC LIMIT $sql_page_number, $application_in_tape";
					$run_out_application_pag=mysqli_query($connect, $str_out_application_pag);
		while ($out=mysqli_fetch_array($run_out_application_pag)) {
			$id=$out['id'];
			echo "<div class=solved_item>
				<div><img src=../$out[photo_end] width=260 height=260></div>
				<div>$out[title]</div>
				<div>Ул.$out[street], Дом $out[house]</div>
				<div>$out[category]</div>
				<div>".date('d/m/Y', $out['date_end'])."</div>
			</div>";
		}
		
		?>
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>