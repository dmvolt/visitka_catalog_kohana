<?php if($actions): ?>
	<div class="list-group-item"><h3>Другие акции</h3></div>
	<?php foreach($actions as $value): ?>
		<a href="<?= Data::_('lang_uri') . '/actions/' . $value['alias'] ?>" class="list-group-item"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a>
	<?php endforeach; ?>
<?php endif; ?>