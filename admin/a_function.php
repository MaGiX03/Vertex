<?php 
if (!$_SESSION['admin']) go('login1');
else if ($_POST['test_f']) {

	$vp = 10;
	$id = 4934;
	$w = 1;
	while($w == 1) {
	    
	
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT sponsor_id FROM structure WHERE user_id = '$id' "));
	if ($row['sponsor_id'] == 0) $w = 0;
	$ref = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT user_id, first_follower, second_follower, sponsor_id FROM structure WHERE id = '$row[sponsor_id]' "));
	

	if ($ref['first_follower'] == $id) {
		mysqli_query($CONNECT, "UPDATE binar_log SET l_vp = l_vp - '$vp' WHERE user_id = '$ref[user_id]' ");

	}
	else if ($ref['second_follower'] == $id) {
		mysqli_query($CONNECT, "UPDATE binar_log SET r_vp = r_vp - '$vp' WHERE user_id = '$ref[user_id]' ");
	}

	if ($vp == 10) {
		mysqli_query($CONNECT, "UPDATE structure SET start = start - 1 WHERE user_id = '$ref[user_id]' ");
	}
	else if ($vp == 30) {
		mysqli_query($CONNECT, "UPDATE structure SET business = business - 1 WHERE user_id = '$ref[user_id]' ");
	}
	else if ($vp == 80) {
		mysqli_query($CONNECT, "UPDATE structure SET premium = premium - 1 WHERE user_id = '$ref[user_id]' ");
	}

	$id = $ref['user_id'];
	
	}
	echo 'yey';
}

else if ($_POST['test2_f']) {
	exit('2');

}

else if ($_POST['test3_f']) {
	exit('1');

}






else if ($_POST['p_add_f']) {

	$ext = pathinfo($_FILES["p_img"]["name"], PATHINFO_EXTENSION);
	if ($ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='avi' ) {
		message('Картинка должна быть в формате jpeg,jpg,png');
	}
	$filename = md5($_FILES['p_img']['name'].uniqid()).'.'.$ext;
	if ($ext!='avi') {
		$upload = move_uploaded_file($_FILES['p_img']['tmp_name'], 'images/product/'.$filename);
		if($upload == FALSE) message('Не удалось загрузить файл');
		$_POST['p_text'] = mysqli_real_escape_string ($CONNECT,$_POST['p_text'] );
		$result = mysqli_query($CONNECT, 'INSERT INTO `products`(p_name,p_desc,p_img,p_text,p_date) VALUES ("'.$_POST['p_name'].'"," ", "'.$filename.'", "'.$_POST['p_text'].'", "'.$today.'")');
		$insert_id = mysqli_insert_id($CONNECT);
		if ($result) {
			$out = [
				"s_message" => 'Продукт успешно добавлен',
				"p_id" => $insert_id,
			];
			echo json_encode($out);
		}
		else message('Произошла ошибка. Попробуйте ещё раз');

	}
	else {
		$upload = move_uploaded_file($_FILES['p_img']['tmp_name'], 'video/'.$filename);
		if($upload == FALSE) message('Не удалось загрузить файл');
		else s_message('Успешно');
	}


}

else if ($_POST['p_change_f']) {
	$id = $_POST['p_id'];
	if ($id == 0) message('Выберите продукт');
	$ext = pathinfo($_FILES["p_img"]["name"], PATHINFO_EXTENSION);
	if ($ext!='jpg' && $ext!='png' && $ext!='jpeg') {
		message('Картинка должна быть в формате jpeg,jpg,png');
	}
	$filename = md5($_FILES['p_img']['name'].uniqid()).'.'.$ext;
	$upload = move_uploaded_file($_FILES['p_img']['tmp_name'], 'images/product/'.$filename);
	if($upload == FALSE) message('Не удалось загрузить файл');
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT p_img FROM products WHERE id = '$id' "));
	$mask = 'images/product/'.$row['p_img'];
	if(file_exists($mask)) unlink ($mask);
	$_POST['p_text'] = mysqli_real_escape_string ($CONNECT,$_POST['p_text'] );
	$result = mysqli_query($CONNECT, "UPDATE products SET p_name = '$_POST[p_name]', p_text = '$_POST[p_text]', p_img = '$filename' WHERE id = '$id' ");
	if ($result) {
		s_message('Продукт успешно изменён');
	}
	else message('Произошла ошибка. Попробуйте ещё раз');

}

