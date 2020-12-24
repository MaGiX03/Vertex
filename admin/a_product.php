<?php 
top('Управление продуктами');
?>
<script src="js/ckeditor/ckeditor.js"></script>
<section class="section section-sm bg-default">
	<div class="container">
		<h3 onclick="show_variants(1)" style="cursor: pointer;" id="add_tovar">Добавить ▼</h3>
		<h3 onclick="show_variants(2)" style="display: none;cursor: pointer;" id="change_tovar">Изменить</h3>
		<h3 onclick="show_variants(3)" style="display: none;cursor: pointer;" id="delete_tovar">Удалить</h3>
		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="add_form"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="add_name">Название</label>
					<input type="text" class="form-control" id="add_name" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="add_img">Картинка</label>
					<input type="file" class="form-control-file" id="add_img">
				</div>
				<div class="form-group">
					<label for="add_text">Описание</label>
					<textarea class="form-control" id="add_text" rows="3"></textarea>
					<script>
						CKEDITOR.replace('add_text');
					</script>
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="add_tovar(1)">Добавить</button>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8" id="change_form"  style="margin-top: 20px;display: none;">
				<div class="form-group">
					<label for="a_status">Выберите продукт</label>
					<select class="form-control" id="change_id" style="padding: 8px 30px;" onchange="show_tovar()">
						<? 
						$result = mysqli_query($CONNECT, "SELECT id, p_name FROM products");
						while($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'.$row['id'].'" id="co'.$row['id'].'">'.$row['p_name'].'</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="change_name">Название</label>
					<input type="text" class="form-control" id="change_name" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="change_img">Картинка</label>
					<input type="file" class="form-control-file" id="change_img">
				</div>
				<div class="form-group" id = 'change_text_place'>
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="add_tovar(2)">Изменить</button>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8" id="delete_form"  style="margin-top: 20px;display: none;">
				<div class="form-group">
					<label for="a_status">Выберите продукт</label>
					<select class="form-control" id="delete_id" style="padding: 8px 30px;">
						<? 
						$result = mysqli_query($CONNECT, "SELECT id, p_name FROM products");
						while($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'.$row['id'].'" id="do'.$row['id'].'">'.$row['p_name'].'</option>';
						}
						?>
					</select>
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="delete_tovar()">Удалить</button>
			</div>
		</div> 
	</div>
</section>

<section class="section section-sm bg-default" style="padding-bottom: 100px;">
	<div class="container">
		<h3>Выдача продуктов</h3>
		<div class="form-group">
			<input type="text" class="form-control" id="search" placeholder="Поиск" oninput="users_check(1)">
		</div>

		<div id="users_out">
			<ul class="list-group" >

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

<div class="modal fade" id="modalCta" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Выдать продукт</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<div class="row row-14 gutters-14">
					<div class="col-12">
						<input type="hidden" id="Uid">
						<h4 id="Pname"></h4>
						<div class="form-wrap">
							<select class="form-control" id="s_product" style="padding: 8px 30px;">
								<?
								$result = mysqli_query($CONNECT, "SELECT id, p_name FROM products");
								while ($row = mysqli_fetch_assoc($result)) {
									echo '<option value='.$row['id'].'>'.$row['p_name'].'</option>';
								}

								?>
							</select>
						</div>
						<div class="form-wrap">
							<label for="p_kolvo">Количество:</label>
							<input type="number" class="form-control" value="1" id="p_kolvo">
						</div>
					</div>
				</div>
				<div id="message"></div>
				<button class="button button-primary button-pipaluk" type="submit" onclick="give_tovar()">Выдать</button>
			</div>
		</div>
	</div>
</div>



<?
footer();
?>