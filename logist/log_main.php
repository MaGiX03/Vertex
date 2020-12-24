<?php 
top('Пользователи');
?>

<section class="section section-sm bg-default" style="padding-bottom: 300px;">
	<div class="container">
		<div class="form-group">
			<input type="text" class="form-control" id="search" placeholder="Поиск" oninput="users_check()">
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