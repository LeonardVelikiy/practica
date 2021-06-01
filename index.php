<?php

$connect=mysqli_connect('localhost','cn31570_practica','practica','cn31570_practica');
require 'pages/cookies.php';
require 'pages/rb.php';
R::setup( 'mysql:host=localhost;dbname=cn31570_practica','cn31570_practica', 'practica' );

$query = mysqli_query($connect, "SELECT * FROM `applications` WHERE `status`='Выполнено'");
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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Благоустройство города</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
	<div class="wrapper">
		<div class="head">
			<div class="logo">ЛОГО</div>
			<a href="pages/admin.php">
				<span class="link_f">О сервисе</span>
			</a>
			<a href="pages/profile.php">
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
				<div><?php $count?></div>
				<div>Решенных<br>проблем</div>
			</div>
		</div>
		<div class="tagline">
			<div></div>
			<div>Сообщить о проблеме</div>
		</div>
		<div class="solved_text">Последние решенные проблемы</div>
		<div class="solved_p_item">
		<?php
		$str_out_application="SELECT * FROM `applications` WHERE `status`='Выполнено' ORDER BY `date_end` DESC";
		$run_out_application=mysqli_query($connect,$str_out_application);
		while ($out=mysqli_fetch_array($run_out_application)) {
			$id=$out['id'];
			echo "<div class=solved_item>
				<div>Фото</div>
				<div>$out[title]</div>
				<div>$out[description]</div>
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