else if ($_POST['p_delete_f']) {

	$id = $_POST['p_id'];
	if ($id == 0) message('Выберите продукт');
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT p_img FROM products WHERE id = '$id' "));
	$mask = 'images/product/'.$row['p_img'];
	if(file_exists($mask)) unlink ($mask);
	$result = mysqli_query($CONNECT, "DELETE FROM products WHERE id = '$id'");
	if ($result) s_message('Продукт удалён');
	else message('Произошла ошибка. Попробуйте ещё раз');
}

else if ($_POST['show_tovar_f']) {
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT * FROM products WHERE id = '$_POST[id]' "));
	echo json_encode($row);
}

else if ($_POST['withdrawal_count_f']) {

	if ($_POST['val'] == 1 || $_POST['val'] == 3) {
		$val = 1;
		$first_date = $_POST['date'];
		$second_date = date('Y-m-d', strtotime($_POST['date'].'+ 1 days'));
	}
	else {
		$val = 0;
		$first_date = date('Y-m-d', strtotime('2000-01-01'));
		$second_date = date('Y-m-d', strtotime($today.'+ 1 days'));
	}

	if ($_POST['val'] == 0 || $_POST['val'] == 1) {
		$type = 4;
	}
	else {
		$type = 1;
	}
	

	if ($_POST['text'] != '') {
		$resultx = mysqli_query($CONNECT, "SELECT COUNT(l.id) AS count FROM `user_logs` l INNER JOIN users u ON l.user_id = u.id WHERE u.login LIKE '%$_POST[text]%' AND l.log_type = '$type' AND l.log_checked = '$val' AND l.input_date >= '$first_date' AND l.input_date < '$second_date' ORDER BY l.input_date DESC ");
	}
	else {
		$resultx = mysqli_query($CONNECT, "SELECT COUNT(l.id) AS count FROM `user_logs` l INNER JOIN users u ON l.user_id = u.id WHERE l.log_type = '$type' AND l.log_checked = '$val' AND l.input_date >= '$first_date' AND l.input_date < '$second_date' ORDER BY l.input_date DESC ");
	}

	$row = mysqli_fetch_assoc($resultx);
	echo $row['count'];

}

else if ($_POST['withdrawal_check_f']) {

	if ($_POST['val'] == 1 || $_POST['val'] == 3) {
		$val = 1;
		$first_date = $_POST['date'];
		$second_date = date('Y-m-d', strtotime($_POST['date'].'+ 1 days'));
	}
	else {
		$val = 0;
		$first_date = date('Y-m-d', strtotime('2000-01-01'));
		$second_date = date('Y-m-d', strtotime($today.'+ 1 days'));
	}

	if ($_POST['val'] == 0 || $_POST['val'] == 1) {
		$type = 4;
	}
	else {
		$type = 1;
	}
	

	if ($_POST['text'] != '') {
		$resultx = mysqli_query($CONNECT, "SELECT l.id, l.text, l.summa, l.log_type, l.input_date, l.user_id, u.login FROM `user_logs` l INNER JOIN users u ON l.user_id = u.id WHERE u.login LIKE '%$_POST[text]%' AND l.log_type = '$type' AND l.log_checked = '$val' AND l.input_date >= '$first_date' AND l.input_date < '$second_date' ORDER BY l.input_date DESC LIMIT 27 OFFSET $_POST[start] ");
	}
	else {
		$resultx = mysqli_query($CONNECT, "SELECT l.id, l.text, l.summa, l.log_type, l.input_date, l.user_id, u.login FROM `user_logs` l INNER JOIN users u ON l.user_id = u.id WHERE l.log_type = '$type' AND l.log_checked = '$val' AND l.input_date >= '$first_date' AND l.input_date < '$second_date' ORDER BY l.input_date DESC LIMIT 27 OFFSET $_POST[start] ");
	}

	$out = array();
	$i = 1;
	if (mysqli_num_rows($resultx)) {
		while($row = mysqli_fetch_assoc($resultx)) {
			if ($row['log_type'] == 4) {
				$row['text'] = 'Сумма: '.$row['summa'].' | Карта: '.$row['text'].'';
			}
			else {
				$del = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT text FROM user_logs WHERE user_id = '$row[user_id]' AND log_type = 16 "));
				$inf = explode('.', $row['text']);
				$row['text'] = 'Продукт: '.$inf[1].' | Адрес доставки: '.$del['text'].'';
			}

			$row['title'] = $row['login'];

			$row['input_date'] = date('d.m.Y',strtotime($row['input_date']));
			$out[$i++] = $row;
		}
	}
	else {
		$out['no_result'] = 1;
	}

	echo json_encode($out);

}

