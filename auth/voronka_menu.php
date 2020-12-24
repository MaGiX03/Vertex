<?php 
top('Кабинет автоворонки');
?>
<style type="text/css">
.counter-amy-number {
	font-size: 50px;
}
</style>
<section class="section section-sm bg-default" style="margin-bottom: 400px;">
	<div class="container" id = "active_check">
		<div class="row justify-content-center border-2-column offset-top-xl-26"  style="margin-bottom: 50px;">
			<div class="col-9 col-sm-6">
				<div class="counter-amy">
					<div class="counter-amy-number"><span class="counter" id="total_amount"><?
					$row1 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM guests WHERE ref = '$_SESSION[id]'"));
					$row2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM guests WHERE ref = '$_SESSION[id]' AND involvement = 2 "));
					$row3 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM guests WHERE ref = '$_SESSION[id]' AND involvement = 3 "));
					$row4 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT COUNT(id) AS count FROM guests WHERE ref = '$_SESSION[id]' AND involvement = 4 "));
					echo $row1['count'];
					?></span>
				</div>
				<h6 class="counter-amy-title">Количество заявок</h6>
			</div>
		</div>
		<div class="col-9 col-sm-6">
			<div class="counter-amy">
				<div class="counter-amy-number"><span class="counter" id="current_amount"><? echo $row2['count']; ?></span>
				</div>
				<h6 class="counter-amy-title">Заинтересованные</h6>
			</div>
		</div>
		<div class="col-9 col-sm-6">
			<div class="counter-amy">
				<div class="counter-amy-number"><span class="counter" id="current_amount"><? echo $row3['count']; ?></span>
				</div>
				<h6 class="counter-amy-title">Вовлеченные</h6>
			</div>
		</div>
		<div class="col-9 col-sm-6">
			<div class="counter-amy">
				<div class="counter-amy-number"><span class="counter" id="current_amount"><? echo $row4['count']; ?></span>
				</div>
				<h6 class="counter-amy-title">Активированные</h6>
			</div>
		</div>
		<b style="margin-top: 20px;font-size: 21px;">Ваша реф-ссылка: https://vertexmax.com/?auto=<? echo $_SESSION['id'];?></b>
	</div>
	<a class="button button-primary" href="#modalCta" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Как пользоваться автоворонкой?</a>
	<br/>
	<a class="button button-primary" href="#modalCta2" data-toggle="modal" data-caption-animate="fadeInUp" data-caption-delay="200">Обучение</a>
	<div class="form-group" id="users_select" style="margin-top: 20px;">
		<label for="guest_type">Показать</label>
		<select class="form-control" id="guest_type" style="padding: 8px 30px;" onchange="guests_check()">
			<option value="0">Всех</option>
			<option value="1">Заявки</option>
			<option value="2">Заинтересованные</option>
			<option value="3">Вовлеченные</option>
			<option value="4">Активированные</option>
		</select>
	</div>
	<ul class="list-group" id="refs_out">

	</ul>

</div>
</section>
<style type="text/css">
@media (min-width: 576px) {
	.modal-dialog {
		max-width: 700px;
	}
}

