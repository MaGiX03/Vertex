<?

if ( is_numeric($_GET['auto']) ) {

	setcookie('auto', $_GET['auto'], strtotime('+1 week') );

	include 'all/avtovoronka.php';

}

if ( is_numeric($_GET['ref']) ) {

	setcookie('ref', $_GET['ref'], strtotime('+1 week') );

	header('location: /');

}


if ( $_SERVER['REQUEST_URI'] == '/' ) $page = 'home';

else {

	$page = substr($_SERVER['REQUEST_URI'], 1);
	if ( !preg_match('/^[A-z0-9?=-]{3,15}$/', $page) ) not_found();
}

$CONNECT = mysqli_connect('localhost', 'vertex', '6T6y4W0r', 'vertex');

if ( !$CONNECT ) exit('MySQL error');

mysqli_set_charset($CONNECT, "utf8");

session_start();

date_default_timezone_set('Asia/Almaty');

$today = date('Y-m-d H:i:s');


for($i=0; $i<strlen($page); $i++)
{
	is_numeric($page[$i]) ? $url_number .= $page[$i] : $url_string .= $page[$i];
}

$page = $url_string;

if ( file_exists('all/'.$page.'.php') ) include 'all/'.$page.'.php';

else if ( $_SESSION['admin'] and file_exists('admin/'.$page.'.php') ) include 'admin/'.$page.'.php';

else if ( $_SESSION['logist'] and file_exists('logist/'.$page.'.php') ) include 'logist/'.$page.'.php';

else if ( $_SESSION['id'] and $_SESSION['login'] and $_SESSION['a_status'] == 0 and file_exists('auth/'.$page.'.php') and $page != 'activation' ) header('location: activation');

else if ( $_SESSION['id'] and file_exists('auth/'.$page.'.php') ) include 'auth/'.$page.'.php';

else if ( !$_SESSION['id'] and file_exists('auth/'.$page.'.php') ) header('location: /');

else if ( !$_SESSION['id'] and file_exists('guest/'.$page.'.php') ) include 'guest/'.$page.'.php';

else not_found();


function not_found() {
	/*include 'all/not_found.php';*/
	header('location: /');
}

function login_valid() {
	if ( $_POST['reg_login']=="")
		message('Заполните поле логин');
	else if ( !preg_match('/^[A-z0-9]{1,30}$/u', $_POST['reg_login']) )
		message('Логин может содеражать только латинские буквы и цифры');
	else if ( $_POST['ref_login']=="")
		message('Заполните поле логин спонсора');
	else if ( $_POST['city']=="")
		message('Заполните поле город');
	else if ( $_POST['fio']=="")
		message('Заполните поле ФИО');
	else if ( !preg_match('/^[A-z ]{1,99}$/u', $_POST['fio']) )
		message('ФИО может содеражать только латинские буквы');
	else if ( $_POST['birthday']=="")
		message('Укажите дату рождения');
	global $CONNECT;
	$_POST['reg_login'] = mysqli_real_escape_string ($CONNECT,$_POST['reg_login'] );
	$_POST['ref_login'] = mysqli_real_escape_string ($CONNECT,$_POST['ref_login'] );
	$_POST['city'] = mysqli_real_escape_string ($CONNECT,$_POST['city'] );
	$_POST['fio'] = mysqli_real_escape_string ($CONNECT,$_POST['fio'] );
	$_POST['birthday'] = mysqli_real_escape_string ($CONNECT,$_POST['birthday'] );
}


function email_valid() {
	if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL))
		message('E-mail указан неверно');
}



function password_valid() {
	if ( !preg_match('/^[A-z0-9]{4,30}$/', $_POST['reg_password']) )
		message('Пароль может содеражать от 4 до 30 латинских букв и цифр');

	if ($_POST['reg_password_check'] != $_POST['reg_password'])
		message('Пароли не совпадают');
	
}

function number_valid() {
	if ( !preg_match('/^[0-9]{10,15}$/', preg_replace("/[ ()-]/", "",$_POST['number'])) ){
		message('Номер указан неверно');
	}
	
}

function notification( $text ) {
	echo ('{ "message" : "'.$text.'" }');
}

function message( $text ) {
	exit('{ "message" : "'.$text.'" }');
}

function s_message( $text ) {
	exit('{ "s_message" : "'.$text.'" }');
}

function error_message( $text ) {
	exit('{ "error_message" : "'.$text.'" }');
}


function go( $url ) {
	exit('{ "go" : "'.$url.'"}');
}






