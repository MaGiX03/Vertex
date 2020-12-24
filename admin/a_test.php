<?php 
top('Админка');
?>

<section class="section section-sm bg-default">
	<div class="container">
		<h3>Админ</h3>

		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="login">id</label>
					<input type="text" class="form-control" id="id" aria-describedby="emailHelp">
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="test()">Тест</button>
				<button type="submit" class="btn btn-primary" onclick="post_query( 'a_function', 'test2', 'id' )">Тест 2</button>
			</div>
		</div>
		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="auth"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="count">Кол-во</label>
					<input type="text" class="form-control" id="count">
				</div>
				<div class="titleHelp2"></div>
				<button type="submit" class="btn btn-primary" onclick="post_query( 'a_function', 'test3', 'count' )">Тест 3</button>
			</div>
		</div>
	</div>
</section>


<?
footer();
?>