</style>
<div class="modal fade" id="modalCta" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="max-width: 1000px;">
			<div class="modal-header">
				<h4>Как пользоваться автоворонкой?</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<p>С помощью автоворонки вы ежедневно будете получать поток заявок в ваш бизнес.</p>
				<p>Заявки делятся на 4 категории, определяются они по количеству звездочек.</p>
				<p>★ ★ ★ ★</p>
				<p>1.	Ваши партнеры, новички, которые уже зарегистрировались в вашу команду. У вас будут их контакты, вам необходимо с ними познакомится и как спонсор помогать им, давая информацию о компании, о продукте, о бизнес возможностях, о автоворонке. Отвечать на их вопросы и т.д.  Это суть сетевого бизнеса.</p>
				<p>★ ★ ★ ✩</p>
				<p>2.	Потенциальные партнеры, это те люди, которые заинтересовались вашим предложением и прошли регистрацию. Но по какой-то причине, не оплатили пакет. Возможно, у них не оказалось денег на карте на тот момент или возникли какие-то сомнения. У вас есть их контакты и имена. Вам надо будет позвонить и поговорить с ними. Эти люди, как правило уже готовы подписаться в вашу команду, но что-то их держит. Вам остается только заверить их, что это абсолютно легально и нет никаких рисков. За оплату в системе они получат продукт, ценность которого намного выше его стоимости. Также, они получат уникальную бизнес систему и мощный инструмент по привлечению новых партнеров. Поэтому вам, как спонсору придется поработать с такими людьми.</p>
				<p>★ ★ ✩ ✩</p>
				<p>3.	Заинтересованные. Это люди, которые зашли на сайт автоворонки посмотрели всю информацию, проявили интерес, нажали на кнопку начать зарабатывать, но не довели регистрацию до конца. Эти люди наполовину заинтересованы или не совсем поняли суть автоворонки. С ними тоже можно будет поработать, в свободное время.</p>
				<p>★ ✩ ✩ ✩</p>
				<p>4.	Незаинтересованные люди. Их контакты у вас тоже будут. Эти люди, которые зашли на сайт вашей автоворонки, посмотрели информацию, но не проявили интерес. Этих людей мы пока трогать не будем. Думаю, на них у вас уже время не будет. Вам вполне хватит первые три категории людей.</p>

				<p>Автоматизированная система рекрутирования эффективно поможет построить ваш бизнес. </p>
				<p>Но для этого вам придется рекламировать вашу реферальную ссылку автоворонки.</p>
				<p>Ваша реферальная ссылка находится в разделе ВАШИ ДАННЫЕ.</p>
				<p>Для начала отправляйте свою ссылку всем своим знакомым. И вы с первых дней увидите результаты. </p>
				<p>Чтобы рост вашей команды был очень быстрым, воспользуйтесь нашим обучением таргетингу. Также, Вы можете воспользоваться услугами таргетологов.</p>
				<p>Желаем вам успехов и процветании вместе с компанией Vertex Max!</p>

				<p>Немножко полезной информации:</p>
				<p>Почему не все люди регистрируются, посмотрев информацию в автоворонке?</p>
				<p>Как я уже писал выше, оставившие заявку люди, делятся на 4 категории. Первая категория людей уже ваши партнеры. Давайте поговорим о 2-й и 3-ей категории людей, оставивших заявку.</p>
				<p>Вторая категория людей заинтересованы вашим предложением и у них есть желание начать этот замечательный бизнес. Но по какой-то причине, они не зарегистрировались. Этих причин может быть несколько. Одна из таких причин, это сомнение. Человеку свойственно сомневаться, особенно, когда надо за что-то заплатить. Когда человек понимает, что надо потратить какую-то сумму на бизнес, с которым только, что познакомился. В такой момент человека одолевают разные сомнение. Может это пирамида или лохотрон. Может они просто хотят забрать мои деньги. Я ничего не знаю, об этой компании. Зарегистрироваться я всегда успею, надо не спеша подумать. Люди не хотят терять деньги, у них подключается защитный рефлекс и с психологической точки зрения, это нормальное поведение. С людьми второй категории очень легко работать. Они уже заинтересованы вашим бизнесом. Вам придется с ними немножко поработать, как говориться добить их. Познакомьтесь с ними, пообщайтесь, узнайте, почему они не завершили регистрацию. Ответьте на их вопросы, развейте их сомнения, и они тоже станут вашими партнерами!</p>
				<p>Третья категория людей тоже заинтересованы вашим предложением. Раз они оказались на вашей странице и оставили свои данные, то эти люди, также ищут новые возможности построить бизнес. С ними тоже можно поработать, но с этой категорией людей будет работать немножко сложнее. В любом случае легче, чем искать новых людей. Если у вас есть время, вы можете смело поработать с людьми этой категории. Некоторые из них тоже станут вашими партнерами, если вы сумеете их убедить.</p>
				<p>Как вы поняли, ничего сложного в нашем бизнесе нет. Автоворонка поможет вам построить ваш бизнес!</p>
				<p>Вы можете лежать на диване и строить свой бизнес за счет людей 1-й категории.</p>
				<p>Вы можете увеличить скорость роста вашего бизнеса в несколько раз, общаясь с людьми 2-й и 3-ей категории. </p>
				<p>Если у вас возникли вопросы, обращайтесь к своему куратору (спонсору), у вас есть его данные.</p>
				<p>А мы, со своей стороны, хотим пожелать вам огромной структуры и безграничного богатства!</p>

			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modalCta2" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Обучение</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px;">
					<video  controls controlsList="nodownload" >
						<source src="video/1.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
						Тег video не поддерживается вашим браузером. 
					</video>
				</div>
				<h5>Урок 1</h5>
				<div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px;">
					<video  controls controlsList="nodownload" >
						<source src="video/2.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
						Тег video не поддерживается вашим браузером. 
					</video>
				</div>
				<h5>Урок 2</h5>
				<div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px;">
					<video  controls controlsList="nodownload" >
						<source src="video/3.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
						Тег video не поддерживается вашим браузером. 
					</video>
				</div>
				<h5>Урок 3</h5>
				<div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px;">
					<video  controls controlsList="nodownload" >
						<source src="video/4.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
						Тег video не поддерживается вашим браузером. 
					</video>
				</div>
				<h5>Урок 4</h5>
			</div>
		</div>
	</div>
</div>

<?
footer();
?>
<script type="text/javascript">
	$("video").on("contextmenu", false);
</script>