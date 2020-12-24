<?php

if ($_POST['reference_id'] == '') exit('Error');

$CONNECT = mysqli_connect('localhost', 'vertex', '6T6y4W0r', 'vertex');

if ( !$CONNECT ) exit('MySQL error');

mysqli_set_charset($CONNECT, "utf8");

date_default_timezone_set('Asia/Almaty');

$today = date('Y-m-d H:i:s');


$result = mysqli_query($CONNECT, 'INSERT INTO `orders`(reference_id,user_id,product_id,input_date,amount,status) VALUES ("'.$_POST['reference_id'].'", "'.$_POST['user_id'].'", "'.$_POST['product_id'].'", "'.$today.'","'.$_POST['amount'].'", "0")');

if ($result) echo "1";
else echo "0";

?>
