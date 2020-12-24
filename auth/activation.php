<?php 
top('Активация');

$tarlan_user = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login,ref FROM users WHERE id = '$_SESSION[id]' "));
$ref = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT fio, number, login FROM users WHERE id = '$_SESSION[ref]' "));
?>
<input type="hidden" id="Uid" value="<?=$_SESSION['id']?>">
<section class="section section-sm bg-default">
	<div class="container">
		<h4>Поздравляем вас с регистрацией VertexMax</h4>
		<h4>Ваш наставник: <?php echo $ref['fio']; ?></h4>
		<h4>Логин: <?php echo $ref['login']; ?></h4>
		<h4>Телефон: <?php echo $ref['number']; ?></h4>
		<h3>Активация</h3>
		<?
		if (!mysqli_num_rows(mysqli_query($CONNECT, "SELECT id FROM users WHERE id = '$tarlan_user[ref]' AND a_status != 0 "))) {
			echo "<style>.user_activation {display:none;}</style>";
			echo "<h4 style='margin-bottom: 300px;margin-top:50px;'>Вы не можете активироваться, так как ваш спонсор не активирован</h4>";
		}
		?>
		<div class="row row-30 justify-content-center user_activation">
			<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="paket">Выберите пакет</label>
					<select class="form-control" id="paket" style="padding: 8px 30px;">
						<option value="1">Старт (1 продукт на выбор)</option>
						<option value="2">Бизнес (3 продукта на выбор)</option>
						<option value="3">Премиум (8 продуктов на выбор)</option>
					</select>
				</div>
				<div class="form-group">
					<label for="pay_type">Выберите способ оплаты</label>
					<select class="form-control" id="pay_type" style="padding: 8px 30px;" onchange="pay_type()">
						<option value="1">Банковской картой</option>
						<option value="2">С баланса</option>
					</select>
				</div>
				<div class="titleHelp"></div>
				<h3 id = 'ne_rabotaet' style="display: none;">Этот способ оплаты временно не доступен</h3>
				<?php
				$tarlan_user_login = "'" . $tarlan_user['login'] . "'";
				echo '<button type="submit" id="butt1" class="btn btn-primary" onclick="activationPayWithCard(' . $tarlan_user_login . ')">Оплатить</button>'; ?>
				<button type="submit" id="butt2" class="btn btn-primary" style="display: none;" onclick="post_query( 'gform', 'user_activation', 'paket' )">Оплатить</button>
                <div class="tarlan-description">Безопасность платежей гарантируется ТОО “Tarlan Payments (Тарлан Пэйментс)”, которое защищает данные банковской карты по стандарту безопасности PCI DSS level 1 и технологией шифрования SSL. В случае возникновения проблем по оплате, свяжитесь со службой поддержки support@tarlanpayments.kz.</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	let timerId = setInterval(() => check_status(), 30000);

	function check_status() {
		$.ajax(

	{
		url : '/gform',
		type: 'POST',
		data: 'check_status_f=1',
		cache: false,
		success: function( result ) {

			if ( result == 1 ) {
				window.open('https://vertexmax.com/profil'); 
			}

		}

	}

	);
	}
</script>

<?
footer();
?>