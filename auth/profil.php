<?php 
top('Профиль');
?>
<input type="hidden" id="Uid" value="<?=$_SESSION['id']?>">
<section class="section section-sm bg-default">
	<div class="container">
		<h3>Ваши данные</h3>

		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="login">Логин</label>
					<input type="text" class="form-control" id="login" disabled="disabled">
				</div>
				<div class="form-group">
					<label for="ref-link">Реф-ссылка</label>
					<input type="text" class="form-control" id="ref-link" disabled="disabled" value="https://vertexmax.com/?ref=<?=$_SESSION['id']?>" >
					<button type="button" class="btn btn-secondary copy_link" style="margin-top: 10px;" data-container="body" data-toggle="popover" data-placement="top" data-content="Реф-ссылка была скопирована">
						Скопировать
					</button>
				</div>
				<div class="form-group">
					<label for="password">Пароль</label>
					<input type="password" class="form-control" id="password" onkeyup="check_change()">
				</div>
				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="text" class="form-control" id="email" onkeyup="check_change()">
				</div>
				<div class="form-group">
					<label for="number">Телефон</label>
					<input type="text" class="form-control" id="number" onkeyup="check_change()">
				</div>
				<div class="form-group">
					<label for="fio">ФИО на латинском(как на паспорте или на карте)</label>
					<input type="text" class="form-control" id="fio" onkeyup="check_change()">
				</div>
				<div class="form-group">
					<label for="birthday">Дата рождения</label>
					<input type="date" class="form-control" id="birthday" onkeyup="check_change()" onchange="check_change()">
				</div>
				<div class="form-group">
					<label for="city">Город</label>
					<select class="form-control" id="country" style="padding: 8px 30px;" onchange="show_regions(0);">
						<option value="0">Страна</option>
						<?php 
						$result = mysqli_query($CONNECT,"SELECT country_id, name FROM country");

						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value='.$row['country_id'].'>'.$row['name'].'</option>';
						}
						?>
					</select>
					<select class="form-control" id="region" style="padding: 8px 30px;" onchange="show_cities(0);">
						<option value="0">Регион</option>
					</select>
					<select class="form-control" id="city" style="padding: 8px 30px;" onchange="check_change();">
						<option value="0">Город</option>
					</select>
				</div>
				<div class="form-group">
					<label for="ref">Логин Спонсора</label>
					<input type="text" class="form-control" disabled="disabled" id="ref">
				</div>
				<div class="form-group">
					<label for="s_status">Статус</label>
					<input type="text" class="form-control" disabled="disabled" id="s_status">
				</div>

				<div class="titleHelp"></div>
				<button type="submit" id="change_butt" disabled="disabled" class="btn btn-primary" onclick="change_data('password.email.number.country.city.fio.birthday')">Сохранить</button>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;">
				<h3>Ваш пакет</h3>
				<div class="form-group">
					<label for="a_status">Текущий</label>
					<input type="text" class="form-control" id="a_status" disabled="disabled">
				</div>
				<div class="form-group upgrade_premium">
					<label for="a_status_upgrade">Выберите пакет для апгрейда</label>
					<select class="form-control" id="a_status_upgrade" style="padding: 8px 30px;">
					</select>
				</div>

				<div class="form-group upgrade_premium">
					<label for="a_payment_method">Выберите способ оплаты</label>
					<select class="form-control" id="a_payment_method" style="padding: 8px 30px;">
						<option value="2"> Банковской картой </option>  
						<option value="1"> С баланса </option>                                              
					</select>
				</div>                

				<div class="titleHelp2"></div>
				<button id="vertex-pay-upgrade" class="btn btn-primary upgrade_premium" onclick="upgrade_paket(<?php echo $_SESSION['a_status']; ?>)">Апгрейд</button>
				<div class="tarlan-description">Безопасность платежей гарантируется ТОО “Tarlan Payments (Тарлан Пэйментс)”, которое защищает данные банковской карты по стандарту безопасности PCI DSS level 1 и технологией шифрования SSL. В случае возникновения проблем по оплате, свяжитесь со службой поддержки support@tarlanpayments.kz.</div>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8"  style="margin-top: 20px;">
				<h3>Адрес доставки</h3>
				<div class="form-group">
					<label for="adr_del">Текущий</label>
					<input type="text" class="form-control" id="adr_del">
				</div>               

				<div class="titleHelp3"></div>
				<button class="btn btn-primary" onclick="address_deliv()">Сохранить</button>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8" id="track_form"  style="margin-top: 20px;display: none;">
				<h3>Отслеживание доставки</h3>
				<div class="form-group">
					<label for="track_code">Трек код</label>
					<input type="text" class="form-control" id="track_code" disabled="disabled">
					<button type="button" class="btn btn-secondary copy_link2" style="margin-top: 10px;" data-container="body" data-toggle="popover" data-placement="top" data-content="Трек код был скопирован">
						Скопировать
					</button>
				</div>
				<a class="btn btn-secondary" href="" id="track_link" target="_blank">Перейти на сайт отслеживания</a>               
				<button class="btn btn-primary" id="track_btn" onclick="deliv_сomplete()">Получил</button>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8"  style="margin-top: 20px;">
				<h3>Инструменты</h3>
				<a class="btn btn-secondary" href="https://vertexmax.com/images/Presentation.pdf" target="_blank">Презентация на русском языке</a>
                                <a class="btn btn-secondary" href="https://vertexmax.com/images/Presentation - Kaz.pdf" target="_blank">Презентация на казахском языке</a>
				<a class="btn btn-secondary" href="https://vertexmax.com/images/Presentation - English.pdf" target="_blank">Презентация на английском языке</a> 
				<a class="btn btn-secondary" href="https://vertexmax.com/images/Presentation - Arabian.pdf" target="_blank">Презентация на арабском языке</a> 
				<a class="btn btn-secondary" href="https://vertexmax.com/images/Presentation - German.pdf" target="_blank">Презентация на немецком языке</a> 
				<a class="btn btn-secondary" href="https://vertexmax.com/images/Presentation - Turkish.pdf" target="_blank">Презентация на турецком языке</a>                
			</div>
		</div>
	</div>
</section>

<?
footer();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		var url = $('#ref-link').val();
		new Clipboard('.copy_link', {text: function(){ return url;}});
		var url2 = $('#track_code').val();
		new Clipboard('.copy_link2', {text: function(){ return url2;}});
	});
	$(function () {
		$('[data-toggle="popover"]').popover();
		setTimeout(function() {$('[data-toggle="popover"]').popover('hide')}, 2500);
	})
</script>