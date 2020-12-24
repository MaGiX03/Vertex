<?php 
top('Статистика');
?>
<style type="text/css">
.nav-linkb {
	font-size: 18px !important;
}
.counter-amy-number {
	font-size: 40px;
}
.symbol {
	font-size: 40px !important;
}
</style>
<section class="section section-sm bg-default" style="margin-bottom: 200px;">
	<div class="container">
		<!-- Bootstrap tabs-->
		<div class="tabs-custom tabs-horizontal tabs-line tabs-line-big text-center text-md-left" id="tabs-6">
			<!-- Nav tabs-->
			<ul class="nav nav-tabs">
				<li class="nav-item" role="presentation"><a class="nav-link nav-linkb active" href="#tabs-6-1" data-toggle="tab">Статистика</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link nav-linkb" href="#tabs-6-2" data-toggle="tab">Партнеры</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link nav-linkb" href="#tabs-6-3" data-toggle="tab">Партнеры в статусе</a></li>
				<li class="nav-item" role="presentation"><a class="nav-link nav-linkb" href="#tabs-6-4" data-toggle="tab">По периоду</a></li>
			</ul> 
			<!-- Tab panes-->
			<div class="tab-content">
				<div class="tab-pane fade show active" id="tabs-6-1">
					<div class="row justify-content-center border-2-column offset-top-xl-26">
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1">2</span><span class="symbol">$</span>
								</div>
								<h6 class="counter-amy-title">Баланс компании</h6>
								<button style="margin-top: 10px;" class="button button-secondary" onclick="spisat_modal('ComBalance')" href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Списать</button>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1">40</span><span class="symbol">$</span>
								</div>
								<h6 class="counter-amy-title">Начисления</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1">12</span><span class="symbol">$</span>
								</div>
								<h6 class="counter-amy-title">Выведено</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1"></span><span class="symbol">$</span>
								</div>
								<h6 class="counter-amy-title">Баланс пользователей</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1">12</span><span class="symbol">$</span>
								</div>
								<h6 class="counter-amy-title">На продукцию с регистрации</h6>
								<button style="margin-top: 10px;" class="button button-secondary" onclick="spisat_modal('ProdReg')" href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Списать</button>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1"></span><span class="symbol">$</span>
								</div>
								<h6 class="counter-amy-title">На продукцию с активации</h6>
								<button style="margin-top: 10px;" class="button button-secondary" onclick="spisat_modal('ProdAct')" href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Списать</button>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1">12</span><span class="symbol">$</span>
								</div>
								<h6 class="counter-amy-title">Офисные</h6>
								<button style="margin-top: 10px;" class="button button-secondary" onclick="spisat_modal('ComOffice')" href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Списать</button>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1"></span><span class="symbol">$</span>
								</div>
								<h6 class="counter-amy-title">За доставку</h6>
								<button style="margin-top: 10px;" class="button button-secondary" onclick="spisat_modal('ComDelivery')" href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Списать</button>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter1"></span>
								</div>
								<h6 class="counter-amy-title">Кол-во вторичных покупок</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="tabs-6-2">
					<div class="row justify-content-center border-2-column offset-top-xl-26">
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter2">2</span>
								</div>
								<h6 class="counter-amy-title">Start</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter2">40</span>
								</div>
								<h6 class="counter-amy-title">Business</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter2">12</span>
								</div>
								<h6 class="counter-amy-title">Premium</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter2">12</span>
								</div>
								<h6 class="counter-amy-title">Количество</h6>
							</div>
						</div>
						<div class="col-12">
							<ul class="list-group">
								<?php 
									$result = mysqli_query($CONNECT, "SELECT country_id, name FROM country");
									while ($row = mysqli_fetch_assoc($result)) {
										$count = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM users WHERE country = '$row[country_id]' "));
										echo '<li class="list-group-item">'.$row['name'].' - '.$count['count'].'</li>';
									}
								?>
							</ul>
							
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="tabs-6-3">
					<div class="row justify-content-center border-2-column offset-top-xl-26">
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">2</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(1)" style="cursor: pointer;">Manager</h6>
								<div id ="partners1"></div>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">40</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(2)" style="cursor: pointer;">Bronze</h6>
								<div id ="partners2"></div>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">12</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(3)" style="cursor: pointer;">Silver</h6>
								<div id ="partners3"></div>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">160</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(4)" style="cursor: pointer;">Gold Director</h6>
								<div id ="partners4"></div>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">160</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(5)" style="cursor: pointer;">Emerald Director</h6>
								<div id ="partners5"></div>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">160</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(6)" style="cursor: pointer;">Platinum Director</h6>
								<div id ="partners6"></div>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">160</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(7)" style="cursor: pointer;">Diamond Director</h6>
								<div id ="partners7"></div>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">160</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(8)" style="cursor: pointer;">Ambassador</h6>
								<div id ="partners8"></div>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter3">160</span>
								</div>
								<h6 class="counter-amy-title" onclick="show_partners(9)" style="cursor: pointer;">Акционер</h6>
								<div id ="partners9"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="tabs-6-4">
					<div class="form-group">
						<label for="city">Дата</label>
						<div class="row row-30 justify-content-center">
							<div class="col-6 col-xs-6 col-md-6 col-lg-6">
								<input class="form-control" type="date" id="stats_date1" />
							</div>
							<div class="col-6 col-xs-6 col-md-6 col-lg-6">
								<input class="form-control" type="date" id="stats_date2" />
							</div>
							<div class="col-12">
								<button class="btn btn-primary" onclick="stats_date(1)">Применить</button>
								<button class="btn btn-dark" onclick="stats_date(0)">Отменить</button>
							</div>
						</div>
					</div>
					<div class="row justify-content-center border-2-column offset-top-xl-26">
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter4">0</span>
								</div>
								<h6 class="counter-amy-title">Начисления</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter4">0</span>
								</div>
								<h6 class="counter-amy-title">Выводы</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter4">0</span>
								</div>
								<h6 class="counter-amy-title">Start</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter4">0</span>
								</div>
								<h6 class="counter-amy-title">Business</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter4">0</span>
								</div>
								<h6 class="counter-amy-title">Premium</h6>
							</div>
						</div>
						<div class="col-9 col-sm-6">
							<div class="counter-amy">
								<div class="counter-amy-number"><span class="counter4">0</span>
								</div>
								<h6 class="counter-amy-title">Общий приход</h6>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<div class="modal fade" id="modalCta" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Укажите сумму списания</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<div class="row row-14 gutters-14">
					<div class="col-12">
						<input type="hidden" id="Sname">
						<div class="form-wrap">
							<input class="form-control" type="text" id="Svalue" value="0">
						</div>
					</div>
				</div>
				<div id="message"></div>
				<button class="button button-primary button-pipaluk" type="submit" onclick="stats_spisat()">Списать</button>
			</div>
		</div>
	</div>
</div>
<?
footer();
?>