<!DOCTYPE html>
<html>
<head>
	<title>Благоустройство города</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../styles/all_messages.css">
</head>
<body>
	<div class="wrapper">
		<div class="head">
			<div class="logo"></div>
			<a href="admin.php">
				<div class="link_f">О сервисе</div>
			</a>
			<a href="all_messages.php">
				<div class="link_s">Все сообщения</div>
			</a>
			<a href="auth_form.php">
				<div class="auth">Войти</div>
			</a>
		</div>
		<div class="mess_text">Все сообщения</div>
		<div class="all_messages_filter">
			<form>
			<input type="text" name="" class="text_sub" placeholder="Поиск">
			<select class="select">
				<option>Категория</option>
				<?php
				$connect=mysqli_connect('localhost','cn31570_practica','practica','cn31570_practica'); 
		$str_out_categoty="SELECT * FROM `category`";
		$run_out_categoty=mysqli_query($connect,$str_out_categoty);
		while ($out=mysqli_fetch_array($run_out_categoty)){
			echo "<option>$out[category]</option>";
		}
		?>
			</select>
			<input type="submit" name="" class="sub_btn" value="">
			</form>
		</div>
		<div class="mess_p_item">
			<?php
		$str_out_application="SELECT * FROM `applications` WHERE `status`='Выполнено' ORDER BY `date_end` DESC";
		$run_out_application=mysqli_query($connect,$str_out_application);
		$int_out_application=mysqli_num_rows($run_out_application);
		$page_number=$_GET['page_number'];
					if ($page_number == NULL)
						{
						$page_number=0;
					}
					$application_in_tape=12;
					$sql_page_number=$page_number*$application_in_tape;
					$str_out_application_pag="SELECT * FROM `applications` WHERE `status`='Новая' ORDER BY `date_end` DESC LIMIT $sql_page_number, $application_in_tape";
					$run_out_application_pag=mysqli_query($connect, $str_out_application_pag);
		while ($out=mysqli_fetch_array($run_out_application_pag)) {
			$id=$out['id'];
			echo "<div class=mess_item>
			<div><img src=$out[photo_start] width=260 height=260></div>
			<div>$out[title]</div>
			<div>$out[description]</div>
			<div>$out[category]</div>
			<div>".date('d/m/Y', $out['date_start'])."</div>
			<div>$out[city]/$out[district]/$out[street]/$out[house]</div>
			<a href=""><div>Выполнить</div></a>
			</div>";
		}
		
		?>
		</div>
		<div class="pag_place">
			<?php
			$float_count=$int_out_application%12;
					$int_count=floor($int_out_application/12);
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