else if ($_POST['withdrawal_checked_f']) {
	$id = $_POST['id'];
	$val = $_POST['val'];
	if ($val == 1) {
		$result = mysqli_query($CONNECT, "UPDATE user_logs SET log_checked = 1 WHERE id = '$id' ");
	}
	else if ($val == 2) {
		$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT user_id, summa, log_type FROM user_logs WHERE id = '$id' "));
		if ($row['log_type'] == 4) {
			mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$row[summa]' WHERE id = '$row[user_id]' ");
		}
		
		$result = mysqli_query($CONNECT, "DELETE FROM user_logs WHERE id = '$id' ");

	}
	

	if ($result) echo "1";
	else echo "0";


}

/* Статистика */
else if ($_POST['stats_f']) {


	$result = mysqli_query($CONNECT,"SELECT 
		(
		SELECT SUM(balance)
		FROM users 
		) AS sum_balance,
		(
		SELECT SUM(summa)
		FROM user_logs WHERE log_type = 4 AND log_checked = 1 
		) AS sum_withdrawal,
		(
		SELECT SUM(summa)
		FROM user_logs WHERE log_type = 2 
		) AS sum_nach,
		(
		SELECT SUM(summa)
		FROM user_logs WHERE text LIKE '%Матчинг бонус%'
		) AS sum_matching,
		(
		SELECT SUM(summa)
		FROM user_logs WHERE text LIKE '%Бинарный бонус%'
		) AS sum_binar,
		(
		SELECT COUNT(id)
		FROM users WHERE a_status = 1
		) AS count_users1,
		(
		SELECT COUNT(id)
		FROM users WHERE a_status = 2
		) AS count_users2,
		(
		SELECT COUNT(id)
		FROM users WHERE a_status = 3
		) AS count_users3,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 1
		) AS count_status1,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 2
		) AS count_status2,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 3
		) AS count_status3,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 4
		) AS count_status4,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 5
		) AS count_status5,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 6
		) AS count_status6,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 7
		) AS count_status7,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 8
		) AS count_status8,
		(
		SELECT COUNT(id)
		FROM users WHERE s_status = 9
		) AS count_status9,
		(
		SELECT COUNT(id)
		FROM user_logs WHERE log_type = 1 AND summa > 0
		) AS count_product,
		(
		SELECT SUM(value)
		FROM stats_log WHERE name = 'ComBalance'
		) AS sum_comBalance,
		(
		SELECT SUM(value)
		FROM stats_log WHERE name = 'ProdReg'
		) AS sum_prodReg,
		(
		SELECT SUM(value)
		FROM stats_log WHERE name = 'ProdAct'
		) AS sum_prodAct,
		(
		SELECT SUM(value)
		FROM stats_log WHERE name = 'ComOffice'
		) AS sum_comOffice,
		(
		SELECT SUM(value)
		FROM stats_log WHERE name = 'ComDelivery'
		) AS sum_comDelivery,
		(
		SELECT SUM(summa)
		FROM user_logs WHERE log_type = 1 
	) AS sum_product ");



	$row = mysqli_fetch_assoc($result);
	$row['count_users'] = $row['count_users1'] + $row['count_users2'] + $row['count_users3'];

	$row['sum_prihod'] = $row['sum_product'] + $row['count_users1']*35 + $row['count_users2']*105 + $row['count_users3']*280;
	$row['test'] = $row['sum_prihod'];
	$row['sum_prihod'] = $row['sum_prihod'] - $row['sum_nach'];

	$row['sum_reg'] = $row['count_users1']*9.52 + $row['count_users2']*28.57 + $row['count_users3']*76.19;
	$row['sum_prihod'] = $row['sum_prihod'] - $row['sum_reg'];

	$row['sum_act'] = $row['count_product']*9.52;
	$row['sum_prihod'] = $row['sum_prihod'] - $row['sum_act'];


	$row['sum_ofis'] = $row['count_users']*2.38;
	$row['sum_prihod'] = $row['sum_prihod'] - $row['sum_ofis'];

	$row['sum_dostavka'] = $row['count_users']*2.38 + $row['count_product']*2.38;
	$row['sum_prihod'] = $row['sum_prihod'] - $row['sum_dostavka'];

	$row['sum_prihod'] = $row['sum_prihod'] - $row['sum_comBalance'];
	$row['sum_reg'] = $row['sum_reg'] - $row['sum_prodReg'];
	$row['sum_act'] = $row['sum_act'] - $row['sum_prodAct'];
	$row['sum_ofis'] = $row['sum_ofis'] - $row['sum_comOffice'];
	$row['sum_dostavka'] = $row['sum_dostavka'] - $row['sum_comDelivery'];


	$row['sum_nach'] = number_format($row['sum_nach'], 2, ',', ' ');
	$row['sum_prihod'] = number_format($row['sum_prihod'], 2, ',', ' ');
	$row['sum_withdrawal'] = number_format($row['sum_withdrawal'], 2, ',', ' ');
	$row['sum_balance'] = number_format($row['sum_balance'], 2, ',', ' ');
	$row['sum_reg'] = number_format($row['sum_reg'], 2, ',', ' ');
	$row['sum_act'] = number_format($row['sum_act'], 2, ',', ' ');
	$row['sum_dostavka'] = number_format($row['sum_dostavka'], 2, ',', ' ');
	$row['sum_ofis'] = number_format($row['sum_ofis'], 2, ',', ' ');

	/*$row['sum_prihod'] = $row['sum_prihod'] + $row['sum_matching'] + $row['sum_binar'];*/

	echo json_encode($row);
}

