<?php 

ini_set('max_execution_time', 7200);

$CONNECT = mysqli_connect('localhost', 'vertex', 'pass', 'vertex');

if ( !$CONNECT ) exit('MySQL error');

mysqli_set_charset($CONNECT, "utf8");

date_default_timezone_set('Asia/Almaty');

$today = date('Y-m-d');

$binar = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT s_value, change_date FROM settings WHERE s_name = 'binar' "));

if ($binar['change_date'] > $today) {
	exit('1');
}

$last_id = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT MAX(id) AS id FROM users"));

$i = $binar['s_value'];
$max = $i + 2000;
while ($i < $max) {

	if ($i > $last_id['id']) {
		$new_date = date('Y-m-d', strtotime($binar['change_date'].'+ 7 days'));
		mysqli_query($CONNECT,"UPDATE settings SET s_value = 1, change_date = '$new_date' WHERE s_name = 'binar' ");
		exit('1');
	}

	if (!mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM user_logs WHERE log_type = 2 AND user_id = '$i' AND input_date >= '$binar[change_date]' AND text LIKE '%Бинарный бонус%'"))) {
		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://vertexmax.com/event/binar.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query(array( 
				'key' => '*key*',
				'val' => 2,
				'id' => $i,
			))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);
	}


	$i++;
}
mysqli_query($CONNECT,"UPDATE settings SET s_value = '$i' WHERE s_name = 'binar' ");


?>