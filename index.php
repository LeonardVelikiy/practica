<?php

include '../pages/db.php' ;
require 'pages/cookies.php';
require 'pages/rb.php';
R::setup( 'mysql:host=localhost;dbname=cn31570_practica','cn31570_practica', 'practica' );
$connect=mysqli_connect('localhost','cn31570_practica','practica','cn31570_practica'); 
$query = mysqli_query($connect, "SELECT COUNT(*) FROM `applications` WHERE `status`='Выполнено'");
	$count = mysqli_fetch_row($query)[0];

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
 

$online_count = R::count('online', "lastvisit > " . ( time() - (360) ))
if($run_str_add_application)
	{		
	header("Location: dark2");	
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Благоустройство города</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
<div id="dark2">
	<div id="okno2">
		<a href="#">
		<div class="close_btn1"></div>
	</a>
	<div class=text>Заявка отправлена</div>
	<form method="POST" >
	</form>
	</div>
	</div>
<div id="dark">
	<div id="okno">
		<a href=#>
		<div class="close_btn1"></div>
	</a>
		<form method="POST" enctype="multipart/form-data">
		<input type="file" name="рhoto_start" class="form_mitem1" id="form_mitem1"></input><br><br>
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
		<input type="submit" name="add" value="Сообщить">
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


		if($add){
			$file_get= $_FILES['рhoto_start']['name'];
			$temp= $_FILES['рhoto_start']['tmp_name'];
			$file_to_saved= "images/".time().$file_get;
			move_uploaded_file($temp, $file_to_saved);
			
			$str_add_application="INSERT INTO `applications` (`рhoto_start`, `title`, `city`, `district`, `street`, `house`, `description`, `category`, `status`, `date_start`) VALUES ('$file_to_saved', '$title', '$city', '$district', '$street', '$house', '$description', '$category', '$status', '$date_start')";
			
	if ($_FILES && $title && $city && $district && $street && $house && $category != $option) {
			$run_str_add_application=mysqli_query($connect, $str_add_application);
	if($run_str_add_application)
	{
		

}
	
	else
	{
		echo "Ошибка добавления";
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
			<div class="logo"></div>
			<a href="pages/admin.php">
				<span class="link_f">О сервисе</span>
			</a>
			<a href="pages/all_messages.php">
				<span class="link_s">Все сообщения</span>
			</a>	
			<a href="pages/auth_form.php">
				<div class="auth">Войти</div>
			</a>
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
		</div>
		<div class="tagline">
			<div></div>
			<div><a href="#dark">Сообщить о проблеме</a></div>
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
				<div><img src=$out[photo_end] width=260 height=260></div>
				<div>$out[title]</div>
				<div>$out[description]</div>
				<div>$out[category]</div>
				<div>".date('d/m/Y', $out['date_end'])."</div>
			</div>";
		}
		
		?>
		</div>
		<div class="pag_place">
			<?php
			$float_count=$int_out_application%8;
					$int_count=floor($int_out_application/8);
					$p=1;
					if ($float_count>0) 
					{
						$int_count++;
					}
					for ($i=0; $i <$int_count ; $i++) { 
						echo "<a class=pagination href=/?page_number=$i><div>$p</div></a>";
						$p++;
					}
				?>	
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>