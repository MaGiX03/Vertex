<?php 
ini_set('max_execution_time', 3600);

if ($_POST['key'] != 'key') exit('Error');

$CONNECT = mysqli_connect('localhost', 'vertex', 'pass', 'vertex');

if ( !$CONNECT ) exit('MySQL error');

mysqli_set_charset($CONNECT, "utf8");

date_default_timezone_set('Asia/Almaty');

$reg_day = date('Y-m-d H:i:s');

$today = date('Y-m-d');

$s_date = $_POST['s_date'];

if ($_POST['val'] == 1) {
	$active_date = date('Y-m-d', strtotime($today.'+ 1 months'));
	mysqli_query($CONNECT, "UPDATE s_bonus_log SET active_date = '$active_date' WHERE user_id = '$_POST[id]' ");
	echo s_bonus($_POST['id']);
} 
else echo s_bonus_month($_POST['id']);


function s_bonus( $id ) {
	global $CONNECT;
	global $reg_day;

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT ref, s_status FROM users WHERE id = '$id' "));
	if ($row['ref'] == 0) return '1';
	$ref = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT s_status FROM users WHERE id = '$row[ref]' "));
	$perc1 = 0;
	if ($row['s_status'] == 1) $perc1 = 0.05;
	else if ($row['s_status'] == 2) $perc1 = 0.1;
	else if ($row['s_status'] == 3) $perc1 = 0.15;
	else if ($row['s_status'] == 4) $perc1 = 0.2;
	else if ($row['s_status'] == 5) $perc1 = 0.25;
	else if ($row['s_status'] == 6) $perc1 = 0.3;
	else if ($row['s_status'] == 7) $perc1 = 0.35;
	else if ($row['s_status'] == 8) $perc1 = 0.4;
	else if ($row['s_status'] == 9) $perc1 = 0.4;

	$perc2 = 0;
	if ($ref['s_status'] == 1) $perc2 = 0.05;
	else if ($ref['s_status'] == 2) $perc2 = 0.1;
	else if ($ref['s_status'] == 3) $perc2 = 0.15;
	else if ($ref['s_status'] == 4) $perc2 = 0.2;
	else if ($ref['s_status'] == 5) $perc2 = 0.25;
	else if ($ref['s_status'] == 6) $perc2 = 0.3;
	else if ($ref['s_status'] == 7) $perc2 = 0.35;
	else if ($ref['s_status'] == 8) $perc2 = 0.4;
	else if ($ref['s_status'] == 9) $perc2 = 0.4;
	$perc = $perc2 - $perc1;
	if ($perc < 0) $perc = 0;
	$dollar = 25*$perc;

	mysqli_query($CONNECT, "UPDATE s_bonus_log SET current_amount = current_amount + 10, money = money + '$dollar' WHERE user_id = '$row[ref]' ");
	return s_bonus( $row['ref'] );
	
}

function s_bonus_month( $id ) {
	global $CONNECT;
	global $reg_day;
	global $s_date;

	$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT current_amount, total_amount, money, active_date FROM s_bonus_log WHERE user_id = '$id' "));
	if ($row == '') {
	    return '1';
	}

	mysqli_query($CONNECT, "UPDATE s_bonus_log SET total_amount = total_amount + '$row[current_amount]',current_amount = 0, money = 0 WHERE user_id = '$id' ");
	if ($row['active_date'] >= $s_date) {
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$row[money]' WHERE id = '$id' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "2", "'.$row['money'].'", "Структурный бонус", "0","'.$reg_day.'")');
	}
	
	if ($id == 1) {
		$dollar = $row['money']*0.05;
		mysqli_query($CONNECT, "UPDATE users SET balance = balance + '$dollar' WHERE s_status = 9 ");
	}
	
	$total = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT total_amount FROM s_bonus_log WHERE user_id = '$id' "));
	$user = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT s_status, ref FROM users WHERE id = '$id' "));
	$status = 0;
	if ($total['total_amount'] >= 200) $status = 1;
	if ($total['total_amount'] >= 500) $status = 2;
	if ($total['total_amount'] >= 1200) $status = 3;
	if ($total['total_amount'] >= 3000) $status = 4;
	if ($total['total_amount'] >= 8000) $status = 5;
	if ($total['total_amount'] >= 20000) $status = 6;
	if ($total['total_amount'] >= 50000) $status = 7;
	if ($total['total_amount'] >= 100000) $status = 8;
	if ($total['total_amount'] >= 200000) $status = 9;
	if ($status > $user['s_status']) {
		mysqli_query($CONNECT, "UPDATE users SET s_status = '$status' WHERE id = '$id' ");
		mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$id.'", "13", "0", "'.$status.'", "0","'.$reg_day.'")');

		if ($status == 4) {
			$count = mysqli_fetch_assoc(mysqli_num_rows($CONNECT, "SELECT COUNT(id) as count FROM users WHERE ref = '$user[ref]' AND s_status = 4 "));
			if ($count['count'] == 2) {
				mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$user['ref'].'", "14", "0", "Поздравляем! Вы получили тур-путёвку на двоих", "0","'.$reg_day.'")');
			}
			
		}
		else if ($status == 6) {
			$count = mysqli_fetch_assoc(mysqli_num_rows($CONNECT, "SELECT COUNT(id) as count FROM users WHERE ref = '$user[ref]' AND s_status = 6 "));
			if ($count['count'] == 2) {
				mysqli_query($CONNECT, 'INSERT INTO `user_logs`(user_id,log_type,summa,text,log_checked,input_date) VALUES ("'.$user['ref'].'", "14", "0", "Поздравляем! Вы получили автомобиль", "0","'.$reg_day.'")');
			}
			
		}
		
	} 
	return '1';

}