<?php if($services): ?>
	<div class="header-2"><a href="/services"><?= $text_all_services ?></a></div>
	<?php foreach($services as $value): ?>
		<div class="blog-entry clearfix">
			<h3><a href="<?= Data::_('lang_uri') . '/services/' . $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a><br><?= $value['date'] ?></h3>
			<?php if($value['thumb']): ?>
				<img src="/files/preview/<?= $value['thumb'] ?>" alt="" class="blog-image">
			<?php endif; ?>
			<p><?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?></p>
		</div>
	<?php endforeach; ?>
	<a href="/services" class="more">Старые посты</a>
<?php endif; ?>