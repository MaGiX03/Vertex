<?php 
top('Пользователи');
?>

<section class="section section-sm bg-default" style="padding-bottom: 100px;">
	<div class="container">
		<div class="form-group">
			<input type="text" class="form-control" id="search" placeholder="Поиск" oninput="users_check(1)">
		</div>

		<div >
			<ul class="list-group" id="users_out">

			</ul>
		</div>
		<div class="form-group" id="users_select">
			<label for="a_status">Страница</label>
			<select class="form-control" id="users_count" style="padding: 8px 30px;" onchange="users_check(0)">
				<option>1</option>
			</select>
		</div>
	</div>
</section>

<section class="section section-sm bg-default" id='user_data'>
	<div class="container">
		<h3>Данные</h3>
		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="reg">
				<input type="hidden" id="Uid">
				<div class="form-group">
					<label for="Uname">Логин</label>
					<input type="text" class="form-control" id="Uname" aria-describedby="emailHelp" disabled="disabled">
				</div>
				<div class="form-group">
					<label for="Upassword">Пароль</label>
					<input type="text" class="form-control" id="Upassword">
				</div>
				<div class="form-group">
					<label for="Umail">E-mail</label>
					<input type="email" class="form-control" id="Umail" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="Unumber">Телефон</label>
					<input type="text" class="form-control" id="Unumber">
				</div>
				<div class="form-group">
					<label for="Ufio">ФИО</label>
					<input type="text" class="form-control" id="Ufio">
				</div>
				<div class="form-group">
					<label for="Ubirthday">Дата рождения</label>
					<input type="date" class="form-control" id="Ubirthday">
				</div>
				<div class="form-group">
					<label for="Ucity">Город</label>
					<select class="form-control" id="Ucountry" style="padding: 8px 30px;" onchange="show_regions(0);">
						<option value="0">Страна</option>
						<?php 
						$result = mysqli_query($CONNECT,"SELECT country_id, name FROM country");

						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value='.$row['country_id'].'>'.$row['name'].'</option>';
						}
						?>
					</select>
					<select class="form-control" id="Uregion" style="padding: 8px 30px;" onchange="show_cities(0);">
						<option value="0">Регион</option>
					</select>
					<select class="form-control" id="Ucity" style="padding: 8px 30px;">
						<option value="0">Город</option>
					</select>
				</div>
				<div class="form-group">
					<label for="Uref">Логин спонсора</label>
					<input type="text" class="form-control" id="Uref" disabled="disabled">
				</div>
				<div class="form-group">
					<label for="Ubalance">Баланс</label>
					<input type="text" class="form-control" id="Ubalance" disabled="disabled">
				</div>
				<div class="form-group">
					<label for="Upaket">Пакет</label>
					<input type="text" class="form-control" id="Upaket" disabled="disabled" style="margin-bottom: 5px;">
					<button id="upgrade1" type="submit" class="btn btn-primary" disabled="disabled" onclick="upgrade_user(2)">Апгрейд Бизнес</button>
					<button id="upgrade2" type="submit" class="btn btn-primary" disabled="disabled" onclick="upgrade_user(3)">Апгрейд Премиум</button>
					<div class="titleHelp1"></div>
				</div>
				<div class="form-group">
					<label for="Ustatus">Статус</label>
					<input type="text" class="form-control" id="Ustatus" disabled="disabled">
				</div>
				<div class="form-group">
					<label for="Uregtime">Дата регистрации</label>
					<input type="text" class="form-control" id="Uregtime" disabled="disabled">
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="change_user_data('Uid.Upassword.Umail.Unumber.Ucity.Ubalance.Ufio.Ubirthday' )">Изменить</button>
			</div>
		</div> 
	</div>
</section>

<?
footer();
?>