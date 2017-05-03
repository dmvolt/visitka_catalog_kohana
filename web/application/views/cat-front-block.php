<?php if($cats): ?>
	<div class="wrapper">
		<div class="grids">
			<div class="grid-16">
				<?php //foreach($cats as $item): ?>
					<!--<div class="grid-4 grid">
						<h4><?//= $item['descriptions'][Data::_('lang_id')]['title'] ?></h4>
						<?//= $item['descriptions'][Data::_('lang_id')]['teaser'] ?>
						<a class="button" href="<?//= Data::_('lang_uri') ?>/services/<?//= $item['alias'] ?>">Заказать услугу</a>
					</div>-->
				<?php //endforeach; ?>	
				<a href="/services" class="button-services">Заказать услугу онлайн</a>
			</div>
		</div><!--end of grids-->
	</div><!--end of wrapper-->
<?php endif; ?>