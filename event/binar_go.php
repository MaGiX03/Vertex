<?php 

ini_set('max_execution_time', 7200);

/*if ($_POST['key'] != 'xgnp3PZVyw74Efj') exit('Error');*/

$CONNECT = mysqli_connect('localhost', 'vertex', '6T6y4W0r', 'vertex');

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
				'key' => 'xgnp3PZVyw74Efj',
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








/*$test = new SimpleXMLElement($_POST['pg_xml']);

echo $test->pg_amount;*/

/*$CONNECT = mysqli_connect('srv-pleskdb50.ps.kz:3306', 'vertexma_x', 'KNDtd9z42jTNYe7', 'vertexma_main');

if ( !$CONNECT ) exit('MySQL error');


mysqli_query($CONNECT, "INSERT INTO `s_bonus_log`(user_id,total_amount,current_amount, money, active_date) VALUES ('$id', 0, 0, 0, '$active_date')");*/

?>