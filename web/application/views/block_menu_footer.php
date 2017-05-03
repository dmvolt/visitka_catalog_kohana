<?php if ($menu): ?>
	<h4>Навигация</h4>
	<ul class="nav-footer">
		<?php foreach ($menu as $item): ?>
			<?php if (isset($item['descriptions'][Data::_('lang_id')]['title']) AND !empty($item['descriptions'][Data::_('lang_id')]['title'])): ?>
				<li><a href="<?= $item['url'] ?>" title="<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>