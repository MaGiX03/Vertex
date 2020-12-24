<?php 
top('Продукты');
?>

<section class="section section-sm bg-default" id="news">
	<div class="container">
		<h2>Продукты</h2>
		<a href="https://vertexmax.com/sertificate" class="button button-primary button-ujarak" target="_blank">Посмотреть сертификаты</a>
		<div class="row row-45">
			<?
			$result = mysqli_query($CONNECT, "SELECT * FROM products");
			while ($row = mysqli_fetch_assoc($result)) {
			    if ($row['id'] != 13) {
				echo '<div class="col-sm-6 col-lg-4 wow fadeInLeft">
				<article class="post post-modern"><a class="post-modern-figure" href="product'.$row['id'].'"><img src="images/product/'.$row['p_img'].'" width="370" height="307"/ style="max-width: 200px;max-height: 200px;">
				</a>
				<h4 class="post-modern-title"><a href="product'.$row['id'].'" id = "t'.$row['id'].'">'.$row['p_name'].'</a></h4>
				<p>'.$row['p_desc'].'</p>
				<button id = "tovar'.$row['id'].'" class="button button-primary" onclick="choose_tovar('.$row['id'].')" href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Купить</button>
				</article>
				</div>';

			    }
			    else {
			        echo '<div class="col-sm-6 col-lg-4 wow fadeInLeft">
				<article class="post post-modern"><a class="post-modern-figure" href="product'.$row['id'].'"><img src="images/product/'.$row['p_img'].'" width="370" height="307"/ style="max-width: 200px;max-height: 200px;">
				</a>
				<h4 class="post-modern-title"><a href="product'.$row['id'].'" id = "t'.$row['id'].'">'.$row['p_name'].'</a></h4>
				<p>'.$row['p_desc'].'</p>
				</article>
				</div>';
			    } 
			    
			}
			?>
		</div>
	</div>
</section>

<div class="modal fade" id="modalCta" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Выберите способ оплаты</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<div class="row row-14 gutters-14">
					<div class="col-12">
						<input type="hidden" id="Pid">
						<h4 id="Pname"></h4>
						<div class="form-wrap">
							<select class="form-control" id="pay_type" style="padding: 8px 30px;">
								<option id="pay_type4" value="4" style="display: none;">sp</option>
                                <option value="3">Банковской картой</option>
								<option id="pay_type1" value="1">Бонусные баллы</option>
								<option id="pay_type2" value="2">С баланса</option>								
							</select>
						</div>
					</div>
				</div>
				<div id="message"></div>
				<button id="vertex-product-pay" class="button button-primary button-pipaluk" type="submit" onclick="buy_tovar()">Купить</button>
                <div class="tarlan-description">Безопасность платежей гарантируется ТОО “Tarlan Payments (Тарлан Пэйментс)”, которое защищает данные банковской карты по стандарту безопасности PCI DSS level 1 и технологией шифрования SSL. В случае возникновения проблем по оплате, свяжитесь со службой поддержки support@tarlanpayments.kz.</div>
			</div>
		</div>
	</div>
</div>

<?
footer();
?>