else if ($_POST['stats_date_f']) {

	if ($_POST['val'] == 1) {
		if ($_POST['date1'] != '') $dt1 = date('Y-m-d H:i:s', strtotime($_POST['date1']));
		else  $dt1 = date('Y-m-d H:i:s', strtotime('0'));

		if ($_POST['date2'] != '') $dt2 =  date('Y-m-d H:i:s', strtotime($_POST['date2'].'+ 23 hours 59 mins 59 secs'));
		else $dt2 = date('Y-m-d H:i:s');
	}
	else {
		$dt1 = date('Y-m-d H:i:s', strtotime('0'));
		$dt2 = date('Y-m-d H:i:s');
	}
	$result = mysqli_query($CONNECT,"SELECT 
		(
		SELECT SUM(summa)
		FROM user_logs WHERE log_type = 4 AND log_checked = 1 AND input_date >= '$dt1' AND input_date <= '$dt2'
		) AS sum_withdrawal,
		(
		SELECT SUM(summa)
		FROM user_logs WHERE log_type = 2 AND input_date >= '$dt1' AND input_date <= '$dt2'
		) AS sum_nach,
		(
		SELECT SUM(summa)
		FROM user_logs WHERE log_type = 12 AND input_date >= '$dt1' AND input_date <= '$dt2'
		) AS sum_upgrade,
		(
		SELECT COUNT(id)
		FROM user_logs WHERE log_type = 9 AND text = 1 AND input_date >= '$dt1' AND input_date <= '$dt2'
		) AS start_count,
		(
		SELECT COUNT(id)
		FROM user_logs WHERE log_type = 9 AND text = 2 AND input_date >= '$dt1' AND input_date <= '$dt2'
		) AS business_count,
		(
		SELECT COUNT(id)
		FROM user_logs WHERE log_type = 9 AND text = 3 AND input_date >= '$dt1' AND input_date <= '$dt2'
		) AS premium_count, 
		(
		SELECT SUM(summa)
		FROM user_logs WHERE log_type = 1  AND input_date >= '$dt1' AND input_date <= '$dt2'
	) AS sum_product ");
	$row = mysqli_fetch_assoc($result);
	$row['sum_prihod'] = $row['sum_upgrade'] + $row['sum_product'] + $row['start_count']*35 + $row['business_count']*105 + $row['premium_count']*280;

	$row['sum_nach'] = number_format($row['sum_nach'], 2, ',', ' ');
	$row['sum_prihod'] = number_format($row['sum_prihod'], 2, ',', ' ');
	$row['sum_withdrawal'] = number_format($row['sum_withdrawal'], 2, ',', ' ');

	echo json_encode($row);
}


else if ($_POST['users_count_f']) {
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM users WHERE login LIKE '%$_POST[text]%' OR email LIKE '%$_POST[text]%' "));
	echo $row['count'];

}

else if ($_POST['users_check_f']) {

	$resultx = mysqli_query($CONNECT, "SELECT id, login FROM `users` WHERE login LIKE '%$_POST[text]%' OR email LIKE '%$_POST[text]%' LIMIT 20 OFFSET $_POST[start] ");
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

else if ($_POST['SelectUser_f']) {
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT * FROM users WHERE id = '$_POST[id]' "));
	$sponsor = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login FROM users WHERE id = '$row[ref]' "));
	$row['ref'] = $sponsor['login'];
	$city = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT country_id, region_id FROM city WHERE city_id = '$row[city]' "));
	$row['region'] = $city['region_id'];
	$row['country'] = $city['country_id'];
	$row['reg_time'] = date('d.m.Y | H:i', strtotime($row['reg_time']));
	if ($row['a_status'] == 1) $row['a_status'] = 'Start';
	else if ($row['a_status'] == 2) $row['a_status'] = 'Business';
	else if ($row['a_status'] == 3) $row['a_status'] = 'Premium';


	if ($row['s_status'] == 1) $row['s_status'] = 'Manager';
	else if ($row['s_status'] == 2) $row['s_status'] = 'Bronze';
	else if ($row['s_status'] == 3) $row['s_status'] = 'Silver';
	else if ($row['s_status'] == 4) $row['s_status'] = 'Gold Director';
	else if ($row['s_status'] == 5) $row['s_status'] = 'Emerald Director';
	else if ($row['s_status'] == 6) $row['s_status'] = 'Platinum Director';
	else if ($row['s_status'] == 7) $row['s_status'] = 'Diamond Director';
	else if ($row['s_status'] == 8) $row['s_status'] = 'Ambassador';
	else if ($row['s_status'] == 9) $row['s_status'] = 'Ambassador';
	else if ($row['s_status'] == 0 && $row['a_status'] != 0) $row['s_status'] = 'Партнёр';

	


	echo json_encode($row);

}

else if ($_POST['change_user_data_f']) {
	if ($_POST['Uid'] == 0) message('Выберите пользователя');
	if ( !preg_match('/^[A-z0-9]{4,30}$/', $_POST['Upassword']) )
		message('Пароль может содеражать от 4 до 30 латинских букв и цифр');
	if ( !filter_var( $_POST['Umail'], FILTER_VALIDATE_EMAIL))
		message('E-mail указан неверно');
	if ( !preg_match('/^[0-9]{10,15}$/', preg_replace("/[ ()-]/", "",$_POST['Unumber'])) )
		message('Номер указан неверно');
	if (!$_POST['Ubirthday']) message('Укажите дату рождения');
	if (!$_POST['Ucity']) message('Укажите город');

	$result =  mysqli_query($CONNECT, "UPDATE users SET password = '$_POST[Upassword]',email = '$_POST[Umail]', number = '$_POST[Unumber]', fio = '$_POST[Ufio]', city = '$_POST[Ucity]', birthday = '$_POST[Ubirthday]' WHERE id = '$_POST[Uid]' ");

	if ($result) s_message('Изменения сохранены');
	else message('Произошла ошибка');



}

else if ($_POST['act_users_count_f']) {
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM users WHERE login LIKE '%$_POST[text]%' AND a_status = 0 OR email LIKE '%$_POST[text]%' AND a_status = 0 "));
	echo $row['count'];

}

else if ($_POST['act_users_check_f']) {

	$resultx = mysqli_query($CONNECT, "SELECT id, login FROM `users` WHERE login LIKE '%$_POST[text]%' AND a_status = 0 OR email LIKE '%$_POST[text]%' AND a_status = 0 LIMIT 20 OFFSET $_POST[start] ");
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

else if ($_POST['user_activate_f']) {

	$user = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT ref FROM users WHERE id = '$_POST[id]' "));

	if (!mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM users WHERE id = '$user[ref]' AND a_status != 0 "))) exit('2');

	if (!mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM users WHERE id = '$_POST[id]' AND a_status = 0 "))) exit('3');

	$result = mysqli_query($CONNECT, "UPDATE users SET a_status = '$_POST[paket]' WHERE id = '$_POST[id]' ");
	mysqli_query($CONNECT, "UPDATE guests SET involvement = 4 WHERE user_id = '$_POST[id]' ");

	if ($result) {
		$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT text FROM user_logs WHERE user_id = '$_POST[id]' AND log_type = 7  "));
		if ($row == '') $speaker = 0;
		else $speaker = $row['text'];
		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://vertexmax.com/event/structure.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query(array( 
				'key' => 'xgnp3PZVyw74Efj',
				'Uid' => $_POST['id'],
				'a_status' => $_POST['paket'],
				'speaker' => $speaker,
			))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);

		if ($response == 1) echo "1";
		else echo "0";
	}
	else echo "0";

}


else if ($_POST['user_delete_f']) {
	$result = mysqli_query($CONNECT, "DELETE FROM users WHERE id = '$_POST[id]' ");


	if ($result) {
		echo "1";
	}
	else echo "0";
}


else if ($_POST['stats_spisat_f']) {
	if ($_POST['name'] == '') message('Произошла ошибка. Обновите страницу и попробуйте ещё раз');

	if (!ctype_digit($_POST['value']) || $_POST['value'] <= 0) message('Укажите сумму');

	if ($_POST['value'] > $_POST['value2']) message('Сумма списывания превышает действительную сумму');

	$result = mysqli_query($CONNECT, "INSERT INTO `stats_log`(name,value,input_date) VALUES ('$_POST[name]', '$_POST[value]', '$today')");

	if ($result) s_message('Успешно');
	else message('Произошла ошибка. Обновите страницу и попробуйте ещё раз');




}


else if ($_POST['users_sp_count_f']) {
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(u.id) AS count FROM users u INNER JOIN user_logs l ON u.id = l.user_id WHERE u.login LIKE '%$_POST[text]%' AND l.log_type = 8 AND l.summa > 0 OR email LIKE '%$_POST[text]%' AND l.log_type = 8 AND l.summa > 0 "));
	echo $row['count'];

}

else if ($_POST['users_sp_check_f']) {

	$resultx = mysqli_query($CONNECT, "SELECT u.id, u.login FROM users u INNER JOIN user_logs l ON u.id = l.user_id  WHERE u.login LIKE '%$_POST[text]%' AND l.log_type = 8 AND l.summa > 0 OR email LIKE '%$_POST[text]%' AND l.log_type = 8 AND l.summa > 0 LIMIT 20 OFFSET $_POST[start] ");
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

else if ($_POST['show_user_sp_f']) {

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT summa FROM user_logs WHERE user_id = '$_POST[id]' AND log_type = 8 "));
	echo $row['summa'];


}

else if ($_POST['give_tovar_f']) {
	$id = $_POST['id'];
	$pid = $_POST['pid'];
	$count = $_POST['count'];
	$sp = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT summa FROM user_logs WHERE user_id = '$id' AND log_type = 8 "));
	$summa = $count*10;
	if ($sp['summa'] < $summa) {
		message('Не хватает СП');
	}
	mysqli_query($CONNECT, "UPDATE user_logs SET summa = summa - '$summa' WHERE user_id = '$id' AND log_type = 8 ");
	$tovar = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT p_name FROM products WHERE id = '$pid' "));
	for ($i=1; $i <= $count ; $i++) { 

		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "1", "0", "'.$pid.'.'.$tovar['p_name'].'", "1","'.$today.'")');
	}

	s_message('Продукт успешно выдан');



}


else if ($_POST['reviews_check_f']) {


	$resultx = mysqli_query($CONNECT, "SELECT *  FROM `reviews` WHERE accepted = '$_POST[val]' ");

	$out = array();
	$i = 1;
	if (mysqli_num_rows($resultx)) {
		while($row = mysqli_fetch_assoc($resultx)) {
			$row['input_date'] = date('d.m.Y',strtotime($row['input_date']));
			$out[$i++] = $row;
		}
	}
	else {
		$out['no_result'] = 1;
	}

	echo json_encode($out);

}

else if ($_POST['review_checked_f']) {

	if ($_POST['val'] == 0) {
		mysqli_query($CONNECT, "UPDATE reviews SET accepted = 1, text = '$_POST[text]' WHERE id = '$_POST[id]' ");
		echo "1";
	}
	else if ($_POST['val'] == 1) {
		mysqli_query($CONNECT, "DELETE FROM reviews WHERE id = '$_POST[id]' ");
		echo "1";
	}
	else echo "0";

}

else if ($_POST['upgrade_user_f']) {
	$val = $_POST['status'];
	$id = $_POST['id'];
	if ($id == 0) message('Выберите пользователя');
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login,a_status, ref FROM users WHERE id = '$id' "));

	if ($val == 2 && $row['a_status'] == 1) {$summa = 70;$vp = 20;}
	else if ($val == 3 && $row['a_status'] == 1) {$summa = 245;$vp = 70;}
	else if ($val == 3 && $row['a_status'] == 2) {$summa = 175;$vp = 50;}
	else message('Произошла ошибка, попробуйте обновить страницу');

	$result =  mysqli_query($CONNECT, "UPDATE users SET a_status = '$val'  WHERE id = '$id' ");

	if ($result) {
		$ref = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT a_status FROM users WHERE id = '$row[ref]' "));
		if ($ref['a_status'] == 1) $dollar1 = $summa*0.1;
		if ($ref['a_status'] == 2) $dollar1 = $summa*0.15;
		if ($ref['a_status'] == 3) $dollar1 = $summa*0.2;
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar1' WHERE id = '$row[ref]' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$row['ref'].'", "2", "'.$dollar1.'", "Реферальный бонус с апгрейда - '.$row['login'].'", "0","'.$today.'")');

		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://vertexmax.com/event/binar.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query(array( 
				'key' => 'xgnp3PZVyw74Efj',
				'val' => 3,
				'id' => $id,
				'vp' => $vp,
			))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);
		mysqli_query($CONNECT, "UPDATE user_logs SET summa = summa + '$vp' WHERE user_id = '$id' AND log_type = 8 ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "12", "'.$summa.'", "'.$vp.'", "0","'.$today.'")');
		s_message('Успешный апгрейд');

	}
	else message('Произошла ошибка');



}