function top( $title ) {
	global $page;
	if ($_SESSION['id'] && $_SESSION['login']) { 
		if ($page == 'binar') $binar = 'active';
		if ($page == 'finance') $finance = 'active';
		if ($page == 'products') $product = 'active';
		if ($page == 'linear') $linear = 'active';
		if ($page == 'profil') $profil = 'active';
		if ($page == 'voronka_menu') $voronka_menu = 'active';
		if ($page == 'logs') $logs = 'active';
		if ($page == 'review') $review = 'active';
		$first_link = '
                      <ul class="rd-navbar-nav">
                      <li class="rd-nav-item '.$profil.'"><a class="rd-nav-link" href="profil">Профиль</a></li>
                        <li class="rd-nav-item '.$binar.'"><a class="rd-nav-link" href="binar">Бинарная структура</a></li>
                        <li class="rd-nav-item '.$linear.'"><a class="rd-nav-link" href="linear">Рефералы</a></li>
                        <li class="rd-nav-item '.$finance.'"><a class="rd-nav-link" href="finance">Баланс</a></li>
                        <li class="rd-nav-item '.$product.'"><a class="rd-nav-link" href="products">Продукты</a></li>
						<li class="rd-nav-item '.$voronka_menu.'"><a class="rd-nav-link" href="voronka_menu">Автоворонка</a></li>
                        <li class="rd-nav-item '.$logs.'"><a class="rd-nav-link" href="logs">История</a></li>
                        <li class="rd-nav-item '.$review.'"><a class="rd-nav-link" href="review">Отзыв</a></li>
                        
                      </ul>
                      <div class="rd-navbar-share fl-bigmug-line-right144" data-rd-navbar-toggle=".rd-navbar-share-list2">
		<ul class="list-inline rd-navbar-share-list rd-navbar-share-list2">
                          <li class="rd-navbar-share-list-item"><a class="icon" href="logout">Выйти</a></li>
                        </ul>
                      </div>';
	}
	else if ($_SESSION['admin']) {
		if ($page == 'a_stats') $a_stats = 'active';
		if ($page == 'a_users') $a_users = 'active';
		if ($page == 'a_withdrawal') $a_withdrawal = 'active';
		if ($page == 'a_product') $a_product = 'active';
		if ($page == 'a_activation') $a_activation = 'active';
		if ($page == 'a_reviews') $a_reviews = 'active';
		if ($page == 'a_offices') $a_offices = 'active';
		$first_link = '
                      <ul class="rd-navbar-nav">
                        <li class="rd-nav-item '.$a_stats.'"><a class="rd-nav-link" href="a_stats">Статистика</a></li>
                        <li class="rd-nav-item '.$a_users.'"><a class="rd-nav-link" href="a_users">Пользователи</a></li>
                        <li class="rd-nav-item '.$a_withdrawal.'"><a class="rd-nav-link" href="a_withdrawal">Заявки</a></li>
                        <li class="rd-nav-item '.$a_product.'"><a class="rd-nav-link" href="a_product">Продукты</a></li>
                        <li class="rd-nav-item '.$a_activation.'"><a class="rd-nav-link" href="a_activation">Активация</a></li>
                        <li class="rd-nav-item '.$a_reviews.'"><a class="rd-nav-link" href="a_reviews">Отзывы</a></li>
                        <li class="rd-nav-item '.$a_offices.'"><a class="rd-nav-link" href="a_offices">Офисы</a></li>
                      </ul>
                      <div class="rd-navbar-share fl-bigmug-line-right144" data-rd-navbar-toggle=".rd-navbar-share-list2">
		<ul class="list-inline rd-navbar-share-list rd-navbar-share-list2">
                          <li class="rd-navbar-share-list-item"><a class="icon" href="logout">Выйти</a></li>
                        </ul>
                      </div>';
	}
	else if ($_SESSION['logist']) {
		if ($page == 'log_main') $log_main = 'active';
		if ($page == 'log_product') $log_product = 'active';
		if ($page == 'log_extrad') $log_extrad = 'active';
		$first_link = '
                      <ul class="rd-navbar-nav">
                        <li class="rd-nav-item '.$log_main.'"><a class="rd-nav-link" href="log_main">Логистика</a></li>
                        <li class="rd-nav-item '.$log_product.'"><a class="rd-nav-link" href="log_product">Заявки</a></li>
                        <li class="rd-nav-item '.$log_extrad.'"><a class="rd-nav-link" href="log_extrad">Выдача продуктов</a></li>
                      </ul>
                      <div class="rd-navbar-share fl-bigmug-line-right144" data-rd-navbar-toggle=".rd-navbar-share-list2">
		<ul class="list-inline rd-navbar-share-list rd-navbar-share-list2">
                          <li class="rd-navbar-share-list-item"><a class="icon" href="logout">Выйти</a></li>
                        </ul>
                      </div>';
	}

	echo '<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>'.$title.'</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:400,500,600%7CTeko:300,400,500%7CMaven+Pro:500">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(62559469, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/62559469" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
  </head>
  <body>
    <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <div class="preloader">
      <div class="preloader-body">
        <div class="cssload-container"><span></span><span></span><span></span><span></span>
        </div>
      </div>
    </div>
    <div class="page">
      <div id="home">
        <!-- Page Header-->
        <header class="section page-header">
          <!-- RD Navbar-->
          <div class="rd-navbar-wrap">
            <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
              <div class="rd-navbar-main-outer">
                <div class="rd-navbar-main">
                  <!-- RD Navbar Panel-->
                  <div class="rd-navbar-panel">
                    <!-- RD Navbar Toggle-->
                    <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                    <!-- RD Navbar Brand-->
                    <div class="rd-navbar-brand"><a class="brand" href="/"><img src="images/logo-default-223x50.png" alt="" width="223" height="50"/></a></div>
                  </div>
                  <div class="rd-navbar-main-element">
                    <div class="rd-navbar-nav-wrap">
                      <!-- RD Navbar Share-->
                        '.$first_link.'
                    </div>
                  </div>
                </div>
              </div>
            </nav>
          </div>
        </header>
					';
				}


