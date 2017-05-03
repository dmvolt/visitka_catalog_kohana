<?php if($actions): ?>
	<?php foreach($actions as $value): ?>
		<a href="<?= Data::_('lang_uri') . '/actions/' . $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a><br>
	<?php endforeach; ?>
<?php endif; ?>