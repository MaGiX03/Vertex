<?php 

if ($_POST['users_check_f']) {
	if ($_POST['text'] == "") exit('0');
	$resultx = mysqli_query($CONNECT, "SELECT id, login, fio, number FROM `users` WHERE login LIKE '%$_POST[text]%' AND a_status != 0 LIMIT 20 ");
	if (mysqli_num_rows($resultx)) {
		$out = array();
		$i = 1;
		while($row = mysqli_fetch_assoc($resultx)) {
			$deliv = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT text FROM user_logs WHERE user_id = '$row[id]' AND log_type = 16 "));
			$row['deliv'] = $deliv['text'];
			$out[$i++] = $row;
		}

		echo json_encode($out);
	}
	else {
		echo "0";
	}


}

else if ($_POST['insert_logist_f']) {

	if ($_POST['text'] == "") message('Заполните номер заказа');
	mysqli_query($CONNECT, "DELETE FROM user_logs WHERE user_id = '$_POST[id]' AND log_type = 17 ");
	$result = mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$_POST['id'].'", "17", "0", "'.$_POST['text'].'.'.$_POST['service'].'", "0","'.$today.'")');
	if ($result) s_message('Успешно');
	else message('Произошла ошибка');


}

else if ($_POST['product_count_f']) {

	if ($_POST['val'] == 1) {
		$first_date = $_POST['date'];
		$second_date = date('Y-m-d', strtotime($_POST['date'].'+ 1 days'));
	}
	else {
		$first_date = date('Y-m-d', strtotime('2000-01-01'));
		$second_date = date('Y-m-d', strtotime($today.'+ 1 days'));
	}
	
	
	
	if ($_POST['text'] != '') {
		$resultx = mysqli_query($CONNECT, "SELECT COUNT(l.id) AS count FROM `user_logs` l INNER JOIN users u ON l.user_id = u.id WHERE u.login LIKE '%$_POST[text]%' AND l.log_type = 1 AND l.log_checked = '$_POST[val]' AND l.input_date >= '$first_date' AND l.input_date < '$second_date' ORDER BY l.input_date DESC ");
	}
	else {
		$resultx = mysqli_query($CONNECT, "SELECT COUNT(l.id) AS count FROM `user_logs` l INNER JOIN users u ON l.user_id = u.id WHERE l.log_type = 1 AND l.log_checked = '$_POST[val]' AND l.input_date >= '$first_date' AND l.input_date < '$second_date' ORDER BY l.input_date DESC ");
	}

	$row = mysqli_fetch_assoc($resultx);
	echo $row['count'];

}

else if ($_POST['product_check_f']) {

	if ($_POST['val'] == 1) {
		$first_date = $_POST['date'];
		$second_date = date('Y-m-d', strtotime($_POST['date'].'+ 1 days'));
	}
	else {
		$first_date = date('Y-m-d', strtotime('2000-01-01'));
		$second_date = date('Y-m-d', strtotime($today.'+ 1 days'));
	}
	
	if ($_POST['text'] != '') {
		$resultx = mysqli_query($CONNECT, "SELECT u.login, l.user_id, l.input_date, l.text, l.id  FROM `user_logs` l INNER JOIN users u ON l.user_id = u.id WHERE u.login LIKE '%$_POST[text]%' AND l.log_type = 1 AND l.log_checked = '$_POST[val]' AND l.input_date >= '$first_date' AND l.input_date < '$second_date' ORDER BY l.input_date DESC LIMIT 27 OFFSET $_POST[start] ");
	}
	else {
		$resultx = mysqli_query($CONNECT, "SELECT u.login, l.user_id, l.input_date, l.text, l.id  FROM `user_logs` l INNER JOIN users u ON l.user_id = u.id WHERE l.log_type = 1 AND l.log_checked = '$_POST[val]' AND l.input_date >= '$first_date' AND l.input_date < '$second_date' ORDER BY l.input_date DESC LIMIT 27 OFFSET $_POST[start] ");
	}
	

	$out = array();
	$i = 1;
	if (mysqli_num_rows($resultx)) {
		while($row = mysqli_fetch_assoc($resultx)) {
			$del = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT text FROM user_logs WHERE user_id = '$row[user_id]' AND log_type = 16 "));
			$inf = explode('.', $row['text']);
			$row['text'] = 'Продукт: '.$inf[1].' | Адрес доставки: '.$del['text'].'';

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

else if ($_POST['product_checked_f']) {
	$id = $_POST['id'];
	$val = $_POST['val'];
	if ($val == 1) {
		$result = mysqli_query($CONNECT, "UPDATE user_logs SET log_checked = 1 WHERE id = '$id' ");
	}
	else if ($val == 2) {
		$result = mysqli_query($CONNECT, "DELETE FROM user_logs WHERE id = '$id' ");

	}
	

	if ($result) echo "1";
	else echo "0";


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


?>