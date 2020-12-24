<?php

/* АВТОРИЗАЦИЯ, РЕГИСТРАЦИЯ и т.д. */

if ($_POST['login_f']) {

	if ($_POST['login'] == 'admin'){
		if ($_POST['password'] != 'password') message('Неверный пароль или логин');

		$_SESSION['admin'] = 1;
		go('a_stats');
	}
	if ($_POST['login'] == 'logist'){
		if ($_POST['password'] != 'password') message('Неверный пароль или логин');

		$_SESSION['logist'] = 1;
		go('log_main');
	}
	$_POST['login'] = mysqli_real_escape_string ($CONNECT,$_POST['login'] );
	$_POST['password'] = mysqli_real_escape_string ($CONNECT,$_POST['password'] );
	if ( !mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `users` WHERE `login` = '$_POST[login]' AND `password` = '$_POST[password]'")) )
		message('Неверный пароль или логин');
	$row = mysqli_fetch_assoc( mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `login` = '$_POST[login]'") );

	session_unset();
	foreach ($row as $key => $value)
		$_SESSION[$key] = $value;
	go('profil');


}


else if ($_POST['register_f']) {
	login_valid();
	email_valid();
	password_valid();
	number_valid();
	if ($_POST['reg_login'] == 'admin') message('Этот логин занят');
	if ( mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `users` WHERE `login` = '$_POST[reg_login]'")) )
		message('Этот логин занят');
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT id,a_status FROM users WHERE login = '$_POST[ref_login]' "));
	if ($row == '') message('Вы ввели не существующий логин спонсора');
	if ($_POST['speaker_login'] != '') {
		$row2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT id FROM users WHERE login = '$_POST[speaker_login]' "));
		if ($row2 == '') message('Вы ввели не существующий логин спикера');
	}

	$dt = date('Y-m-d H:i:s');
	$result = mysqli_query($CONNECT, 'INSERT INTO `users`(login,password,number,email,ref,balance,point,s_status,a_status,country,city,fio,birthday,reg_time) VALUES ("'.$_POST['reg_login'].'", "'.$_POST['reg_password'].'", "'.$_POST['number'].'", "'.$_POST['email'].'","'.$row['id'].'", "0", "0","0","0","'.$_POST['country'].'","'.$_POST['city'].'","'.$_POST['fio'].'","'.$_POST['birthday'].'", "'.$dt.'")');
	$insert_id = mysqli_insert_id($CONNECT);
	if ($row2 != '') mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$insert_id.'", "7", "0", "'.$row2['id'].'", "0","'.$dt.'")');

	if ($_SESSION['id'] != '' && $_SESSION['name'] != '') {
		$row = mysqli_fetch_assoc( mysqli_query($CONNECT, "SELECT involvement FROM `guests` WHERE `id` = '$_SESSION[id]' ") );

		if ($row['involvement'] <= 2) {
			mysqli_query($CONNECT, "UPDATE guests SET involvement = 3, user_id = '$insert_id' WHERE id = '$_SESSION[id]' ");
		}

	}

	$row = mysqli_fetch_assoc( mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '$insert_id'") );

	session_unset();
	foreach ($row as $key => $value)
		$_SESSION[$key] = $value;
	go('profil');

}


else if ($_POST['recovery_f']) {
	$_POST['rec_login'] = mysqli_real_escape_string ($CONNECT,$_POST['rec_login'] );
	$query = mysqli_query($CONNECT, "SELECT `password`, `email` FROM `users` WHERE `login` = '$_POST[rec_login]'");

	if ( mysqli_num_rows($query) )
	{
		$row = mysqli_fetch_assoc($query);

		$to      = $row['email'];
		$subject = 'Восстановление пароля';


		$message = '<center><i style="font-size:14px">Уважаемый <b>'.$_POST['rec_login'].'.</b> Вы сделали запрос на получение забытого пароля на сайте <a href="https://vertexmax.com">vertexmax.com</a>
		<br/>Ваш пароль - <b>'.$row['password'].'</b>
		<br/>Если вы не запрашивали пароль, просто удалите это сообщение.</center></i>';


		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: Vertex Max <admin@vertexmax.com>' . "\r\n" .
		'Reply-To: admin@vertexmax.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		if (mail($to, $subject, $message, $headers)) {
			s_message('Пароль отправлен на почту');
		}
		else message('Почтовый сервер перегружен, попробуйте позже');

	}
	else {
		message('Пользователь с таким логином не зарегестрирован');
	}
}

else if ($_POST['user_activation_f']) {
	$user = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT balance, ref, a_status FROM users WHERE id = '$_SESSION[id]' "));

	if (!mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM users WHERE id = '$user[ref]' AND a_status != 0 "))) {
		message('Вы не можете активироваться, так как ваш спонсор не активирован');
	}

	if ($user['a_status'] != 0) message('Вы уже активированы. Обновите страницу или перезайдите в аккаунт');

	if ($_POST['paket'] == 1) $summa = 35;
	else if ($_POST['paket'] == 2) $summa = 105;
	else if ($_POST['paket'] == 3) $summa = 280;
	else message('Выберите пакет');

	if ($summa > $user['balance']) message('Не хватает средств');

	$result = mysqli_query($CONNECT, "UPDATE users SET a_status = '$_POST[paket]', balance = balance - '$summa' WHERE id = '$_SESSION[id]' ");
	mysqli_query($CONNECT, "UPDATE guests SET involvement = 4 WHERE user_id = '$_SESSION[id]' ");

	if ($result) {
		$_SESSION['a_status'] = $_POST['paket'];
		$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT text FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 7  "));
		if ($row == '') $speaker = 0;
		else $speaker = $row['text'];
		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://vertexmax.com/event/structure.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query(array(
				'key' => '*key*',
				'Uid' => $_SESSION['id'],
				'a_status' => $_POST['paket'],
				'speaker' => $speaker,
			))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);

		if ($response == 1) {
			go('profil');
		}
		else message('Ошибка');
	}
	else message('Ошибка');


}

