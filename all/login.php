<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>
	<title>Вход</title>
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
											<li class="rd-nav-item"><a class="rd-nav-link" href="otziv">Отзывы</a></li>
											<? reg_log(); ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</nav>
				</div>
			</header>

			<style type="text/css">
			.au_reg {
				position: relative;
				transition: .25s;
				cursor: pointer;
			}
			.au_reg::before {
				position: absolute;
				content: '';
				bottom: -8px;
				left: 0;
				height: 3px;
				width: 100%;
				background: #6689ff;
				opacity: 0;
				visibility: hidden;
				transform: translateY(5px);
				transition: all .2s ease;
			}
			.active.au_reg::before{
				opacity: 1;
				transform: none;
				visibility: visible;
			}
		</style>
		<section class="section section-sm bg-default" style="margin-bottom: 100px;">
			<div class="container">
				<h3>
					<?
					if ($url_number == 1) echo '<swap onclick="show_auth()" id="auth_but" class="au_reg active">Вход</swap> | <swap onclick="show_reg()" id ="reg_but" class="au_reg">Регистрация</swap>';
					else echo '<swap onclick="show_auth()" id="auth_but" class="au_reg">Вход</swap> | <swap onclick="show_reg()" id ="reg_but" class="au_reg active">Регистрация</swap>';
					?>
				</h3>
				<div class="row row-30 justify-content-center">
					<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;<? if ($url_number != 1) echo 'display: none;' ?>">
						<form onsubmit="post_query( 'gform', 'login', 'login.password' );return false;">
						<div class="form-group">
							<label for="login">Логин</label>
							<input type="text" class="form-control" id="login">
						</div>
						<div class="form-group">
							<label for="password">Пароль</label>
							<input type="password" class="form-control" id="password">
						</div>
						<div class="titleHelp"></div>
						<button type="submit" class="btn btn-primary">Войти</button>
					</form>
						<br>
						<div style="text-align: left;">
							<a href="#" onclick="show_rec()">Забыли пароль?</a>
						</div>

					</div> 
					<div class="col-sm-12 col-md-10 col-lg-8" id="rec"  style="margin-top: 20px;display: none;">
						<form onsubmit="post_query( 'gform', 'recovery', 'rec_login' );return false;">
						<div class="form-group">
							<label for="rec_login">Введите свой логин</label>
							<input type="text" class="form-control" id="rec_login">
						</div>
						<div class="titleHelp"></div>
						<button type="submit" class="btn btn-primary">Восстановить</button>
					</form>
						<br>
						<div style="text-align: left;">
							<a href="#">Забыли пароль?</a>
						</div>

					</div>
					<div class="col-sm-12 col-md-10 col-lg-8" id="reg"  style="margin-top: 20px;<? if ($url_number == 1) echo 'display: none;' ?>">
						<form onsubmit="post_query( 'gform', 'register', 'reg_login.reg_password.email.number.ref_login.speaker_login.country.city.fio.reg_password_check.birthday' );return false;">
							<div class="form-group">
								<label for="reg_login">Логин</label>
								<input type="text" class="form-control" id="reg_login" required>
							</div>
							<div class="form-group">
								<label for="reg_password">Пароль</label>
								<input type="password" class="form-control" id="reg_password" required pattern="[A-Za-z0-9]{4,30}" oninvalid="this.setCustomValidity('Пароль может содеражать от 4 до 30 латинских букв и цифр')"
								oninput="this.setCustomValidity('')">
							</div>
							<div class="form-group">
								<label for="reg_password_check">Повторите пароль</label>
								<input type="password" class="form-control" id="reg_password_check" required pattern="[A-Za-z0-9]{4,30}" oninvalid="this.setCustomValidity('Пароль может содеражать от 4 до 30 латинских букв и цифр')"
								oninput="this.setCustomValidity('')">
							</div>
							<div class="form-group">
								<label for="email">E-mail</label>
								<input type="email" class="form-control" id="email" required>
							</div>
							<div class="form-group">
								<label for="number">Телефон</label>
								<input type="text" class="form-control" id="number" required"
								oninput="this.setCustomValidity('')">
							</div>
							<div class="form-group">
								<label for="fio">ФИО на латинском(как на паспорте или на карте)</label>
								<input type="text" class="form-control" id="fio" required>
							</div>
							<div class="form-group">
								<label for="birthday">Дата рождения</label>
								<input type="date" class="form-control" id="birthday" required>
							</div>
							<div class="form-group">
								<label for="city">Город</label>
								<select class="form-control" id="country" style="padding: 8px 30px;" onchange="show_regions()">
									<option value="0">Страна</option>
									<?php 
									$result = mysqli_query($CONNECT,"SELECT country_id, name FROM country");

									while ($row = mysqli_fetch_assoc($result)) {
										echo '<option value='.$row['country_id'].'>'.$row['name'].'</option>';
									}

									?>
								</select>
								<select class="form-control" id="region" style="padding: 8px 30px;" onchange="show_cities()">
									<option value="0">Регион</option>
								</select>
								<select class="form-control" id="city" style="padding: 8px 30px;">
									<option value="0">Город</option>
								</select>
							</div>
							<div class="form-group">
								<?
								if ($_COOKIE['ref']) {
									$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login FROM users WHERE id = '$_COOKIE[ref]' "));
									$ref = $row['login'];
								}

								if ($_SESSION['id'] && $_SESSION['name']) {

									$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login FROM users WHERE id = '$_SESSION[ref]' "));
									$ref = $row['login'];
								}
								?>
								<label for="ref_login">Логин спонсора</label>
								<input type="text" class="form-control" id="ref_login" value="<?=$ref?>" required>
							</div>
							<div class="form-group">
								<label for="speaker_login">Логин спикера</label>
								<input type="text" class="form-control" id="speaker_login">
							</div>
							<p>Нажимая на кнопку вы соглашаетесь с <a href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Договором Публичной Оферты</a></p>
							<br/> 
							<div class="titleHelp"></div>
							<button type="submit" class="btn btn-primary">Регистрация</button>
							<div class="form-group" style="margin-top: 20px;">
								<label for="converter">Конвертер</label>
								<select class="form-control" id="converter" style="padding: 8px 30px;">
									<option>1$ - 400 KZT</option>
									<option>1$ - 71 RUB</option>
									<option>1$ - 75 KGS</option>
									<option>1$ - 10007 UZS</option>
									<option>1$ - 26,4 UAH</option>
								</select>
							</div>
						</form>
					</div> 
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

		<style type="text/css">
		@media (min-width: 576px) {
			.modal-dialog {
				max-width: 700px;
			}
		}

	</style>

	<div class="modal fade" id="modalCta" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="max-width: 1000px;">
				<div class="modal-header">
					<h3>ДОГОВОР ПУБЛИЧНОЙ ОФЕРТЫ</h3>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body" style="text-align: justify;">
					<div class="row"><div class="col-sm-6" style="text-align: left;">г. Алматы</div><div class="col-sm-6" style="text-align: right;">«28» апреля 2020г.</div></div>
					<p>ТОО «Vertex Max», именуемое в дальнейшем «Заказчик/Компания» в лице директора Серикбаевой  Гаухар Бакбергеновны действующего на основании Устава, с одной стороны, и
					именуемое в дальнейшем «Партнер», с другой стороны, далее совместно именуемые Стороны, а по отдельности Сторона или как указано выше, заключили настоящий Договор (далее по тексту-Договор) о нижеследующем: </p>


					<p><b>1. Предмет договора</b></p>
					<p>1.1 Предметом настоящего договора является оказание Партнером услуг по привлечению покупателей на сайте www.vertexmax.com.</p>

					<p>1.2. Принятие (акцепт) данной Оферты означает полное и безоговорочное принятие Партнёром всех условий без каких-либо исключений и/или ограничений и приравнивается в соответствии с законодательством РК к заключению сторонами двухстороннего письменного договора на условиях, которые изложены ниже в этой Оферте.</p>
					<p>1.3. Данный Публичный договор по привлечению покупателей (Оферта) считается заключенным (акцептированным) с момента получения статуса Партнера, согласно маркетинг-плану, является приобретение Партнером бизнес-места - независимого дистрибьютера Компании с пакетом продукции.</p>
					<p>1.4. Заказчик и Партнёр предоставляют взаимные гарантии своей право- и дееспособности необходимые для заключения и исполнения настоящего Договора.</p>
					<p>1.5 Заказчик (продавец) оставляет за собой право вносить изменения в настоящий договор, в связи с чем, Партнер обязуется регулярно отслеживать изменения в договоре, размещенном на сайтах www.vertexmax.com</p>

					<p>1.6 Партнер приобретает, а Заказчик предоставляет товар согласно маркетинг плану за безналичный расчет или путём внесения денежных средств в кассу Заказчика.</p> 

					<p><b>2. Условия договора.</b></p>
					<p>2.1 Приобретенный Партнером товар возврату и обмену не подлежит. После приобретения товара в случае отказа Партнера участия в проекте денежные средства заказчик не возвращает.</p>
					<p>2.2 Партнер имеет право продать свое бизнес-место, если он принял самостоятельное решение не участвовать далее в проекте Компании.</p>
					<p>2.3 Вышестоящий спонсор имеет право, (но не обязан) помогать Партнеру, предоставляя ему регистрацию под его структуру. В этом случае Партнер обязан принимать условия спонсора, то есть возврат бизнес-места, в определенную структуру, указанную вышестоящим спонсором.</p>
					<p>2.4 Все Партнеры компании обязаны выполнять условия маркетинг плана.</p>
					<p>2.5 Партнеры, не выполнившие условия маркетинг плана Компании не могут претендовать на получение вознаграждения. </p>
					<p>2.6 В процессе деятельности Компании могут приниматься отдельные от Договора условия Компании, принятые независимым Лидерским советом и утвержденные Директором Компании, имеющие юридическую силу.</p>
					<p>2.7 В условия данного договора входят условия Морально-этического кодекса, условия приобретения товаров в каждой программе и общие условия маркетинг-плана. </p>
					<p>2.8 Соблюдение бренда компании должно быть во всех открываемых лидерами офисов (виды визиток, цветовая гамма, размеры, шрифт текста и содержание предлагаемых баннеров, буклетов, визиток, рабочих журналов и тд.).</p> 
					<p>2.9 Подписанный договор Партнером (электронная подпись в том числе) является основанием согласия и принятия им всех условий и имеет юридическую силу.</p>
					<p><b>3. Ответственность сторон</b></p>
					<p>3.1 Компания не несет ответственности за прекращение деловой активности Партнера и за материальные потери, возникшие по вине Партнера.</p>
					<p>3.2 Компания не несет ответственности за содержание информации, размещенной Партнером в рекламных объявлениях в социальных сетях, иного вида объявлений в интернете о сайте www.vertexmax.com</p>
					<p>3.3 Компания не несет ответственности за содержание интернет-ресурса Партнера, а также за нарушение Партнером действующего законодательства Республики Казахстан.</p>
					<p>3.4 В случае неисполнения или ненадлежащего исполнения одной из Сторон обязательств по договору, другая Сторона вправе применить к виновной Стороне санкции, предусмотренные данным договором и гражданским законодательством Республики Казахстан;</p>
					<p>3.5 В случае нарушения договорных обязательств Партнером, Компания вправе ограничить или полностью закрыть доступ к бэк-офису Партнера до устранения им допущенных нарушений;</p>
					<p>3.6 Компания не отвечает по обязательствам Партнера перед третьими лицами, даже если эти обязательства связаны с исполнением Партнера условии настоящего договора;</p> 
					<p><b>4. Права и обязанности сторон</b></p>
					<p>4.1 Компания предоставляет Партнеру свою продукцию. Партнер согласно договору становится потребителем и осуществляет распространения информации. Партнер указывает текущий счет, лицевой счет, расчетный счет открытый на его/её имя в одном из банков второго уровня Республики Казахстан, либо открывает один из счетов в банках второго уровня Республики Казахстан для перечисления вознаграждения.</p>
					<p>4.2 Партнер осуществляет привлечение Пользователей на сайт www.vertexmax.com любым способом, не запрещенным действующим законодательством и в соответствии со следующими правилами:</p>
					<p>4.2.1 В случае если привлечение покупателей на сайте www.vertexmax.com производится Партнером путем размещения реферальной ссылки, рекламного баннера на собственном сайте Партнера, сайт Партнера не должен содержать информацию, противоречащую законам РК или незаконные материалы, нарушающие авторские и смежные права, права на товарные знаки, патентное право и прочие права интеллектуальной собственности.</p>
					<p>4.4 Владелец сайта несет всю ответственность за нарушения действующего законодательства Республики Казахстан, авторских и смежных прав на своем сайте.</p> 
					<p>4.5 Партнер обязан соблюдать в своих рекламных размещениях (флаера, визитки и т.д.) установленного образца логотип, единый стиль (размер, цвета, фон, шрифт) Компании в целях узнаваемости и поддержания имиджа Компании.</p>
					<p>4.6 Партнер обязуется:</p>
					<p>1) совершать действия, направленные на размещение среди потенциальных клиентов информации и заказов на товары и услуги Компании «www.vertexmax.com» в форме, приемлемой для Компании и самого.</p>
					<p>2) вести поиск Партнеров в бизнес, а также на товары и услуги Компании;</p>
					<p>3) распространять рекламные материалы Компании среди потенциальных клиентов;</p>
					<p>4) устанавливать контакты с клиентами, как потенциальными, так и заключившими договор с Компанией на товары и оказание услуг;</p>
					<p>д) производить иные действия, необходимые для оперативной и эффективной реализации товаров и услуг Компании и не запрещённые законодательством государства, под юрисдикцией которого находится Партнер, и не противоречащие условиям настоящего договора;</p>
					<p>5) соблюдать морально-этический кодекс и условия Компании;</p>
					<p>ж) использовать слайды и текстовые сопровождения для представления бизнеса, утверждённые Компанией, которые находятся в бэк-офисе Партнера;</p>
					<p>6) Компания запрещает использовать логотип Компании на персональных сайтах (кроме персональных сайтов информационных центров Компании), в записях авторских видеороликов и других материалах без получения документального разрешения от Компании;</p>
					<p>7) запрещается использовать чат Компании не по назначению, а именно выставлять в нём частную рекламную продукцию, информацию о других компаниях, вести личную переписку с целью решения вопросов, не относящихся к проекту.</p>
					<p>8) Предоставлять Компании только достоверную информацию, в том числе телефонные номера, почтовые и e-mail адреса, данные документов, удостоверяющих личность, подтверждающие регистрацию по месту жительства и фактическое место проживания;</p>
					<p>9) Предоставлять о бизнесе и Компании только достоверную информацию. Не допускать каких-либо письменных, либо устных высказываний, порочащих Компанию в общих чатах Компании, на событиях Компании и в средствах массовой информации;</p>
					<p>10) За ложную и неправильно поданную информацию, дискредитирующую Компанию, Компания может налагать на Партнера штраф в размере до 1 000 000 (один миллиона тенге), при предоставлении ему доказательств его неправомерных действий. В особых случаях, повлёкших ущерб для Компании, или повторных случаях после первого предупреждения, Партнер может быть лишён бизнес-места (терминирован) без возмещения денежных вознаграждений, полученных по маркетинг-плану Компании.</p>
					<p>11) Партнер обязан сохранять в тайне ставшие ему известными в связи с исполнением условий Договора сведения о клиентах, контрагентах и торговых сделках Компании.</p>
					<p>4.6.1 Партнер обязуется непрерывно соблюдать условия хранения товара(-ов)/продукция (-и). Условия хранения товара(-ов)/продукция(-и):</p>
					<p>1. Не допускать промерзания, замораживания, потепления;</p>
					<p>2.Защищать от неблагоприятных внешних воздействий. Бережно обращаться при погрузке-разгрузке, не превышать предельную высоту складирования;</p>
					<p>3.Систематично контролировать. Постоянно наблюдать за сохранностью, режимом хранения, целостностью упаковки;</p>
					<p>4. Соблюдать климатический и санитарно-гигиенический режим хранения. 5. Товар (-ы)/продукция(-и) должны хранится при температуре t 0 – 20 градусов по шкале Цельсия (С) и при влажности 5 – 35%. </p>
					<p>4.7 Компания обязуется:	</p>
					<p>1) Дать возможность Партнеру выбрать уникальный свободный логин, к которому будет привязана учётная запись в системе маркетинга Компании, и обеспечить круглосуточный доступ в операционно-учётную систему (бэк-офис) с момента заключения настоящего Договора;</p>
					<p>2) Обеспечить конфиденциальность данных, а также сведений об операциях в бэк-офисе Партнера;</p>
					<p>3) Обеспечить Партнеру рекламную площадку для успешного продвижения товаров и услуг Компании (возможность пользоваться онлайн-комнатой для конференций и презентаций бизнеса);</p>
					<p>4) Обеспечить Партнеру возможность участвовать в партнёрских программах для продвижения товаров и услуг, предлагаемых Компанией;</p>
					<p>5) Проводить регулярные конференции в режиме ON-LINE, обучающие школы, организовывать события и семинары, а также обеспечить постоянную информационную и техническую поддержку Суппортом Компании;</p>
					<p>6) Обеспечить своевременное начисление вознаграждений Партнеру во время продвижения по маркетинговой системе;</p>
					<p>7) Компания запрещает смену спонсора (вышестоящего исполнителя) или реферала (приглашенного исполнителя) или структуры, а также контролирует надлежащие исполнение данного пункта. </p>
					<p>8) Компания не предоставляет гарантии получения прибыли Партнером, определяемых исходя из собственного понимания способа извлечения прибыли и области применения товаров и услуг Компании;</p>
					<p>9) Компания гарантирует корректную работу заявленной ей программы маркетинга, созданной Компанией;</p>
					<p>10) В случае сбоя программы, Компания гарантирует восстановление и быстрый запуск программы в работу;</p>
					<p>11) Компания гарантирует восстановление бизнес-места, денежных счетов и информации в бэк-офисе Партнера, если оно будет повреждено в случае сбоя или взлома программы. </p>
					<p><b>5. Порядок оплаты</b></p>
					<p>5.1 Компания в соответствии с маркетинг-планом обязуется выплатить вознаграждения:</p>
					<p>1) За минусом индивидуального подоходного налога и пенсионных отчислений, предусмотренных законодательством РК, если Партнером является физическое лицо;</p>
					<p>2) Вознаграждение выплачивается в полном объеме без удержания суммы, если Партнером является Индивидуальный предприниматель. В соответствии с действующим законодательством РК, Индивидуальный предприниматель лично несет ответственность за уплату налогов, сдачи отчетности, пенсионных и других отчислении; 
					Все расчеты производятся в тенге.</p>
					<p>5.2 За услуги, оказываемые Партнером в соответствии с настоящим договором, Компания начисляет Исполнителю вознаграждение на его личный счет.</p>
					<p>5.3 Компания обязуется принимать от Партнера средства с его личного счета на сайте www.vertexmax.com в счет оплаты товаров и услуг Компании, при условии, что сумма на личном счете Партнера достаточна для оплаты заказа оформленного Партнером в полном объеме.</p>
					<p>5.4 Компания обязуется по требованию Партнером выплачивать Исполнителю доступные на его личном счете суммы вознаграждения способами, указанными Исполнителем в заявке на вывод средств. Выплаты Партнеру производятся в тенге РК.</p>
					<p>5.5 Выплаты не производятся Партнеру, уличенным в нарушении договора.</p>
					<p>5.6 Вывод денежных средств, заработанных Партнером по маркетинг-плану, осуществляется Компанией в течение 5-и рабочих банковских дней. Вывод средств на пластиковые карты или банковские счета Партнеру производится после взаимного согласования такой возможности с Суппортом Компании и подачи официальной заявки на вывод. </p>
					<p><b>6. Для привлечения покупателей запрещено</b></p>
					<p>6.1 Запрещено использование партнерской программы на сайте www.vertexmax.com партнерами и покупателем, являющимся одним и тем же лицом, и в других случаях обманного использования Партнером партнерской программы Компании без привлечения покупателей, в целях снижения стоимости товара приобретаемого самим Партнером. В случае выявления подобных случаев Компания оставляет за собой право заблокировать личный счет Партнера без возможности использования или вывода средств.</p>
					<p>6.2 Партнер обязуется предоставить достоверные данные о себе при регистрации на сайтах www.vertexmax.com и заполнении заявки на вывод средств. </p>
					<p><b>7. Срок действия договора</b></p>
					<p>7.1 Настоящий договор действует с момента принятие Партнера сроком на один год. Если в течении действия настоящего договора стороны не изъявят желание расторгнуть данный договор, тогда договор считается пролонгированным на следующий календарный год. В случае приостановления действия настоящего договора либо расторжения договора по инициативе Компании уведомление Партнера о приостановлении (расторжении) договора производится по адресу электронной почты Исполнителя, зарегистрированного на сайте Компании. Такой способ уведомления стороны признают надлежащим.</p>
					<p>7.2 Конфиденциальная информация, предоставленная одной из сторон, должна быть использована другой стороной исключительно для целей исполнения договора и может быть разглашена третьим лицам только в соответствии с действующим законодательством Республики Казахстан.</p>
					<p>7.3 Во всем остальном, что не предусмотрено настоящим договором, стороны руководствуются действующим законодательством Республики Казахстан. </p>
					<p><b>8. Форс-мажор</b>	</p>
					<p>8.1 При наступлении обстоятельства невозможности полного или частичного исполнения одной из сторон обязательств по настоящему договору, а именно: пожар, стихийных бедствий, военных операций любого характера, блокады, запрещений экспорта, импорта или других не зависящих от сторон обстоятельств, срок исполнения обязательств сдвигается соразмерно времени в течении, которого будут действовать такие обстоятельства. Стороны для которой создалась невозможность исполнение обязательств по настоящему договору, должна о наступлении и прекращении обстоятельств препятствующих исполнению обязательств извещать другую сторону в срок не позднее двух недель.</p>
					<p>8.2 Надлежащим доказательством наличия указанных выше обстоятельств будут служить документы соответствующие компании. </p>

					<p><b>9. РАЗРЕШЕНИЕ СПОРОВ И ПРОЧИЕ УСЛОВИЯ</b></p>
					<p>9.1 Для разрешения споров по настоящему Договору Стороны устанавливают обязательный претензионный порядок.</p>
					<p>9.2 Претензии предъявляются в письменной форме, подписываются уполномоченными лицами и отправляются заказными, либо ценными письмами с уведомлением.</p>
					<p>9.3 Сторона, получившая претензию, обязана в течение 7 дней мотивированным письмом сообщить другой Стороне результаты ее рассмотрения.</p>
					<p>9.4 В случае, если возникший спор не удалось разрешить путем переговоров и в претензионном порядке, дело подлежит рассмотрению Казахстанским Международным Арбитражем в соответствии с действующим Регламентом. Состав Арбитража будет включать одного арбитра. Место проведения арбитражного разбирательства город Алматы. Решения данного суда будут обязательными и окончательными для обеих Сторон. Языком арбитражного разбирательства будет русский язык.</p>
					<p>9.5 Компания вправе в одностороннем порядке вносить изменения и дополнения в настоящий договор. При этом надлежащим уведомлением исполнителя о внесённых изменениях является размещение информации о таких изменениях на сайте  www.vertexmax.com</p>
					<p>9.6 Настоящий договор может быть расторгнут Компанией в следующих случаях:</p>
					<p>1) при нарушении исполнителем условий договора об использовании операционно-учётной системы бэк-офиса, а также других внутренних и государственных актов, регулирующих деятельность Компании;</p>
					<p>2) в случае причинения исполнителем материального или морального ущерба Компании, либо совершения Партнером действий, не совместимых с добросовестным бизнес-сотрудничеством между Патрнером и Компанией, а также в случаях несоблюдения Партнером морально-этического кодекса Компании или неуважительного и грубого отношения к сотрудникам Компании или другим Партнерам Компании, распространение лживой информации, направленной на подрыв деятельности Компании, Компания оставляет за собой право терминации такого Пользователя в одностороннем порядке, без возмещения каких-либо выплат по маркетингу.</p>
					<p>3) в случаях предусмотренных п. (а) Компания предупреждает Партнера о допущенных нарушениях и требует их устранения. Если Партнер не реагирует на требования Компании в течении 3 календарных дней, то допускается наложение Компанией штрафов и блокировка аккаунта Партнера до выполнения условий;</p>
					<p>4) Сообщения и уведомления между Сторонами направляются любым удобным для Сторон видом связи (почта, факс, e-mail и т.д.), хранящихся в регистрационной базе данных Компании и позволяющим достоверно установить получателя. Компания вправе направлять Исполнителю уведомления и сообщения в виде электронных писем;</p>


				</div>
			</div>
		</div>
	</div>

	<!-- Javascript-->
	<script src="js/core.min.js"></script>
	<script src="js/script1.0.js"></script>
	<script src="js/main1.1.js"></script>
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