<?php 

top('Заявки на вывод');

?>
<style type="text/css">
.q {
  font-size: 18px;
}
.quote-modern::before {
  display: none;
}
</style>
<section class="section section-sm bg-default" style="margin-bottom: 200px;">
  <div class="container">
    <div class="row row-30 justify-content-center">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <label for="logs_val">Тип</label>
        <br/>
        <a href="#" onclick="withdrawal_check(0)">Вывод</a> |
        <a href="#" onclick="withdrawal_check(1)">Вывод(История)</a> |
        <a href="#" onclick="withdrawal_check(2)">Продукт</a> |
        <a href="#" onclick="withdrawal_check(3)">Продукт(История)</a>
      </div>
      <input class="form-control" type="text" placeholder="Поиск по логину" id="w_search" oninput="withdrawal_check(4)"/>
      <input class="form-control" type="date" id="withdrawal_date" value="<?php echo date('Y-m-d'); ?>" onchange="withdrawal_check(4)">
      <input type="hidden" id="withdrawal_val" value="0">
      <div class="form-group" id="withdrawal_select">
        <label for="a_status">Страница</label>
        <select class="form-control" id="withdrawal_count" style="padding: 8px 30px;" onchange="withdrawal_check(5)">
          <option>1</option>
        </select>
      </div>
    </div>
    <div class="row row-50 row-sm justify-content-center" id="withdrawal_out">
    </div>
  </div>
</section>



<?
footer();
?>