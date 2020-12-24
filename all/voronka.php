<?

if (!$_SESSION['name']) {
	if ($_COOKIE['auto'] == 0) $ref == 1;
	else $ref = $_COOKIE['auto'];

	echo '<script>window.location.href = "/?auto='.$ref.'";</script';
}

?>


<!DOCTYPE html>
<html class="wide wow-animation" lang="ru">
<head>
	<title>Автоворонка</title>
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
								<style type="text/css">
								.rd-navbar-classic.rd-navbar-static .rd-navbar-main {
									justify-content: center;
								}
								.rd-navbar-fixed .rd-navbar-panel {
									justify-content: center;
								}
							</style>
							<div class="rd-navbar-panel">
								<!-- RD Navbar Toggle-->
								<!-- <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button> -->
								<!-- RD Navbar Brand-->
								<div class="rd-navbar-brand"><img src="images/logo-default-223x50.png" alt="" width="223" height="50"/></div>
							</div>
								<!-- <div class="rd-navbar-main-element">
									<div class="rd-navbar-nav-wrap">
										<ul class="rd-navbar-nav">
											<li class="rd-nav-item active"><a class="rd-nav-link" href="/#home">Главная</a></li>
											<li class="rd-nav-item"><a class="rd-nav-link" href="login">Войти</a></li>
										</ul>
									</div>
								</div> -->
							</div>
						</div>
					</nav>
				</div>
			</header>

			<section class="section section-sm section-fluid bg-default text-center" id="business">
				<div class="container">
					<? 
					$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT fio, number FROM users WHERE id = '$_SESSION[ref]' "));
					?>
					<h2 style="font-style: italic;">Здравствуйте <? echo $_SESSION['name']; ?></h2>
					<p class="quote-jean" style="font-size: 24px;font-style: italic;">Ваш куратор : <? echo $row['fio']; ?><br/>
						Номер куратора : <? echo $row['number']; ?></p>

						<h2>Автоворонка</h2>
						<div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px;">
							<video  controls controlsList="nodownload" >
								<source src="video/rolik1.1.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
								Тег video не поддерживается вашим браузером.
							</video>
						</div>
						<div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px;">
							<video  controls controlsList="nodownload" >
								<source src="video/Ролик 2.3.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
								Тег video не поддерживается вашим браузером. 
							</video>
						</div>
						<div style="max-width: 800px;margin-left: auto;margin-right: auto;">
							<p>Вы спросите, что представляет собой автоворонка?</p>
							<p>Это универсальная система, которая на полном автомате обрабатывает потенциальных партнеров и доводит до регистрации в команду, без Вашего участия в режиме 24/7.</p> 
							<p>Это - готовый бизнес-план, который несомненно приведет вас к успеху!</p>
							<p>Говоря иными словами, мы предлагаем Вам уже готовую бизнес модель с обучением, поддержкой, которая гарантированно приведет вас к желаемым результатам, вне зависимости от социального уровня, навыков и умения за счет современных интернет технологий.</p>
							<p>И самое главное, у вас будет собственный, растущий интернет бизнес, не имеющий аналогов, а также территориальных и временных ограничений. Другими словами, вы можете контролировать рабочий процесс в любое время суток, дня недели и с любой точки мира!</p>
						</div>
						<div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px;">
							<video  controls controlsList="nodownload" >
								<source src="video/Ролик 3.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
								Тег video не поддерживается вашим браузером. 
							</video>
						</div>
						<br/>
						<button type="submit" class="btn btn-primary" onclick="post_query( 'gform', 'start_reg', 'rec_login' )">Начать зарабатывать</button>
						<h2 style="margin-top: 20px;">Компания</h2>
						<div class="embed-responsive embed-responsive-16by9">
							<video  controls controlsList="nodownload" >
								<source src="video/Ролик 4 готова.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
								Тег video не поддерживается вашим браузером. 
							</video>
						</div>
						<h3 style="margin-top: 20px;">Продукция</h3>
						<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/LfCXEBnyE20" allowfullscreen></iframe>
						</div>
						<h3 style="margin-top: 20px;">Маркетинг</h3>
						<div class="embed-responsive embed-responsive-16by9">
							<video  controls controlsList="nodownload" >
								<source src="video/Маркетинг.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
								Тег video не поддерживается вашим браузером. 
							</video>
						</div>
						<div style="max-width: 800px;margin-left: auto;margin-right: auto;">
							<p>Хотите зарабатывать большие деньги? Тогда регистрируйтесь в системе и получите самый эффективный инструмент, который реально работает и построит Ваш бизнес на полном автомате!</p>
							<div style="display: flex;justify-content: center;">
								<ul style="text-align: left;">
									<li>✔ Проблема с приглашениями будет решена на 100 %;</li>

									<li>✔ Вам больше не придется приставать к людям;</li>

									<li>✔ Вы больше не будете думать, где взять людей в бизнес;</li>

									<li>✔ Вы быстро построите рабочую структуру партнеров, которые повторят Вас;</li>

									<li>✔ Ваш бизнес будет развиваться с космической скоростью;</li>

									<li>✔ Ваш доход будет всегда увеличиваться;</li>

									<li>✔ Система легко повторяется любым новичком и быстро даёт РЕЗУЛЬТАТ!!!</li>
								</ul>
							</div>
							<p>Вы тоже сможете пользоваться автоматизированной системой рекрутирования, которая на полном автомате будет регистрировать новых людей в Вашу команду!</p>

							<p>Вы сможете начать зарабатывать в тот же день, сразу после регистрации в компании, Вам будет доступна автоворонка!</p>

							<p>Вам не придется настраивать автоворонку, при регистрации она автоматически настроится под Ваш профиль!</p>

							<p>Сразу после регистрации Вы получите:</p>
							<div style="display: flex;justify-content: center;">
								<ul style="text-align: left;">
									<li>⮚ полезный, востребованный и качественный продукт!</li>

									<li>⮚ готовую уникальную систему заработка!</li>

									<li>⮚ возможность подключить автоматизированную систему рекрутирования!</li>

									<li>⮚ при подключении автоворонки, пошаговый видеокурс по созданию таргетинга в инстаграм!</li>
								</ul>
							</div>
							<p>Все, что Вам нужно, это присоединиться к моей команде и ПОДКЛЮЧИТЬ СИСТЕМУ!</p>

							<p>Ознакомьтесь с маркетингом компании и выберите свой пакет.</p>

							<p>Оплатить пакет можно при регистрации, банковской картой или внутренними деньгами системы.</p>

							<p>ПОДКЛЮЧАЙТЕСЬ В МОЮ КОМАНДУ И НАЧНИТЕ ЗАРАБАТЫВАТЬ ПОЛЬЗУЯСЬ СОВЕРШЕННОЙ АВТОВОРОНКОЙ!</p>

						</div>
						<br/>
						<button type="submit" class="btn btn-primary" onclick="post_query( 'gform', 'start_reg', 'rec_login' )">ПОЛУЧИТЬ АВТОВОРОНКУ</button>
						<p class="quote-jean" style="font-size: 24px;font-style: italic;">Ваш куратор : <? echo $row['fio']; ?><br/>
							Номер куратора : <? echo $row['number']; ?></p>
							<div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px;">
								<video  controls controlsList="nodownload" >
									<source src="video/ролик 4.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
									Тег video не поддерживается вашим браузером. 
								</video>
							</div>
						</div>
					</section>

					<!-- Page Footer-->
					<footer class="section section-fluid footer-minimal context-dark">
						<div class="bg-gray-15">
							<div class="container-fluid">
								<div class="footer-minimal-inset oh">
									<ul class="footer-list-category-2">
										<li><a href="#">vertexmax21@gmail.com</a></li>
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
										<div class="col-sm-6 col-md-4 text-md-right"><span>Все права защищены.</span> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</footer>
					<!-- Javascript-->
					<script src="js/core.min.js"></script>
					<script src="js/script1.0.js"></script>
					<script src="js/main1.1.js"></script> 
					<script type="text/javascript">
						$("video").on("contextmenu", false);

						function open_politika() {
							var otherWindow = window.open();
							otherWindow.opener = null;
							otherWindow.location = 'https://vertexmax.com/politika';
						}
						function open_oferta() {
							var otherWindow = window.open();
							otherWindow.opener = null;
							otherWindow.location = 'https://vertexmax.com/oferta';
						}
					</script>
				</body>
				</html>