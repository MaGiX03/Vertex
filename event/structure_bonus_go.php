<?php 

ini_set('max_execution_time', 7200);

/*if ($_POST['key'] != 'xgnp3PZVyw74Efj') exit('Error');*/

$CONNECT = mysqli_connect('localhost', 'vertex', '6T6y4W0r', 'vertex');

if ( !$CONNECT ) exit('MySQL error');

mysqli_set_charset($CONNECT, "utf8");

date_default_timezone_set('Asia/Almaty');

$today = date('Y-m-d');

$structure = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT s_value, change_date FROM settings WHERE s_name = 's_bonus' "));

if ($structure['change_date'] > $today) {
	exit('1');
}

$last_id = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT MAX(id) AS id FROM users"));

$i = $structure['s_value'];
$max = $i + 2000;
while ($i < $max) {

	if ($i > $last_id['id']) {
		$new_date = date('Y-m-d', strtotime($structure['change_date'].'+ 1 months'));
		mysqli_query($CONNECT,"UPDATE settings SET s_value = 1, change_date = '$new_date' WHERE s_name = 's_bonus' ");
		exit('1');
	}

	if (!mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM user_logs WHERE log_type = 2 AND user_id = '$i' AND input_date >= '$structure[change_date]' AND text LIKE '%Структурный бонус%'"))) {
		$myCurl = curl_init();
	curl_setopt_array($myCurl, array(
		CURLOPT_URL => 'https://vertexmax.com/event/structure_bonus.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => http_build_query(array( 
			'key' => 'xgnp3PZVyw74Efj',
			'id' => $i,
			'val' => 2,
			's_date' => $structure['change_date'],
		))
	));
	$response = curl_exec($myCurl);
	curl_close($myCurl);
	}


	$i++;
}
mysqli_query($CONNECT,"UPDATE settings SET s_value = '$i' WHERE s_name = 's_bonus' ");





?>