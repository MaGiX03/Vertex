<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>
	<title>Отзывы</title>
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
										<ul class="rd-navbar-nav">
											<li class="rd-nav-item"><a class="rd-nav-link" href="/#home">Главная</a></li>
											<li class="rd-nav-item"><a class="rd-nav-link" href="/#business">Бизнес</a></li>
											<li class="rd-nav-item"><a class="rd-nav-link" href="/#company">Компания</a></li>
											<li class="rd-nav-item"><a class="rd-nav-link" href="/#product">Продукция</a></li>
											<li class="rd-nav-item active"><a class="rd-nav-link" href="otziv">Отзывы</a></li>
											<? reg_log(); ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</nav>
				</div>
			</header>

			<section class="section section-sm section-bottom-70 section-fluid bg-default">
				<div class="container-fluid">
					<h2>Отзывы</h2> 
					<div class="row row-50 row-sm justify-content-center">
						
						<?	
						$result = mysqli_query($CONNECT, "SELECT * FROM reviews WHERE accepted = 1");

						while ($row = mysqli_fetch_assoc($result)) {
							$row['input_date'] = date('d.m.Y', strtotime($row['input_date']));
							echo '<div class="col-md-12 col-xl-12 wow fadeInRight">
							<!-- Quote Modern-->
							<article class="quote-modern quote-modern-custom">
							<div class="unit unit-spacing-md align-items-center">
							
							<div class="unit-body">
							<h4 class="quote-modern-cite">'.$row['name'].'</h4>
							<p class="quote-modern-status">'.$row['input_date'].'</p>
							</div>
							</div>
							<div class="quote-modern-text">
							<p class="q">'.$row['text'].'</p>
							</div>
							</article>
							</div>';
						}

						?>
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
								<li><a href="#">+7 (708) 768 74 74</a></li>
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
			<script type="text/javascript">

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