else if ($_POST['office_data_f']) {
	$id = $_POST['id'];
	$val = $_POST['val'];
	$_POST['city'] = mysqli_real_escape_string ($CONNECT,$_POST['city'] );
	$_POST['address'] = mysqli_real_escape_string ($CONNECT,$_POST['address'] );
	$_POST['number'] = mysqli_real_escape_string ($CONNECT,$_POST['number'] );
	if ($val == 1) {
		$result = mysqli_query($CONNECT, 'INSERT INTO `offices`(city, address, number) VALUES ("'.$_POST['city'].'", "'.$_POST['address'].'", "'.$_POST['number'].'")');
	}
	else if ($val == 2) {
		if ($id == 0) message('Выберите офис');
		$result = mysqli_query($CONNECT, "UPDATE offices SET city = '$_POST[city]', address = '$_POST[address]', number = '$_POST[number]' WHERE id = '$id' ");
	}
	else if ($val == 3) {
		$min_id = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT MIN(id) AS id FROM offices"));
		if ($min_id['id'] == $id) message('Головной офис нельзя удалить');
		$result = mysqli_query($CONNECT, "DELETE FROM offices WHERE id = '$id' ");
	}
	
	if ($result) {
		s_message('Успешно');
	}
	else message('Произошла ошибка. Попробуйте ещё раз');

}

else if ($_POST['show_office_f']) {
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT * FROM offices WHERE id = '$_POST[id]' "));
	echo json_encode($row);
}

else if ($_POST['show_partners_f']) {
	$result = mysqli_query($CONNECT, "SELECT login FROM users WHERE s_status = '$_POST[val]' ");

	while ($row = mysqli_fetch_assoc($result)) {
		$text = $text.' | '.$row['login'];
	}

	echo $text;
}

?>