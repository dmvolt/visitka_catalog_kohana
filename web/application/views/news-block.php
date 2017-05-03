<?php if($last_news): ?>
	<div class="container">
        <h1><span>Последние новости</span></h1>
        <div class="news">
			<?php foreach($last_news as $value): ?>
				<a class="news-link" href="<?= Data::_('lang_uri') ?>/news/<?= $value['alias'] ?>">
					<div class="media clearfix background-belize-hole color-white">
						<div class="pull-left">
							<?php if($value['thumb']): ?>
								<img class="media-object" src="<?= URL::imagepath('preview', $value['thumb'])?>" alt="">
							<?php endif; ?>
						</div>
						<div class="media-body">
							<h3 class="media-heading"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></h3>
							<div class="date"><?= Text::format_date($value['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?></div>
							<?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
		<a href="<?= Data::_('lang_uri') ?>/news">Все новости</a>
	</div>
<?php endif; ?>