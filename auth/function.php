<?php 

if (!$_SESSION['id'] || !$_SESSION['login']) go('login1');

else if ($_POST['buy_tovar_f']) {
	if ($_POST['val'] != 1 && $_POST['val'] != 2 && $_POST['val'] != 3 && $_POST['val'] != 4) message('Выберите способ оплаты');
	

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT balance, point FROM users WHERE id = '$_SESSION[id]' "));


	if ($_POST['val'] == 2) {
		if ($row['balance'] < 35) {
			message('На вашем балансе не хватает средств');
		}
		mysqli_query($CONNECT, "UPDATE users SET balance = balance - 35 WHERE id = '$_SESSION[id]' ");
		mysqli_query($CONNECT, "UPDATE users SET point = point + 1 WHERE id = '$_SESSION[id]' ");
		$summa = 35;

	}
	else if ($_POST['val'] == 1) {
		if ($row['point'] < 10) {
			message('У вас не хватает бонусных баллов');
		}
		mysqli_query($CONNECT, "UPDATE users SET point = point - 9 WHERE id = '$_SESSION[id]' ");
		$summa = 10;
	}
	else if ($_POST['val'] == 4) {
		$start_point = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT summa FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 8 "));

		if ($start_point['summa'] < 10) {
			message('У вас не хватает СП');
		}
		mysqli_query($CONNECT, "UPDATE user_logs SET summa = summa - 10 WHERE user_id = '$_SESSION[id]' AND log_type = 8 ");
		$summa = 0;

	}
	else if ($_POST['val'] == 3) message('Этот способ оплаты временно недоступен');
	

	$tovar = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT p_name FROM products WHERE id = '$_POST[id]' "));
	mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "1", "'.$summa.'", "'.$_POST['id'].'.'.$tovar['p_name'].'", "0","'.$today.'")');

	if ($_POST['val'] != 4) {
		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://vertexmax.com/event/structure_bonus.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query(array( 
				'key' => 'xgnp3PZVyw74Efj',
				'id' => $_SESSION['id'],
				'val' => 1,
			))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);
		if ($response == 1) {
			s_message('Поздравляем с покупкой');
		}
	}
	else s_message('Поздравляем с покупкой');
	
	
	
}

else if ($_POST['point_check_f']) {

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT balance, point FROM users WHERE id = '$_SESSION[id]' "));
	$start_point = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT summa FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 8 "));
	$row['sp'] = $start_point['summa'];

	echo json_encode($row);

}

