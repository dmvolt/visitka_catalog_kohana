<div class="content-row wide-row search-row">
	<div class="content-row">
		<?= Search::get_search_block() ?>
	</div>
</div>
<div class="content-row wide-row ar-bottom">
	<?php if($action): ?>
		<div class="content-row breadcrumbs-row">
			<?= Breadcrumbs::get_breadcrumbs($action['id'], 'actions') ?>
		</div>
		<action>
			<h1><?= $action['descriptions'][Data::_('lang_id')]['title'] ?></h1>
			<?= $action['descriptions'][Data::_('lang_id')]['body'] ?>
		</action>
		
		<?php if($action['images'] AND count($action['images'])>1): ?>
			<div class="content-row shop-slider-row wide-row">
				<div class="content-row">
					<div class="next"></div>
					<div class="prev"></div>
					<div class="cycle-slideshow"
					data-cycle-slides="> a"
					data-cycle-fx=carousel
					data-cycle-carousel-visible=5
					data-cycle-carousel-fluid=true
					data-cycle-next=".shop-slider-row .next"
					data-cycle-prev=".shop-slider-row .prev"
					data-cycle-pause-on-hover="true"
					data-cycle-timeout="0">
					<?php foreach($action['images'] as $file): ?>
						<a href="/files/colorbox/<?= $file['file']->filepathname ?>" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>" class="fancybox" rel="1">
							<img src="/files/preview2/<?= $file['file']->filepathname ?>" alt="<?= $file['description'][Data::_('lang_id')]['title'] ?>" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>">
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	<?php else: ?>
		<h2><?= $text_page_not_found ?></h2>
	<?php endif; ?>
</div>
<div class="content-row wide-row contacts-row dark-row">
	<center><?= $site_map ?></center>
</div>
<div class="content-row wide-row more-row dark-row">
	<a href="<?= Data::_('lang_uri') ?>/butiks">Посмотреть все магазины</a>
</div>