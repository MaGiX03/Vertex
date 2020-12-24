<?php 
top('Отзыв');
?>
<section class="section section-sm bg-default">
	<div class="container">
		<h3>Написать отзыв</h3>
		<div class="row row-30 justify-content-center">
			<div class="col-sm-12 col-md-10 col-lg-8" id="add_form"  style="margin-top: 20px;">
				<div class="form-group">
					<label for="add_name">Имя</label>
					<input type="text" class="form-control" id="r_name" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="add_text">Комментарий</label>
					<textarea class="form-control" id="r_text" rows="3"></textarea>
				</div>
				<div class="titleHelp"></div>
				<button type="submit" class="btn btn-primary" onclick="send_review('r_name.r_text')">Отправить</button>
			</div>
		</div> 
	</div>
</section>

<?
footer();
?>