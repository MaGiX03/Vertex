<?php 
top('Управление офисами');
?>
<script src="js/ckeditor/ckeditor.js"></script>
<section class="section section-sm bg-default">
	<div class="container">
		<h3 onclick="show_variants(1)" style="cursor: pointer;" id="add_tovar">Добавить ▼</h3>
		<h3 onclick="show_variants(2)" style="display: none;cursor: pointer;" id="change_tovar">Изменить/Удалить</h3>
		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="add_form"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="add_city">Город</label>
					<input type="text" class="form-control" id="add_city">
				</div>
				<div class="form-group">
					<label for="add_address">Адрес</label>
					<input type="text" class="form-control" id="add_address">
				</div>
				<div class="form-group">
					<label for="add_number">Номер</label>
					<input type="text" class="form-control" id="add_number">
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="office_data(1)">Добавить</button>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8" id="change_form"  style="margin-top: 20px;display: none;">
				<div class="form-group">
					<label for="a_status">Выберите продукт</label>
					<select class="form-control" id="change_id" style="padding: 8px 30px;" onchange="show_office()">
						<? 
						$result = mysqli_query($CONNECT, "SELECT id, city FROM offices");
						while($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'.$row['id'].'" id="co'.$row['id'].'">'.$row['city'].'</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="ch_city">Город</label>
					<input type="text" class="form-control" id="ch_city">
				</div>
				<div class="form-group">
					<label for="ch_address">Адрес</label>
					<input type="text" class="form-control" id="ch_address">
				</div>
				<div class="form-group">
					<label for="ch_number">Номер</label>
					<input type="text" class="form-control" id="ch_number">
				</div>
				<div class="form-group" id = 'change_text_place'>
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="office_data(2)">Изменить</button>
				<button type="submit" class="btn btn-primary" onclick="office_data(3)">Удалить</button>
			</div>
		</div> 
	</div>
</section>




<?
footer();
?>