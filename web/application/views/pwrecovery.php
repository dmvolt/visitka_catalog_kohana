<section class="site-row site-padding">
	<?= Search::get_search_block() ?>
</section>
<section class="site-row site-padding">
	<h2><?= $page_title ?></h2>
	<form action="" method="post">		
		<input type="text" name="email" id="email_recovery" class="text" placeholder="Введите ваш e-mail">
		<input type="submit" value="Восстановить" name="btnsubmit"  class="button">
	</form>
</section>
<section class="site-row wide-row">
	<div class="site-row site-padding disclamer">
		Возможны противопоказания. Необходима предварительная<br>консультация врача. Лицензия №&nbsp;ЛО-54-01-002331
	</div>
</section>