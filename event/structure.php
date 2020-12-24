<?php
ini_set('max_execution_time', 1800);
if ($_POST['key'] != '*key*') exit('Error');

$CONNECT = mysqli_connect('localhost', 'vertex', 'pass', 'vertex');

if ( !$CONNECT ) exit('MySQL error');

mysqli_set_charset($CONNECT, "utf8");

date_default_timezone_set('Asia/Almaty');

$reg_day = date('Y-m-d H:i:s');

$today = date('Y-m-d');


$id = $_POST['Uid'];

if (mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM structure WHERE user_id = '$id' "))) {
	exit('0');
}

if ($_POST['a_status'] == 1) {
	$vp = 10;
	$dollar = 35;
}
else if ($_POST['a_status'] == 2){
	$vp = 30;
	$dollar = 105;
}
else if ($_POST['a_status'] == 3){
	$vp = 80;
	$dollar = 280;
}

$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT ref, login FROM users WHERE id = '$id' "));

$ref = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT u.a_status, s.sponsor_id FROM users u INNER JOIN structure s ON u.id = s.user_id WHERE u.id = '$row[ref]' "));

$direct = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT l_vp, r_vp, direction, position FROM binar_log WHERE user_id = '$row[ref]' "));

if ($direct['direction'] == 3) {
	if ($direct['position'] == 0) {
		if ($direct['l_vp'] > $direct['r_vp']) $dr = 2;
		else $dr = 1;
	}
	else {
		$dr = $direct['position'];
	}
		
}
else if ($direct['direction'] == 0) {
	$ref2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT second_follower FROM structure WHERE id = '$ref[sponsor_id]' "));

	if ($ref2['second_follower'] == $row['ref']) {
		$dr = 2;
		mysqli_query($CONNECT, "UPDATE binar_log SET direction = 1 WHERE user_id = '$row[ref]' ");
	}
	else {
		$dr = 1;
		mysqli_query($CONNECT, "UPDATE binar_log SET direction = 2 WHERE user_id = '$row[ref]' ");
	}
}
else {
	$dr = $direct['direction'];
	mysqli_query($CONNECT, "UPDATE binar_log SET direction = 3 WHERE user_id = '$row[ref]' ");
}



if ($ref['a_status'] == 1) $dollar1 = $dollar*0.1 ;
if ($ref['a_status'] == 2) $dollar1 = $dollar*0.15 ;
if ($ref['a_status'] == 3) $dollar1 = $dollar*0.2 ;
mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar1' WHERE id = '$row[ref]' ");
mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$row['ref'].'", "2", "'.$dollar1.'", "Реферальный бонус - '.$row['login'].'", "0","'.$reg_day.'")');
$speaker = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT s_status FROM users WHERE id = '$_POST[speaker]' "));
if ($speaker['s_status'] == 4) {
	$dollar2 = $dollar*0.05;
	if ($dollar2 > 12) $dollar2 = 12;
	mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar2' WHERE id = '$_POST[speaker]' ");
	mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_POST['speaker'].'", "2", "'.$dollar2.'", "Бонус спикера - '.$row['login'].'", "0","'.$reg_day.'")');
}

mysqli_query($CONNECT, "INSERT INTO `structure`(user_id,first_follower,second_follower,sponsor_id,start,business,premium) VALUES ('$id', 0, 0, 0, 0, 0, 0)");

mysqli_query($CONNECT, "INSERT INTO `binar_log`(user_id,l_vp,r_vp,left_vp,right_vp,direction,position) VALUES ('$id', 0, 0, 0, 0, 0, 0)");

$active_date = date('Y-m-d', strtotime('+ 1 months'));

mysqli_query($CONNECT, "INSERT INTO `s_bonus_log`(user_id,total_amount,current_amount, money, active_date) VALUES ('$id', 0, 0, 0, '$active_date')");

mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "9", "'.$dollar.'", "'.$_POST['a_status'].'", "0","'.$reg_day.'")');

mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "8", "'.$vp.'", "Баллы", "0","'.$reg_day.'")');


congratulation_email($id);
echo followers_place($row['ref']);







function followers_place ( $ref ){
	global $CONNECT;
	global $reg_day;
	global $dr;
	global $id;
	$resultx = mysqli_query($CONNECT, "SELECT id, user_id, first_follower, second_follower FROM structure WHERE user_id = '$ref'  ");
	$row = mysqli_fetch_assoc($resultx);


	

	if ($row['first_follower'] == 0 && $dr == 1) {
		$ref_id = $row['id'];
		mysqli_query($CONNECT, "UPDATE structure SET first_follower = '$id' WHERE id = '$ref_id' ");
		mysqli_query($CONNECT, "UPDATE structure SET sponsor_id = '$ref_id' WHERE user_id = '$id' ");

		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://vertexmax.com/event/binar.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query(array( 
				'key' => '*key*',
				'val' => 1,
				'id' => $id,
			))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);

		return '1';
	}
	else if ($row['second_follower'] == 0 && $dr == 2) {
		$ref_id = $row['id'];
		mysqli_query($CONNECT, "UPDATE structure SET second_follower = '$id' WHERE id = '$ref_id' ");
		mysqli_query($CONNECT, "UPDATE structure SET sponsor_id = '$ref_id' WHERE user_id = '$id' ");


		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://vertexmax.com/event/binar.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query(array( 
				'key' => '*key*',
				'val' => 1,
				'id' => $id,
			))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);

		return '1' ;
	}
	else { 
		if ($dr == 1) $ref = $row['first_follower'];
		else if ($dr == 2) $ref = $row['second_follower'];

		return followers_place ( $ref ) ;

	}

	
}


function congratulation_email( $id ) {
	global $CONNECT;
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT email, login, password FROM users WHERE id = '$id'"));

	$to      = $row['email'];
	$subject = 'Добро пожаловать в Vertex Max';


	$message = '<center><b style="font-size:22px">Добро пожаловать,'.$row['login'].'</b><br/><br/><i style="font-size:16px">Поздравляем с регистрацией на сайте http://vertexmax.com/
	<br/>Ваши данные:
	<br/>Логин: - <b>'.$row['login'].'</b>
	<br/>Пароль: - <b>'.$row['password'].'</b>
	<br/>Желаем Вам больших успехов и крепкого здоровья!
	<p align="right">С уважением администрация Vertexmax</p></i>';


	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: Vertex Max <admin@vertexmax.com>' . "\r\n" .
	'Reply-To: admin@vertexmax.com' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);

}



?>