<?php if($content): ?>
	<div class="wrapper">
		<div class="grids">
			<?php foreach($content as $value): ?>
				<div class="grid-8 grid">
					<h4><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></h4>
					<?= $value['descriptions'][Data::_('lang_id')]['body'] ?>
					<div class="date"><?= Text::format_date($value['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?></div>
				</div>
			<?php endforeach; ?>	
		</div><!--end of grids--> 
		<a href="/reviews">посмотреть все отзывы</a>
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="/reviews" class="">Оставить отзыв</a>
	</div><!--end of wrapper-->
<?php endif; ?>
