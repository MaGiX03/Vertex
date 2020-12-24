<?php 

top('История');

?>
<style type="text/css">
.q {
  font-size: 18px;
}
.quote-modern::before {
  display: none;
}
</style>
<section class="section section-sm bg-default" style="margin-bottom: 100px;">
  <div class="container">
    <h2>История</h2>
    <div class="row row-30 justify-content-center">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <label for="logs_val">Тип</label>
        <select class="form-control" id="logs_val" style="padding: 8px 30px;" onchange="logs_check()">
          <option value="0">Все</option>
          <option value="1">Покупки</option>
          <option value="2">Начисления</option>
          <option value="4">Выводы</option>
          <option value="12">Уведомления</option>
        </select>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <label for="date_order">Сортировать по дате</label>
        <select class="form-control" id="date_order" style="padding: 8px 30px;" onchange="logs_check()">
          <option value="1">Сперва новые</option>
          <option value="2">Сперва старые</option>
        </select>
      </div>
    </div>
    <div class="row row-50 row-sm justify-content-center" id="logs_out">
    </div>
  </div>
</section>


<?
footer();
?>