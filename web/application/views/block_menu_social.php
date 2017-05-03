<?php if ($menu): ?>
	<p class="social">
		<?php foreach ($menu as $item): ?>
			<?php if (isset($item['descriptions'][Data::_('lang_id')]['title']) AND !empty($item['descriptions'][Data::_('lang_id')]['title'])): ?>
				<a href="<?= $item['url'] ?>" target="_blank"><span class="fa fa-<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>"></span></a>
			<?php endif; ?>
		<?php endforeach; ?>
	</p>
<?php endif; ?>