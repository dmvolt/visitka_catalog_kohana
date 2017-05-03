<?php if($projects): ?>
	<div class="header-2"><a href="/projects"><?= $text_all_projects ?></a></div>
	<?php foreach($projects as $value): ?>
		<div class="blog-entry clearfix">
			<h3><a href="<?= Data::_('lang_uri') . '/projects/' . $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a><br><?= $value['date'] ?></h3>
			<?php if($value['thumb']): ?>
				<img src="/files/preview/<?= $value['thumb'] ?>" alt="" class="blog-image">
			<?php endif; ?>
			<p><?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?></p>
		</div>
	<?php endforeach; ?>
	<a href="/projects" class="more">Старые посты</a>
<?php endif; ?>