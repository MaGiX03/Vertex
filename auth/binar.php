<?php 
top('Бинарная структура');
if ($url_number == 0) $url_number = $_SESSION['id'];
?>

<input type="hidden" id="uid" value="<?=$url_number?>">
<section class="section section-sm bg-default" >
	<div class="container">
		<div class="row row-30 justify-content-center" id = "binar_stat">
			<div class="col-sm-12 col-md-8 col-lg-4">
				<article class="box-contacts" style="background-color: crimson;">
					<div class="box-contacts-body">
						<h3 class="box-icon-modern-big-title" style="margin-bottom: 10px;">Левая ветка</h3>
						<p class="box-contacts-link" id="left_week_vp">Недельный объем: 0</p>
						<p class="box-contacts-link" id="left_total_vp">Общий объем: 0</p>
						<p class="box-contacts-link" id="l_fol_total">Кол-во партнёров: 0</p>
						<p class="box-contacts-link" id="l_fol_1">Старт: 0</p>
						<p class="box-contacts-link" id="l_fol_2">Бизнес: 0</p>
						<p class="box-contacts-link" id="l_fol_3">Премиум: 0</p>
					</div>
				</article>
			</div>
			<div class="col-sm-12 col-md-8 col-lg-4">
				<?php
				if ($url_number == $_SESSION['id']) {
					$pos = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT position, direction FROM binar_log WHERE user_id = '$_SESSION[id]' "));
					if ($pos['direction'] == 3) {
						if ($pos['position'] == 0) $pos1 = "selected";
						if ($pos['position'] == 1) $pos2 = "selected";
						if ($pos['position'] == 2) $pos3 = "selected";
						echo '<div class="form-group">
						<label for="paket">Позиция</label>
						<select class="form-control" id="pos_val" style="padding: 8px 30px;" onchange="position_change()">
						<option value="0" '.$pos1.'>По умолчанию</option>
						<option value="1" '.$pos2.'>Левая</option>
						<option value="2" '.$pos3.'>Правая</option>
						</select>
						</div>
						<div class="titleHelpP"></div>
						<p>Вы можете настроить, в какую ветку ставить новых партнеров в бинарной структуре:</p>
						<p><b>По умолчанию -</b> программа ставит новых партнеров в малую ветку</p>
						<p><b>Левая -</b> программа ставит новых партнеров в левую ветку</p>
						<p><b>Правая -</b> программа ставит новых партнеров в правую ветку</p>';
					}
				}
				else {
					$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login,fio, country, reg_time, number, a_status,ref FROM users WHERE id = '$url_number' "));
					$row['reg_time'] = date('d.m.Y', strtotime($row['reg_time']));
					if ($row['country'] != 0) {
						$country = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT name FROM country WHERE country_id = '$row[country]' "));
						$row['country'] = $country['name'];
					}
					else {
						$row['country'] = 'Не указана';
					}

					if ($row['a_status'] == 1) {
						$row['a_status'] = 'Start';
					}
					else if ($row['a_status'] == 2) {
						$row['a_status'] = 'Business';
					}
					else if ($row['a_status'] == 3) {
						$row['a_status'] = 'Premium';
					}

					if ($row['ref'] != 0) {
						$ref = mysqli_fetch_assoc(mysqli_query($CONNECT,"SELECT fio,login FROM users WHERE id = '$row[ref]' "));
					}

					echo '<div class="row row-30 justify-content-center">
					<div class="col-12">
					<article class="box-contacts">
					<div class="box-contacts-body">
					<p class="box-contacts-link"><a href="binar'.$row['ref'].'">Наставник: '.$ref['fio'].'('.$ref['login'].')</a></p>
					<h3 class="box-icon-modern-big-title" style="margin-bottom: 10px;">Структура '.$row['login'].'</h3>
					<p class="box-contacts-link">ФИО: '.$row['fio'].'</p>
					<p class="box-contacts-link">Телефон: '.$row['number'].'</p>
					<p class="box-contacts-link">Страна: '.$row['country'].'</p>
					<p class="box-contacts-link">Дата регистрации: '.$row['reg_time'].'</p>
					<p class="box-contacts-link">Пакет: '.$row['a_status'].'</p>
					</div>
					</article>
					</div>
					</div>';
				}
				?>
				
			</div>
			<div class="col-sm-12 col-md-8 col-lg-4">
				<article class="box-contacts" style="background-color: mediumslateblue;">
					<div class="box-contacts-body">
						<h3 class="box-icon-modern-big-title" style="margin-bottom: 10px;">Правая ветка</h3>
						<p class="box-contacts-link" id="right_week_vp">Недельный объем: 0</p>
						<p class="box-contacts-link" id="right_total_vp">Общий объем: 0</p>
						<p class="box-contacts-link" id="r_fol_total">Кол-во партнёров: 0</p>
						<p class="box-contacts-link" id="r_fol_1">Старт: 0</p>
						<p class="box-contacts-link" id="r_fol_2">Бизнес: 0</p>
						<p class="box-contacts-link" id="r_fol_3">Премиум: 0</p>
					</div>
				</article>
			</div>
		</div>
		<?php 
		if ($url_number != $_SESSION['id']) {
			
		}
		?>
		
		<style type="text/css">
		.second-level-binar {
			flex: 0 0 25%;
			max-width: 25%;
		}
		.first-level-binar {
			flex: 0 0 50%;
			max-width: 50%;
		}
		@media (max-width: 576px) {
			.second-level-binar {
				display: none;
			}
		} 
		.main-active .box-icon-modern-icon::after {
			border-color: transparent transparent #be14ed transparent;
		}
		.left-active .box-icon-modern-icon::after {
			border-color: transparent transparent crimson transparent;
		}
		.right-active .box-icon-modern-icon::after {
			border-color: transparent transparent mediumslateblue transparent;
		}
		.box-icon-modern {
			box-shadow: 0 0 13px -4px rgba(0, 0, 0, 0.17);
		}
		.main-active.box-icon-modern:hover {
			box-shadow: 0 0 10px 0 #be14ed !important;
		}
		.left-active .box-icon-modern:hover {
			box-shadow: 0 0 10px 0 crimson !important;
		}
		.right-active .box-icon-modern:hover {
			box-shadow: 0 0 10px 0 mediumslateblue !important;
		}

		.box-icon-modern {
			max-width: 230px;
		}

		.linearicons-man:before {
			color:black !important;
		}
		
	</style>
	<a class="button button-primary button-ujarak back_butt" onclick="history.back();" href="#"  style="display: none;">К предыдущей</a>
	<a class="button button-primary button-ujarak back_butt" href="binar" style="display: none;">К своей</a>
	<div class="row row-30 justify-content-center test">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<article class="box-icon-modern box-icon-modern-2 main-active">
				<div class="box-icon-modern-icon linearicons-man"></div>
				<h5 class="box-icon-modern-title" id ="main_name">ВЫ</h5>
			</article>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6 first-level-binar ">
			<a class="a_black">
				<article class="box-icon-modern box-icon-modern-2">
					<div class="box-icon-modern-icon linearicons-man"></div>
					<h5 class="box-icon-modern-title">Свободно</h5>
				</article>
			</a>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6 first-level-binar">
			<a class="a_black">
				<article class="box-icon-modern box-icon-modern-2">
					<div class="box-icon-modern-icon linearicons-man"></div>
					<h5 class="box-icon-modern-title">Свободно</h5>
				</article>
			</a>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 second-level-binar">
			<a class="a_black">
				<article class="box-icon-modern box-icon-modern-2">
					<div class="box-icon-modern-icon linearicons-man"></div>
					<h5 class="box-icon-modern-title">Свободно</h5>
				</article>
			</a>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 second-level-binar">
			<a class="a_black">
				<article class="box-icon-modern box-icon-modern-2">
					<div class="box-icon-modern-icon linearicons-man"></div>
					<h5 class="box-icon-modern-title">Свободно</h5>
				</article>
			</a>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 second-level-binar">
			<a class="a_black">
				<article class="box-icon-modern box-icon-modern-2">
					<div class="box-icon-modern-icon linearicons-man"></div>
					<h5 class="box-icon-modern-title">Свободно</h5>
				</article>
			</a>
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3 second-level-binar">
			<a class="a_black">
				<article class="box-icon-modern box-icon-modern-2">
					<div class="box-icon-modern-icon linearicons-man"></div>
					<h5 class="box-icon-modern-title">Свободно</h5>
				</article>
			</a>
		</div>
	</div>
	<div class="row row-30 justify-content-center test">
		<div class="col-12">
			<div class="form-group">
				<input type="text" class="form-control" id="search" placeholder="Поиск" oninput="b_user_search()">
			</div>
			<div>
				<ul class="list-group" id="users_out">

				</ul>
			</div>
		</div>
	</div>
</div>
</section>


<?
footer();
?>