<?php 
top('Рефералы');
if ($url_number == 0) $url_number = $_SESSION['id'];
?>
<style type="text/css">
.counter-amy-number {
	font-size: 70px;
}
.symbol {
	font-size: 35px !important;
}
</style>
<input type="hidden" id="uid" value="<?=$url_number?>">
<section class="section section-sm bg-default" style="margin-bottom: 100px;">
	<div class="container">
		<div class="row justify-content-center border-2-column offset-top-xl-26" style="margin-bottom: 50px;">
			<div class="col-9 col-sm-6">
				<div class="counter-amy">
					<div class="counter-amy-number"><span class="counter" id="total_amount"><?
					$s_bonus = date('Y-m');
					$s_bonus_date = date('Y-m-d H:i:s', strtotime($s_bonus));
					$count = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS a FROM user_logs WHERE user_id = '$url_number' AND log_type = 1 AND input_date < '$s_bonus_date' AND summa != 0 "));
					$total_buy = $count['a']*10;
					$count = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS a FROM user_logs WHERE user_id = '$url_number' AND log_type = 1 AND input_date >= '$s_bonus_date' AND summa != 0 "));
					$week_buy = $count['a']*10;
					$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT current_amount, total_amount FROM s_bonus_log WHERE user_id = '$url_number' "));
					echo $row['total_amount'];
					?></span><span class="symbol">vp</span>
				</div>
				<h6 class="counter-amy-title">Общий объем</h6>
			</div>
		</div>
		<div class="col-9 col-sm-6">
			<div class="counter-amy">
				<div class="counter-amy-number"><span class="counter" id="current_amount"><? echo $row['current_amount']; ?></span><span class="symbol">vp</span>
				</div>
				<h6 class="counter-amy-title">Месячный объем</h6>
			</div>
		</div>
		<div class="col-9 col-sm-6">
			<div class="counter-amy">
				<div class="counter-amy-number"><span class="counter" id="current_amount"><? echo $total_buy; ?></span><span class="symbol">vp</span>
				</div>
				<h6 class="counter-amy-title">Общий личный объем</h6>
			</div>
		</div>
		<div class="col-9 col-sm-6">
			<div class="counter-amy">
				<div class="counter-amy-number"><span class="counter" id="current_amount"><? echo $week_buy; ?></span><span class="symbol">vp</span>
				</div>
				<h6 class="counter-amy-title">Месячный личный объем</h6>
			</div>
		</div>
	</div>
	<?php 
		if ($_SESSION['id'] == $url_number) echo '<h2>Ваши личники</h2>';
		else {
			$login = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT login FROM users WHERE id = '$url_number' "));
			echo '<h2>Личники '.$login['login'].'</h2>';
		} 
	?>
	
	<ul class="list-group" id="refs_out">

	</ul>

	<div class="row row-30 justify-content-center test">
		<div class="col-12">
			<div class="form-group">
				<input type="text" class="form-control" id="search" placeholder="Поиск" oninput="s_user_search()">
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