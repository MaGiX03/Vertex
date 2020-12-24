<?php
ini_set('max_execution_time', 7200);

if ($_POST['key'] != '*key*') exit('Error');

$CONNECT = mysqli_connect('localhost', 'vertex', 'pass', 'vertex');

if ( !$CONNECT ) exit('MySQL error');

mysqli_set_charset($CONNECT, "utf8");

date_default_timezone_set('Asia/Almaty');

$reg_day = date('Y-m-d H:i:s');

$today = date('Y-m-d');


if ($_POST['val'] == 1) {
	$a_status = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT a_status FROM users WHERE id = '$_POST[id]' "));
	if ($a_status['a_status'] == 1) $vp = 10;
	else if ($a_status['a_status'] == 2) $vp = 30;
	else if ($a_status['a_status'] == 3) $vp = 80;

	echo binar($_POST['id'], $vp);
}
else if ($_POST['val'] == 2) {
	echo binar_ned($_POST['id']);
}
else if ($_POST['val'] == 3) {

	echo binar($_POST['id'], $_POST['vp']);

}


function binar( $id, $vp ){
	global $CONNECT;
	global $reg_day;


	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT sponsor_id FROM structure WHERE user_id = '$id' "));
	if ($row['sponsor_id'] == 0) return '1';
	$ref = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT user_id, first_follower, second_follower, sponsor_id FROM structure WHERE id = '$row[sponsor_id]' "));
	

	if ($ref['first_follower'] == $id) {
		mysqli_query($CONNECT, "UPDATE binar_log SET l_vp = l_vp + '$vp' WHERE user_id = '$ref[user_id]' ");

	}
	else if ($ref['second_follower'] == $id) {
		mysqli_query($CONNECT, "UPDATE binar_log SET r_vp = r_vp + '$vp' WHERE user_id = '$ref[user_id]' ");
	}

	if ($vp == 10) {
		mysqli_query($CONNECT, "UPDATE structure SET start = start + 1 WHERE user_id = '$ref[user_id]' ");
	}
	else if ($vp == 30) {
		mysqli_query($CONNECT, "UPDATE structure SET business = business + 1 WHERE user_id = '$ref[user_id]' ");
	}
	else if ($vp == 80) {
		mysqli_query($CONNECT, "UPDATE structure SET premium = premium + 1 WHERE user_id = '$ref[user_id]' ");
	}
	else if ($vp == 20) {
		mysqli_query($CONNECT, "UPDATE structure SET start = start - 1, business = business + 1 WHERE user_id = '$ref[user_id]' ");
	}
	else if ($vp == 70) {
		mysqli_query($CONNECT, "UPDATE structure SET start = start - 1, premium = premium + 1 WHERE user_id = '$ref[user_id]' ");
	}
	else if ($vp == 50) {
		mysqli_query($CONNECT, "UPDATE structure SET business = business - 1, premium = premium + 1 WHERE user_id = '$ref[user_id]' ");
	}

	return binar( $ref['user_id'], $vp );
	
}

