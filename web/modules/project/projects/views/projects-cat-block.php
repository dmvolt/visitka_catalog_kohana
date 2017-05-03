<?php if($projects): ?>
	<?php foreach($projects as $value): ?>
		<a href="<?= Data::_('lang_uri') . '/projects/' . $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a><br>
	<?php endforeach; ?>
<?php endif; ?>