else if ($_POST['auto_reg_f']) {
	if ($_POST['name'] != '') {
		$number = mysqli_real_escape_string ($CONNECT,$_POST['number'] );
		$name = mysqli_real_escape_string ($CONNECT,$_POST['name'] );
	}
	else {
		$number = mysqli_real_escape_string ($CONNECT,$_POST['number2'] );
		$name = mysqli_real_escape_string ($CONNECT,$_POST['name2'] );
	}

	if ($name == '') message('Введите имя');
	if ($number == '') message('Введите номер');

	if ($_COOKIE['auto'] == 0) $ref = 1;
	else {
		$ref = $_COOKIE['auto'];
	}

	$row = mysqli_fetch_assoc( mysqli_query($CONNECT, "SELECT * FROM `guests` WHERE `name` = '$name' AND `number` = '$number' ") );

	if ($row['id'] == '') {
		$result = mysqli_query($CONNECT, 'INSERT INTO `guests`(name,number, ref, involvement, user_id, reg_time ) VALUES ("'.$name.'", "'.$number.'", "'.$ref.'", "1", "0" , "'.$today.'")');
		$insert_id = mysqli_insert_id($CONNECT);

		$row = mysqli_fetch_assoc( mysqli_query($CONNECT, "SELECT * FROM `guests` WHERE `id` = '$insert_id'") );
	}


	session_unset();
	foreach ($row as $key => $value)
		$_SESSION[$key] = $value;
	go('voronka');


}

else if ($_POST['start_reg_f']) {
	$row = mysqli_fetch_assoc( mysqli_query($CONNECT, "SELECT involvement FROM `guests` WHERE `id` = '$_SESSION[id]' ") );
	if ($row['involvement'] == 1) {
		mysqli_query($CONNECT, "UPDATE guests SET involvement = 2 WHERE id = '$_SESSION[id]' ");
	}

	go('login');



}

else if ($_POST['check_status_f']) {
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT a_status FROM users WHERE id = '$_SESSION[id]' "));

	if ($row['a_status'] != 0) {
		$_SESSION['a_status'] = $row['a_status'];
		echo "1";
	}
	else echo "0";

}

else if ($_POST['show_regions_f']) {

	$resultx = mysqli_query($CONNECT, "SELECT region_id, name FROM `region` WHERE country_id = '$_POST[val]' ORDER BY name ASC ");
	if (mysqli_num_rows($resultx)) {
		$out = array();
		$i = 1;
		while($row = mysqli_fetch_assoc($resultx)) {
			$out[$i++] = $row;
		}

		echo json_encode($out);
	}
	else {
		echo "0";
	}

}
else if ($_POST['show_cities_f']) {

	$resultx = mysqli_query($CONNECT, "SELECT city_id, name FROM `city` WHERE region_id = '$_POST[val]' ORDER BY name ASC ");
	if (mysqli_num_rows($resultx)) {
		$out = array();
		$i = 1;
		while($row = mysqli_fetch_assoc($resultx)) {
			$out[$i++] = $row;
		}

		echo json_encode($out);
	}
	else {
		echo "0";
	}

}


?>