function reg_log() {
	if ($_SESSION['id'] && $_SESSION['login']) {
		echo '<li class="rd-nav-item"><a class="rd-nav-link" href="profil">Кабинет</a></li>';
	}
	else if ($_SESSION['admin']) {
		echo '<li class="rd-nav-item"><a class="rd-nav-link" href="a_stats">Админ</a></li>';
	}
	else {
		echo '<li class="rd-nav-item"><a class="rd-nav-link" href="login1">Войти</a></li>';
	}
	
}

				function bottom() {
					echo '
					</div>
                    <div class="snackbars" id="form-output-global"></div>
                    <script src="js/widget.js"></script>
                    <script src="js/bcrypt.js"></script>
					<script src="js/core.min.js"></script>
					<script src="js/script.js"></script>
					</body>
					</html>';
				}



				function footer() {
					global $page;
					if ($page == 'a_test') $p_js = 'test';
					else if ($page == 'a_product') $p_js = 'a_product1.1';
					else if ($page == 'products') $p_js = 'products1.1';
					else if ($page == 'binar') $p_js = 'binar1.3';
					else if ($page == 'linear') $p_js = 'linear1.2';
					else if ($page == 'profil') $p_js = 'profil1.3';
					else if ($page == 'logs') $p_js = 'logs1.0';
					else if ($page == 'finance') $p_js = 'finance1.0';
					else if ($page == 'a_withdrawal') $p_js = 'a_withdrawal1.3';
					else if ($page == 'a_stats') $p_js = 'a_stats1.0';
					else if ($page == 'a_users') $p_js = 'a_users1.1';
					else if ($page == 'a_activation') $p_js = 'a_activation1.2';
					else if ($page == 'activation') $p_js = 'main1.1';
					else if ($page == 'voronka_menu') $p_js = 'voronka_menu1.1';
					else if ($page == 'review') $p_js = 'review';
					else if ($page == 'a_reviews') $p_js = 'a_reviews1.0';
					else if ($page == 'a_offices') $p_js = 'a_offices';
					else if ($page == 'log_main' || $page == 'log_product' || $page == 'log_extrad') $p_js = 'logist';
					echo '<footer class="section section-fluid footer-minimal context-dark">
        <div class="bg-gray-15">
          <div class="container-fluid">
            <div class="footer-minimal-inset oh">
              <ul class="footer-list-category-2">
                <li><a href="#">vertexmax21@gmail.com</a></li>
                <li><a href="#">+7 (708) 768 74 74</a></li>
              </ul>
              <ul class="footer-list-category-2">
                <li><a href="#">Номер логиста</a></li>
                <li><a href="#">+7 (702) 195 87 82</a></li>
              </ul>
            </div>
            <div class="footer-minimal-bottom-panel text-sm-left">
              <div class="row row-10 align-items-md-center">
                <div class="col-sm-6 col-md-4 text-sm-right text-md-center">
                  <div class="row">
 							<div class="col-sm-12 col-md-6">
 							<a href="#" onclick="open_politika();">Политика конфиденциальности</a>
 						    </div>
 						    <div class="col-sm-12 col-md-6">
 							  <a href="#" onclick="open_oferta();">Договор оферты</a>
 							</div>
 						</div>
                </div>
                <div class="col-sm-6 col-md-4 order-sm-first">
                  <!-- Rights-->
                  <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span> <span>Vertex Max</span>
                  </p>
                </div>
                <div class="col-sm-6 col-md-4 text-md-right"><span>Все права защищены</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <script src="js/widget.js"></script>
      <script src="js/bcrypt.js"></script>
      <script src="js/core.min.js"></script>
			<script src="js/script1.0.js"></script>
			<script src="js/'.$p_js.'.js?v=037"></script>
			<script type="text/javascript">

  function open_politika() {
    var otherWindow = window.open();
    otherWindow.opener = null;
    otherWindow.location = "https://vertexmax.com/politika";
  }
  function open_oferta() {
		var otherWindow = window.open();
		otherWindow.opener = null;
		otherWindow.location = "https://vertexmax.com/oferta";
	}
  
</script>
		</body>
		</html>';
					}


/*
log_type
1 - Покупка продукта
2 - Начисления
4 - Заявка на вывод
7 - Спикер
8 - Баллы с активации
9 - Активация
11 - Перевод
12 - Апгрейд
13 - Повышение статуса
14 - Подарки
15 - Обязательная покупка продукта
16 - Адрес доставки
17 - Логистика
18 - Пополнение баланса

*/
					?>