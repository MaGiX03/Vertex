<?php 
top('Выдача продуктов');
?>

<section class="section section-sm bg-default" style="padding-bottom: 200px;">
	<div class="container">
		<h3>Выдача продуктов</h3>
		<div class="form-group">
			<input type="text" class="form-control" id="search" placeholder="Поиск" oninput="users_sp_check(1)">
		</div>

		<div id="users_out">
			<ul class="list-group" >

			</ul>
		</div>
		<div class="form-group" id="users_select">
			<label for="a_status">Страница</label>
			<select class="form-control" id="users_count" style="padding: 8px 30px;" onchange="users_sp_check(0)">
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
<script type="text/javascript">
	users_sp_check(0);
	users_sp_count();
</script>