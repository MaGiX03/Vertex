<?php 
top('Активация');
?>

<section class="section section-sm bg-default" style="padding-bottom: 100px;">
	<div class="container">
		<div class="form-group">
			<input type="text" class="form-control" id="search" placeholder="Поиск" oninput="users_check(1)">
		</div>
		<div class="form-group" id="users_select">
			<label for="a_status">Страница</label>
			<select class="form-control" id="users_count" style="padding: 8px 30px;" onchange="users_check(0)">
				<option>1</option>
			</select>
		</div>
		<div id="users_out">
			<ul class="list-group" >

			</ul>
		</div>
	</div>
</section>
<?
footer();
?>