else if ($_POST['binar_check_f']) {
	$out = [
		"fol1" => 0,
		"fol2" => 0,
		"fol_1_1" => 0,
		"fol_1_2" => 0,
		"fol_2_1" => 0,
		"fol_2_2" => 0,
		"fol_1_login" => '',
		"fol_2_login" => '',
		"fol_1_1_login" => '',
		"fol_1_2_login" => '',
		"fol_2_1_login" => '',
		"fol_2_2_login" => '',
		"no_main" => 0,
		"main_login" => '',
		"l_vp" => 0,
		"r_vp" => 0,
		"left_vp" => 0,
		"right_vp" => 0,
		"l_start" => 0,
		"l_business" => 0,
		"l_premium" => 0,
		"r_start" => 0,
		"r_business" => 0,
		"r_premium" => 0,
	];
	$id = $_POST['id'];
	if ($id != $_SESSION['id']) {
		$out['no_main'] = 1;
		$name = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login FROM users WHERE id = '$id' "));
		$out['main_login'] = $name['login'];
	}
	else {

		$total_vp = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT left_vp, right_vp, l_vp, r_vp FROM binar_log WHERE user_id = '$id' "));
		$out['left_vp'] = $total_vp['left_vp'] + $total_vp['l_vp'];
		$out['right_vp'] = $total_vp['right_vp'] + $total_vp['r_vp'];
		$out['l_vp'] = $total_vp['l_vp'];
		$out['r_vp'] = $total_vp['r_vp'];
	} 
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT first_follower, second_follower FROM structure WHERE user_id = '$id' "));
	$out['fol1'] = $row['first_follower'];
	$out['fol2'] = $row['second_follower'];

	$fol1_name = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login, a_status FROM users WHERE id = '$row[first_follower]' "));
	$fol2_name = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login, a_status FROM users WHERE id = '$row[second_follower]' "));
	if ($fol1_name['a_status'] == 1) {$fol1_name['a_status'] = 'Start'; $out['l_start'] = 1; }
	else if ($fol1_name['a_status'] == 2) {$fol1_name['a_status'] = 'Business'; $out['l_business'] = 1;}
	else if ($fol1_name['a_status'] == 3) {$fol1_name['a_status'] = 'Premium'; $out['l_premium'] = 1;}
	$out['fol_1_login'] = $fol1_name['login'].'<br/>'.$fol1_name['a_status'];
	if ($fol2_name['a_status'] == 1) {$fol2_name['a_status'] = 'Start'; $out['r_start'] = 1;}
	else if ($fol2_name['a_status'] == 2) {$fol2_name['a_status'] = 'Business'; $out['r_business'] = 1;}
	else if ($fol2_name['a_status'] == 3) {$fol2_name['a_status'] = 'Premium'; $out['r_premium'] = 1;}
	$out['fol_2_login'] = $fol2_name['login'].'<br/>'.$fol2_name['a_status'];

	$row_fol1 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT first_follower,second_follower,start,business,premium FROM structure WHERE user_id = '$row[first_follower]' "));
	$row_fol2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT first_follower,second_follower,start,business,premium FROM structure WHERE user_id = '$row[second_follower]' "));

	if ($row_fol1['first_follower'] != 0) $out['fol_1_1'] = $row_fol1['first_follower'];
	if ($row_fol1['second_follower'] != 0) $out['fol_1_2'] = $row_fol1['second_follower'];
	
	if ($row_fol2['first_follower'] != 0) $out['fol_2_1'] = $row_fol2['first_follower'];
	if ($row_fol2['second_follower'] != 0) $out['fol_2_2'] = $row_fol2['second_follower'];

	$fol1_1_name = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login, a_status FROM users WHERE id = '$row_fol1[first_follower]' "));
	$fol1_2_name = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login, a_status FROM users WHERE id = '$row_fol1[second_follower]' "));
	if ($fol1_1_name['a_status'] == 1) $fol1_1_name['a_status'] = 'Start';
	else if ($fol1_1_name['a_status'] == 2) $fol1_1_name['a_status'] = 'Business';
	else if ($fol1_1_name['a_status'] == 3) $fol1_1_name['a_status'] = 'Premium';
	$out['fol_1_1_login'] = $fol1_1_name['login'].'<br/>'.$fol1_1_name['a_status'];
	if ($fol1_2_name['a_status'] == 1) $fol1_2_name['a_status'] = 'Start';
	else if ($fol1_2_name['a_status'] == 2) $fol1_2_name['a_status'] = 'Business';
	else if ($fol1_2_name['a_status'] == 3) $fol1_2_name['a_status'] = 'Premium';
	$out['fol_1_2_login'] = $fol1_2_name['login'].'<br/>'.$fol1_2_name['a_status'];
	$fol2_1_name = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login, a_status FROM users WHERE id = '$row_fol2[first_follower]' "));
	$fol2_2_name = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login, a_status FROM users WHERE id = '$row_fol2[second_follower]' "));
	if ($fol2_1_name['a_status'] == 1) $fol2_1_name['a_status'] = 'Start';
	else if ($fol2_1_name['a_status'] == 2) $fol2_1_name['a_status'] = 'Business';
	else if ($fol2_1_name['a_status'] == 3) $fol2_1_name['a_status'] = 'Premium';
	$out['fol_2_1_login'] = $fol2_1_name['login'].'<br/>'.$fol2_1_name['a_status'];
	if ($fol2_2_name['a_status'] == 1) $fol2_2_name['a_status'] = 'Start';
	else if ($fol2_2_name['a_status'] == 2) $fol2_2_name['a_status'] = 'Business';
	else if ($fol2_2_name['a_status'] == 3) $fol2_2_name['a_status'] = 'Premium';
	$out['fol_2_2_login'] = $fol2_2_name['login'].'<br/>'.$fol2_2_name['a_status'];

	$out['l_start'] = $out['l_start'] + $row_fol1['start'];
	$out['l_business'] = $out['l_business'] + $row_fol1['business'];
	$out['l_premium'] = $out['l_premium'] + $row_fol1['premium'];
	$out['r_start'] = $out['r_start'] + $row_fol2['start'];
	$out['r_business'] = $out['r_business'] + $row_fol2['business'];
	$out['r_premium'] = $out['r_premium'] + $row_fol2['premium'];
	$out['l_count'] = $out['l_start'] + $out['l_business'] + $out['l_premium'];
	$out['r_count'] = $out['r_start'] + $out['r_business'] + $out['r_premium'];

	echo json_encode($out);
}

