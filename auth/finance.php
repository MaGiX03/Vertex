<?php 
top('Баланс');
$date = date('Y-m');
$date = date('Y-m-d H:i:s', strtotime($date));
$balance = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT u.balance, u.point, l.summa FROM users u INNER JOIN user_logs l ON u.id = l.user_id WHERE u.id = '$_SESSION[id]' AND log_type = 8 "));
$summa = mysqli_fetch_assoc(mysqli_query($CONNECT,"SELECT SUM(summa) AS sum FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 2 "));
$summa_m = mysqli_fetch_assoc(mysqli_query($CONNECT,"SELECT SUM(summa) AS sum FROM user_logs WHERE user_id = '$_SESSION[id]' AND log_type = 2 AND input_date > '$date' "));
$balance['balance'] = number_format($balance['balance'], 2, ',', ' ');
$summa['sum'] = number_format($summa['sum'], 2, ',', ' ');
$summa_m['sum'] = number_format($summa_m['sum'], 2, ',', ' ');
?>
<style type="text/css">
.counter-amy-number {
	font-size: 70px;
}
</style>
<input type="hidden" id="Uid" value="<?php echo $_SESSION['id']; ?>">
<section class="section section-sm bg-default" style="margin-bottom: 100px;">
	<div class="container">
		<div class="row justify-content-center offset-top-xl-26">
			<div class="col-12 col-sm-12">
				<div class="counter-amy" >
					<div class="counter-amy-number"><span id="balance"><? echo $balance['balance']; ?></span>
					</div>
					<h6 class="counter-amy-title">Баланс</h6>
				</div>
			</div>
			<? 
				if ($balance['summa'] > 0) echo '<div class="col-9 col-sm-6">
				<div class="counter-amy" >
					<div class="counter-amy-number"><span class="counter" id="balance">'.$balance['summa'].'</span>
					</div>
					<h6 class="counter-amy-title">sp</h6>
				</div>
			</div>';
			?>
			
			<div class="col-9 col-sm-6">
				<div class="counter-amy" >
					<div class="counter-amy-number"><span class="counter" id="balance"><? echo $balance['point']; ?></span>
					</div>
					<h6 class="counter-amy-title">Бонусные баллы</h6>
				</div>
			</div>
			<div class="col-12 col-sm-12">
				<div class="counter-amy" >
					<div class="counter-amy-number"><span  id="balance"><? echo $summa_m['sum']; ?></span>
					</div>
					<h6 class="counter-amy-title">Доход за месяц</h6>
				</div>
			</div>
			<div class="col-12 col-sm-12">
				<div class="counter-amy" >
					<div class="counter-amy-number"><span  id="balance"><? echo $summa['sum']; ?></span>
					</div>
					<h6 class="counter-amy-title">Доход</h6>
				</div>
			</div>
		</div>
		<h3>Заявка на вывод денежных средств</h3>
		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="w_sum">Сумма денежных средств</label>
					<input type="text" class="form-control" id="w_sum" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="w_aim">Номер карты</label>
					<input type="text" class="form-control" id="w_aim">
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="withdraw( )">Отправить заявку</button>
			</div>
		</div>
		<h3>Перевод денежных средств</h3>
		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="t_sum">Сумма денежных средств</label>
					<input type="text" class="form-control" id="t_sum">
				</div>
				<div class="form-group">
					<label for="t_aim">Логин пользователя, который получит денежные средства</label>
					<input type="text" class="form-control" id="t_aim" oninput="check_login()">
				</div>
				<div id="transfer_fio"></div>
				<div class="titleHelp2"></div>
				<button type="submit" class="btn btn-primary" id="transfer_btn" disabled="disabled" onclick="transfer( )">Перевести</button>
			</div>
		</div>
		<h3>Пополнить баланс</h3>
		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="p_sum">Сумма денежных средств</label>
					<input type="text" class="form-control" id="p_sum">
				</div>
				<div class="titleHelp3"></div>
				<button type="submit" id="butt1" class="btn btn-primary" onclick="popolnit('<?php echo $_SESSION['login']; ?>')">Пополнить</button>
			</div>
		</div>

	</div>
</section>

<?
footer();
?>