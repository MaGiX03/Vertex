<?php 

top('Отзывы');

?>
<style type="text/css">
.q {
  font-size: 18px;
}
.quote-modern::before {
  display: none;
}
</style>
<section class="section section-sm bg-default" style="margin-bottom: 300px;">
  <div class="container">
  	<h3>Отзывы</h3>
    <a href="#" onclick="reviews_check (0)">Не отредактированные</a> |
    <a href="#" onclick="reviews_check (1)">Отредактированные</a>
    <div class="row row-50 row-sm justify-content-center" id="withdrawal_out">
    </div>
  </div>
</section>



<?
footer();
?>