else if ($_POST['linear_check_f']) {

	$resultx = mysqli_query($CONNECT, "SELECT id, login, a_status, s_status, fio, number  FROM `users` WHERE ref = '$_POST[id]' AND a_status != 0 ");
	$out = array();
	$i = 1;
	$s_bonus = date('Y-m');
	$s_bonus_date = date('Y-m-d H:i:s', strtotime($s_bonus));
	while($row = mysqli_fetch_assoc($resultx)) {
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
		
		$count = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS a FROM user_logs WHERE user_id = '$row[id]' AND log_type = 1 AND summa != 0 "));
		$row['total_buy'] = $count['a']*10;
		$count = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS a FROM user_logs WHERE user_id = '$row[id]' AND log_type = 1 AND input_date >= '$s_bonus_date' AND summa != 0 "));
		$row['week_buy'] = $count['a']*10;
		$count = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT total_amount, current_amount FROM s_bonus_log WHERE user_id = '$row[id]' "));
		$row['total_amount'] = $count['total_amount'];
		$row['current_amount'] = $count['current_amount'];
		$out[$i++] = $row;
	}
	
	echo json_encode($out);

}

else if ($_POST['data_show_f']) {

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT id,login, password, email, number, a_status, s_status, ref, city, fio, birthday FROM users WHERE id = '$_SESSION[id]' "));
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
	else $row['s_status'] = 'Партнёр';
	$ref = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login FROM users WHERE id = '$row[ref]' "));
	if ($row['ref'] == 2622) $row['ref'] = 'diamond';
	else $row['ref'] = $ref['login'];
	
	$city = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT country_id, region_id FROM city WHERE city_id = '$row[city]' "));
	$row['region'] = $city['region_id'];
	$row['country'] = $city['country_id'];
	$del = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT text FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 16 "));
	$row['del'] = $del['text'];
	echo json_encode($row);

}

else if ($_POST['change_data_f']) {
	if ( !preg_match('/^[A-z0-9]{4,30}$/', $_POST['password']) )
		message('Пароль может содеражать от 4 до 30 латинских букв и цифр');
	if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL))
		message('E-mail указан неверно');
	if ( !preg_match('/^[0-9]{10,15}$/', preg_replace("/[ ()-]/", "",$_POST['number'])) )
		message('Номер указан неверно');
	if (!$_POST['birthday']) message('Укажите дату рождения');
	if (!$_POST['city']) message('Укажите город');
	if ( !preg_match('/^[A-z ]{1,99}$/', $_POST['fio']) )
		message('ФИО может содеражать только латинские буквы');

	
	$result =  mysqli_query($CONNECT, "UPDATE users SET password = '$_POST[password]',email = '$_POST[email]', number = '$_POST[number]',country = '$_POST[country]', city = '$_POST[city]', fio = '$_POST[fio]', birthday = '$_POST[birthday]'  WHERE id = '$_SESSION[id]' ");

	if ($result) s_message('Изменения сохранены');
	else message('Произошла ошибка');
}

