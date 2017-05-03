<div class="content-row wide-row search-row">
	<div class="content-row">
		<?= Search::get_search_block() ?>
	</div>
</div>
<div class="content-row wide-row ar-bottom ar-bg">
	<div class="content-row pager-row">
		<?= $pagination ?>
	</div>
	<div class="content-row">
		<?php  if($projects): ?>
			<?php  foreach($projects as $value): ?>
				<project class="news-preview">
					<div class="date"><?= Text::format_date($value['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?></div>
					<h3><a href="<?= Data::_('lang_uri') ?>/news/<?= $value['id'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a></h3>
					<?php if($value['thumb']): ?>
						<img src="/files/colorbox/<?= $value['thumb'] ?>" alt="">
					<?php endif; ?>
					<?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?>
					<a href="<?= Data::_('lang_uri') ?>/news/<?= $value['id'] ?>"><?= $text_read_more ?></a>
				</project>
			<?php endforeach; ?>
		<?php else: ?>
			<h2><?= $text_page_not_found ?></h2>
		<?php endif; ?>
	</div>
	<div class="content-row pager-row">
		<?= $pagination ?>
	</div>
</div>
<div class="content-row wide-row more-row dark-row">
	<a href="<?= Data::_('lang_uri') ?>/butiks">Посмотреть все магазины комплекса</a>
</div>