<?php

$CONNECT = mysqli_connect('localhost', 'vertex', 'pass', 'vertex');

if ( !$CONNECT ) exit('MySQL error');

mysqli_set_charset($CONNECT, "utf8");

date_default_timezone_set('Asia/Almaty');

$today = date('Y-m-d H:i:s');
$input = json_decode(file_get_contents("php://input"), true);

if ($input['reference_id'] == '' || $input['secret_key'] == '' || $input['transaction_id'] == '') exit('Error');

$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT user_id, product_id, status, amount FROM orders WHERE reference_id = '$input[reference_id]' "));

if ($row['status'] == 1) {

	$out['status'] = 1;
	exit(json_encode($out));
}

mysqli_query($CONNECT, "UPDATE orders SET status = '$input[status]' WHERE reference_id = '$input[reference_id]' ");

$inf = explode('.', $row['product_id']);

if ($input['status'] == 1) {
	if ($inf[0] == 1) {
		$tovar = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT p_name FROM products WHERE id = '$inf[1]' "));
		mysqli_query($CONNECT, "UPDATE users SET point = point + 1 WHERE id = '$row[user_id]' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$row['user_id'].'", "1", "35", "'.$inf[1].'.'.$tovar['p_name'].'", "0","'.$today.'")');

		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://vertexmax.com/event/structure_bonus.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query(array( 
				'key' => '*key*',
				'id' => $row['user_id'],
				'val' => 1,
			))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);

	}
	else if ($inf[0] == 2) {

		$result = mysqli_query($CONNECT, "UPDATE users SET a_status = '$inf[1]' WHERE id = '$row[user_id]' ");
		mysqli_query($CONNECT, "UPDATE guests SET involvement = 4 WHERE user_id = '$row[user_id]' ");

		if ($result) {
			$row2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT text FROM user_logs WHERE user_id = '$row[user_id]' AND log_type = 7  "));
			if ($row2 == '') $speaker = 0;
			else $speaker = $row2['text'];
			$myCurl = curl_init();
			curl_setopt_array($myCurl, array(
				CURLOPT_URL => 'https://vertexmax.com/event/structure.php',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => http_build_query(array( 
					'key' => '*key*',
					'Uid' => $row['user_id'],
					'a_status' => $inf[1],
					'speaker' => $speaker,
				))
			));
			$response = curl_exec($myCurl);
			curl_close($myCurl);
		}

	}
	else if ($inf[0] == 3) {
		$user = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login,a_status, ref FROM users WHERE id = '$row[user_id]' "));

		if ($inf[1] == 2 && $user['a_status'] == 1) {$summa = 70;$vp = 20;}
		else if ($inf[1] == 3 && $user['a_status'] == 1) {$summa = 245;$vp = 70;}
		else if ($inf[1] == 3 && $user['a_status'] == 2) {$summa = 175;$vp = 50;}

		$result =  mysqli_query($CONNECT, "UPDATE users SET a_status = '$inf[1]'  WHERE id = '$row[user_id]' ");

		if ($result) {
			$ref = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT a_status FROM users WHERE id = '$user[ref]' "));
			if ($ref['a_status'] == 1) $dollar1 = $summa*0.1;
			if ($ref['a_status'] == 2) $dollar1 = $summa*0.15;
			if ($ref['a_status'] == 3) $dollar1 = $summa*0.2;
			mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar1' WHERE id = '$user[ref]' ");
			mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$user['ref'].'", "2", "'.$dollar1.'", "Реферальный бонус с апгрейда - '.$user['login'].'", "0","'.$today.'")');

			$myCurl = curl_init();
			curl_setopt_array($myCurl, array(
				CURLOPT_URL => 'https://vertexmax.com/event/binar.php',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => http_build_query(array( 
					'key' => '*key*',
					'val' => 3,
					'id' => $row['user_id'],
					'vp' => $vp,
				))
			));
			$response = curl_exec($myCurl);
			curl_close($myCurl);
			mysqli_query($CONNECT, "UPDATE user_logs SET summa = summa + '$vp' WHERE user_id = '$row[user_id]' AND log_type = 8 ");
			mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$row['user_id'].'", "12", "'.$summa.'", "'.$vp.'", "0","'.$today.'")');
		}
	}
	else if ($inf[0] == 4) {
		$summa = $row['amount']/400;
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$row['user_id'].'", "18", "'.$summa.'", "Пополнение", "0","'.$today.'")');
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$summa' WHERE id = '$row[user_id]' ");
	}
	else {
		mysqli_query($CONNECT, 'INSERT INTO `test`(text, input_date) VALUES ("Error 2 | '.$input['reference_id'].' | '.$input['status'].' | '.$input['secret_key'].'", "'.$today.'")');
	}

}

$out['status'] = $input['status'];

echo json_encode($out);