else if ($_POST['logs_check_f']) {
	if ($_POST['val2'] == 1) {
		$date_order = 'DESC';
	}
	else {
		$date_order = 'ASC';
	}

	if ($_POST['val'] == 0) {
		$resultx = mysqli_query($CONNECT, "SELECT *  FROM `user_logs` WHERE user_id = '$_SESSION[id]' OR text = '$_SESSION[login]' ORDER BY input_date $date_order ");
	}
	else if ($_POST['val'] == 12) {
		$resultx = mysqli_query($CONNECT, "SELECT *  FROM `user_logs` WHERE user_id = '$_SESSION[id]' AND log_type = 12 OR user_id = '$_SESSION[id]' AND log_type = 13 OR user_id = '$_SESSION[id]' AND log_type = 14  ORDER BY input_date $date_order ");
	}
	else  {
		$resultx = mysqli_query($CONNECT, "SELECT *  FROM `user_logs` WHERE user_id = '$_SESSION[id]' AND log_type = '$_POST[val]' OR text = '$_SESSION[login]' AND log_type = '$_POST[val]' ORDER BY input_date $date_order ");
	}
	
	$out = array();
	$i = 1;
	if (mysqli_num_rows($resultx)) {
		while($row = mysqli_fetch_assoc($resultx)) {

			$row['summa'] = number_format($row['summa'], 2, ',', ' ');
			if ($row['log_type'] == 1) {
				$inf = explode('.', $row['text']);
				if ($row['log_checked'] == 1) {
					$row['text'] = 'Сумма: 35 | Название: '.$inf[1].' | Состояние: Выдано';
				}
				else {
					$row['text'] = 'Сумма: '.$row['summa'].' | Карта: '.$row['text'].' | Состояние: В очереди';
				}
				$row['text'] = 'Сумма: 35 | Название: '.$inf[1];
				$row['title'] = 'Покупка продукта';
			}
			else if ($row['log_type'] == 2) {
				$row['text'] = 'Сумма: '.$row['summa'].' | От: '.$row['text'].'';
				$row['title'] = 'Начисление';
			}
			else if ($row['log_type'] == 4) {
				if ($row['log_checked'] == 1) {
					$row['text'] = 'Сумма: '.$row['summa'].' | Карта: '.$row['text'].' | Состояние: Выплачено';
				}
				else {
					$row['text'] = 'Сумма: '.$row['summa'].' | Карта: '.$row['text'].' | Состояние: В очереди';
				}
				
				$row['title'] = 'Заявка на вывод';
			}
			else if ($row['log_type'] == 11) {
				if ($row['user_id'] == $_SESSION['id']) {
					$row['text'] = 'Сумма: '.$row['summa'].' | Кому: '.$row['text'];

					$row['title'] = 'Перевод средств';
				}
				else {
					$login = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login FROM users WHERE id = '$row[user_id]' "));

					$row['text'] = 'Сумма: '.$row['summa'].' | От кого: '.$login['login'];

					$row['title'] = 'Получение средств';
				}
				
			}
			else if ($row['log_type'] == 12) {
				$row['text'] = 'Сумма: '.$row['summa'];
				$row['title'] = 'Апгрейд';
			}
			else if ($row['log_type'] == 13) {
				if ($row['text'] == 1) $row['text'] = 'Manager';
				else if ($row['text'] == 2) $row['text'] = 'Bronze';
				else if ($row['text'] == 3) $row['text'] = 'Silver';
				else if ($row['text'] == 4) $row['text'] = 'Gold Director';
				else if ($row['text'] == 5) $row['text'] = 'Emerald Director';
				else if ($row['text'] == 6) $row['text'] = 'Platinum Director';
				else if ($row['text'] == 7) $row['text'] = 'Diamond Director';
				else if ($row['text'] == 8) $row['text'] = 'Ambassador';
				else if ($row['text'] == 9) $row['text'] = 'Ambassador';
				$row['text'] = 'Поздравляем с получение статуса - '.$row['text'];
				$row['title'] = 'Статус';
			}
			else if ($row['log_type'] == 14) {
				$row['title'] = 'Подарок';
			}
			else if ($row['log_type'] == 18) {
				$row['text'] = 'Сумма: '.$row['summa'];
				$row['title'] = 'Пополнение баланса';
			}
			$row['input_date'] = date('d.m.Y',strtotime($row['input_date']));

			if ($row['log_type'] != 8 && $row['log_type'] != 7  && $row['log_type'] != 15 && $row['log_type'] != 16 && $row['log_type'] != 17) {
				$out[$i++] = $row;
			}
			else if ($row['log_type'] == 15 && $row['text'] != 0) {
				$row['title'] = 'Активация';
				$row['text'] = 'Сумма: '.$row['summa'];
				$out[$i++] = $row;
			}
			
		}
	}
	else {
		$out['no_result'] = 1;
	}
	
	echo json_encode($out);


}