function binar_ned( $id ) {
	global $CONNECT;
	global $reg_day;
	global $today;

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT b.r_vp, b.l_vp, b.direction, u.a_status, u.login, u.ref FROM binar_log b INNER JOIN users u ON b.user_id = u.id WHERE u.id = '$id' "));
	if ($row == '') {
		return '1';
		
	}
	
	if ($row['l_vp'] > $row['r_vp']) {
		if ($row['direction'] == 3) {
			if ($row['a_status'] == 1) {$dollar = $row['r_vp'] * 2.5 * 0.1; $dollar2 = 500;}
			if ($row['a_status'] == 2) {$dollar = $row['r_vp'] * 2.5 * 0.12; $dollar2 = 1000;}
			if ($row['a_status'] == 3) {$dollar = $row['r_vp'] * 2.5 * 0.15; $dollar2 = 2500;}
			if ($dollar > $dollar2) $dollar = $dollar2;
			
			mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar' WHERE id = '$id' ");
			mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "2", "'.$dollar.'", "Бинарный бонус", "0","'.$reg_day.'")');
			if ($dollar != 0) {
				matching_bonus($row['ref'], $dollar*0.1, $row['login']);
			}
			
		}
		
		$log_vp = $row['l_vp'] - $row['r_vp'];
		mysqli_query($CONNECT, "UPDATE binar_log SET l_vp = '$log_vp', r_vp = 0, left_vp = left_vp + '$row[r_vp]', right_vp = right_vp + '$row[r_vp]' WHERE user_id = '$id' ");
	}
	else if ($row['l_vp'] < $row['r_vp']) {
		if ($row['direction'] == 3) {
			if ($row['a_status'] == 1) {$dollar = $row['l_vp'] * 2.5 * 0.1; $dollar2 = 500;}
			if ($row['a_status'] == 2) {$dollar = $row['l_vp'] * 2.5 * 0.12; $dollar2 = 1000;}
			if ($row['a_status'] == 3) {$dollar = $row['l_vp'] * 2.5 * 0.15; $dollar2 = 2500;}
			if ($dollar > $dollar2) $dollar = $dollar2;
			
			mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar' WHERE id = '$id' ");
			mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "2", "'.$dollar.'", "Бинарный бонус", "0","'.$reg_day.'")');
			if ($dollar != 0) {
				matching_bonus($row['ref'], $dollar*0.1, $row['login']);
			}
			
		}

		$log_vp = $row['r_vp'] - $row['l_vp'];
		mysqli_query($CONNECT, "UPDATE binar_log SET l_vp = 0, r_vp = '$log_vp', left_vp = left_vp + '$row[l_vp]', right_vp = right_vp + '$row[l_vp]' WHERE user_id = '$id' ");
	}
	else {
		if ($row['direction'] == 3) {
			if ($row['a_status'] == 1) {$dollar = $row['l_vp'] * 2.5 * 0.1; $dollar2 = 500;}
			if ($row['a_status'] == 2) {$dollar = $row['l_vp'] * 2.5 * 0.12; $dollar2 = 1000;}
			if ($row['a_status'] == 3) {$dollar = $row['l_vp'] * 2.5 * 0.15; $dollar2 = 2500;}
			if ($dollar > $dollar2) $dollar = $dollar2;
			
			mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar' WHERE id = '$id' ");
			mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "2", "'.$dollar.'", "Бинарный бонус", "0","'.$reg_day.'")');
			if ($dollar != 0) {
				matching_bonus($row['ref'], $dollar*0.1, $row['login']);
			}
			
		}

		mysqli_query($CONNECT, "UPDATE binar_log SET l_vp = 0, r_vp = 0, left_vp = left_vp + '$row[l_vp]', right_vp = right_vp + '$row[l_vp]' WHERE user_id = '$id' ");
	}
	
	return '1';
}


function matching_bonus( $id, $dollar, $login ) {
	global $CONNECT;
	global $reg_day;

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT u.ref, u.a_status, b.direction FROM users u INNER JOIN binar_log b ON u.id = b.user_id WHERE u.id = '$id' "));
	if ($row['a_status'] >= 1 && $row['direction'] == 3) {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar' WHERE id = '$id' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "2", "'.$dollar.'", "Матчинг бонус (1 уровень) - '.$login.'", "0","'.$reg_day.'")');
	}
	$row2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT u.ref, u.a_status, b.direction FROM users u INNER JOIN binar_log b ON u.id = b.user_id WHERE u.id = '$row[ref]' "));
	if ($row2['a_status'] >= 1 && $row2['direction'] == 3) {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar' WHERE id = '$row[ref]' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$row['ref'].'", "2", "'.$dollar.'", "Матчинг бонус (2 уровень) - '.$login.'", "0","'.$reg_day.'")');
	}
	$row3 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT u.ref, u.a_status, b.direction FROM users u INNER JOIN binar_log b ON u.id = b.user_id WHERE u.id = '$row2[ref]' "));
	if ($row3['a_status'] >= 2 && $row3['direction'] == 3) {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar' WHERE id = '$row2[ref]' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$row2['ref'].'", "2", "'.$dollar.'", "Матчинг бонус (3 уровень) - '.$login.'", "0","'.$reg_day.'")');
	}
	$row4 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT u.a_status, b.direction FROM users u INNER JOIN binar_log b ON u.id = b.user_id WHERE u.id = '$row3[ref]' "));
	if ($row4['a_status'] >= 3 && $row4['direction'] == 3) {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar' WHERE id = '$row3[ref]' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$row3['ref'].'", "2", "'.$dollar.'", "Матчинг бонус (4 уровень) - '.$login.'", "0","'.$reg_day.'")');
	}
}

?>