else if ($_POST['withdraw_f']) {
	if ($_POST['w_sum'] < 20) message('Минимальная сумма вывода 20$');
	if ($_POST['w_aim'] == '') message('Введите номер карты');
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT balance FROM users WHERE id = '$_SESSION[id]' "));
	if ($_POST['w_sum'] > $row['balance']) message('Недостаточно средств');
	$result = mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "4", "'.$_POST['w_sum'].'", "'.$_POST['w_aim'].'", "0","'.$today.'")');
	if ($result) {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance - '$_POST[w_sum]' WHERE id = '$_SESSION[id]' ");
		$out = [
			"balance" => $row['balance'] - $_POST['w_sum'],
			"s_message" => 'Заявка отправлена',
		];
		echo json_encode($out);
	}
	else message('Произошла ошибка');
}

else if ($_POST['transfer_f']) {
	if ($_POST['t_sum'] == 0) message('Введите сумму');
	if (!mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM users WHERE login = '$_POST[t_aim]' "))) message('Пользователя с таким логином не существует');
	if ($_POST['t_aim'] == $_SESSION['login']) message('Вы указали свой логин');
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT balance FROM users WHERE id = '$_SESSION[id]' "));
	if ($_POST['t_sum'] > $row['balance']) message('Недостаточно средств');
	$result = mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "11", "'.$_POST['t_sum'].'", "'.$_POST['t_aim'].'", "0","'.$today.'")');
	if ($result) {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance - '$_POST[t_sum]' WHERE id = '$_SESSION[id]' ");
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$_POST[t_sum]' WHERE login = '$_POST[t_aim]' ");
		$out = [
			"balance" => $row['balance'] - $_POST['t_sum'],
			"s_message" => 'Перевод выполнен успешно',
		];
		echo json_encode($out);
	}
	else message('Произошла ошибка');
}


else if ($_POST['upgrade_paket_f']) {
	$val = $_POST['val'];
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login,a_status, balance, ref FROM users WHERE id = '$_SESSION[id]' "));

	if ($val == 2 && $row['a_status'] == 1) {$summa = 70;$vp = 20;}
	else if ($val == 3 && $row['a_status'] == 1) {$summa = 245;$vp = 70;}
	else if ($val == 3 && $row['a_status'] == 2) {$summa = 175;$vp = 50;}
	else message('Произошла ошибка');
	if ($row['balance'] < $summa) message('Не хватает средств');

	$result =  mysqli_query($CONNECT, "UPDATE users SET a_status = '$val'  WHERE id = '$_SESSION[id]' ");

	if ($result) {
		$result2 =  mysqli_query($CONNECT, "UPDATE users SET balance = balance - '$summa'  WHERE id = '$_SESSION[id]' ");
		if ($result2) {
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
					'id' => $_SESSION['id'],
					'vp' => $vp,
				))
			));
			$response = curl_exec($myCurl);
			curl_close($myCurl);
			mysqli_query($CONNECT, "UPDATE user_logs SET summa = summa + '$vp' WHERE user_id = '$_SESSION[id]' AND log_type = 8 ");
			mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "12", "'.$summa.'", "'.$vp.'", "0","'.$today.'")');
			s_message('Поздравляем с апгрейдом');
		}
		else {
			mysqli_query($CONNECT, "UPDATE users SET a_status = '$row[a_status]'  WHERE id = '$_SESSION[id]' ");
			message('Произошла ошибка');
		}
	}
	else message('Произошла ошибка');



}


else if ($_POST['guests_check_f']) {
	if ($_POST['val'] == 0) {
		$resultx = mysqli_query($CONNECT, "SELECT id, name, reg_time, number, involvement  FROM `guests` WHERE ref = '$_SESSION[id]' ");
	}
	else {
		$resultx = mysqli_query($CONNECT, "SELECT id, name, reg_time, number, involvement  FROM `guests` WHERE ref = '$_SESSION[id]' AND involvement = '$_POST[val]' ");
	}
	
	$out = array();
	$i = 1;
	while($row = mysqli_fetch_assoc($resultx)) {
		$row['reg_time'] = date('d.m.Y', strtotime($row['reg_time']));
		$out[$i++] = $row;
	}
	
	echo json_encode($out);

}

else if ($_POST['auto_active_check_f']) {

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT active_date FROM s_bonus_log WHERE user_id = '$_SESSION[id]' "));
	$first = date('Y-m-d', strtotime($row['active_date']));
	$second = date('Y-m-d', strtotime($today));

	if ($first > $second) echo "1";
	else echo "0";
}

else if ($_POST['send_review_f']) {
	$name = mysqli_real_escape_string ($CONNECT,$_POST['r_name'] );
	$text = mysqli_real_escape_string ($CONNECT,$_POST['r_text'] );
	if($name == '') message('Заполните поле имя'); 
	if($text == '') message('Напишите комментарий');

	$result = mysqli_query($CONNECT, 'INSERT INTO `reviews`(user_id,name,text,accepted,input_date) VALUES ("'.$_SESSION['id'].'", "'.$name.'", "'.$text.'","0", "'.$today.'")');

	if ($result) s_message('Благодарим за отзыв!');
	else message('Произошла ошибка');



}

else if ($_POST['position_change_f']) {

	$result = mysqli_query($CONNECT, "UPDATE binar_log SET position = '$_POST[val]' WHERE user_id = '$_SESSION[id]' ");

	if ($result) s_message('Позиция успешно изменена');
	else message('Произошла ошибка');


}

else if ($_POST['adress_deliv_f']) {
	$text = mysqli_real_escape_string ($CONNECT,$_POST['text'] );
	if($text == '') message('Заполните адрес');
	if ( !mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 16 ")) ) {
		$result = mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "16", "0", "'.$text.'", "0","'.$today.'")');
	}
	else {
		$result = mysqli_query($CONNECT, "UPDATE user_logs SET text = '$text' WHERE user_id = '$_SESSION[id]' AND log_type = 16 ");
	}
	

	if ($result) s_message('Успешно сохранено');
	else message('Произошла ошибка');



}

else if ($_POST['deliv_check_f']) {
	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT id,text FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 17 "));

	if ($row['id'] != 0) {
		$inf = explode('.', $row['text']);
		if ($inf[1] == 1) {
			$row['track'] = "https://parcelsapp.com/carriers/kazpost";

		} 	
		else if ($inf[1] == 2) {
			$row['track'] = "https://track24.ru/service/ems/tracking/";
		}
		else if ($inf[1] == 3) {
			$row['track'] = "https://avislogistics.kz/";
		}
		$row['tr_code'] = $inf[0];

	}
	else $row['no_result'] = 1;

	echo json_encode($row);
}

else if ($_POST['deliv_complete_f']) {
	$result = mysqli_query($CONNECT,"DELETE FROM user_logs WHERE id = '$_POST[id]' AND user_id = '$_SESSION[id]' AND log_type = 17 ");

	if ($result) echo "1";
	else echo "0";

}

else if ($_POST['b_user_search_f']) {

	$resultx = mysqli_query($CONNECT, "SELECT id, login FROM `users` WHERE login LIKE '%$_POST[aim]%' LIMIT 20 ");
	if (mysqli_num_rows($resultx)) {
		$out = array();
		$i = 1;
		while($row = mysqli_fetch_assoc($resultx)) {
			if ($row['id'] != $_SESSION['id']) {
				$w = 1;
				$sponsor = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT id FROM structure WHERE user_id = '$row[id]' "));
				$id = $sponsor['id'];
				while ($w == 1) {
					$row2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT sponsor_id, user_id FROM structure WHERE id = '$id' "));

					if ($row2['user_id'] == $_SESSION['id']) {
						$out[$i++] = $row;
						$w = 0;
					}

					if ($row2['sponsor_id'] == 0) $w = 0;

					$id = $row2['sponsor_id'];
				}
			}
		}
		if ($out) {
			echo json_encode($out);
		}
		else echo "0";
		
	}
	else {
		echo "0";
	}

}

else if ($_POST['s_user_search_f']) {

	$resultx = mysqli_query($CONNECT, "SELECT id, login, ref FROM `users` WHERE login LIKE '%$_POST[aim]%' LIMIT 20 ");
	if (mysqli_num_rows($resultx)) {
		$out = array();
		$i = 1;
		while($row = mysqli_fetch_assoc($resultx)) {
			if ($row['id'] != $_SESSION['id']) {
				$w = 1;
				$id = $row['ref'];
				while ($w == 1) {
					$row2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT id, ref FROM users WHERE id = '$id' "));

					if ($row2['id'] == $_SESSION['id']) {
						$out[$i++] = $row;
						$w = 0;
					}

					if ($row2['ref'] == 0) $w = 0;

					$id = $row2['ref'];
				}
			}
		}
		if ($out) {
			echo json_encode($out);
		}
		else echo "0";
		
	}
	else {
		echo "0";
	}

}

else if ($_POST['check_login_f']) {

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT,"SELECT fio FROM users WHERE login = '$_POST[login]' "));
	if ($row['fio'] != '') {
		$out = [
			"result" => 1,
			"fio" => $row['fio'],
		];
	}
	else {
		$out['result'] = 0;
	}
	echo json_encode($out);
}


$zp_dt = date('Y-m');

$zp_dt = date('Y-m-d H:i:s', strtotime($zp_dt));

$zp_sum = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT SUM(summa) AS summa FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 2 AND input_date >= '$zp_dt' "));

$count_zp = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 15 AND input_date >= '$zp_dt' "));


$ac_dt = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT active_date FROM s_bonus_log WHERE user_id = '$_SESSION[id]' "));
$first_ac = date('Y-m', strtotime($ac_dt['active_date']));
$second_ac = date('Y-m', strtotime($today));



if ($count_zp['count'] == 0) {
	if ($first_ac > $second_ac) {
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "15", "35", "0", "0","'.$today.'")');
	}
	else if ($zp_sum['summa'] >= 150) {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance - 35 WHERE id = '$_SESSION[id]' ");
		mysqli_query($CONNECT, "UPDATE users SET point = point + 10 WHERE id = '$_SESSION[id]' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "15", "35", "10 | 150", "0","'.$today.'")');
	}
	$count_zp = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 15 AND input_date >= '$zp_dt' "));

}
if ($count_zp['count'] == 1 && $zp_sum['summa'] >= 375) {
	$count_pr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 1 AND input_date >= '$zp_dt' AND summa > 1 "));
	if ($count_pr['count'] >= 2) {
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "15", "35", "0", "0","'.$today.'")');
	}
	else if ($count_pr['count'] >= 1 && mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 15 AND input_date >= '$zp_dt' AND text = '10 | 150' "))) {
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "15", "35", "0", "0","'.$today.'")');
	}
	else {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance - 35 WHERE id = '$_SESSION[id]' ");
		mysqli_query($CONNECT, "UPDATE users SET point = point + 10 WHERE id = '$_SESSION[id]' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_SESSION['id'].'", "15", "35", "10 | 375", "0","'.$today.'")');
	}
	
}



?>