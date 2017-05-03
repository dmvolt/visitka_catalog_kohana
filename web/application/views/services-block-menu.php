<?php if($services): ?>
	<div class="list-group-item"><h3>Другие услуги</h3></div>
	<?php foreach($services as $value): ?>
		<a href="<?= Data::_('lang_uri') . '/services/' . $value['alias'] ?>" class="list-group-item"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a>
	<?php endforeach; ?>
<?php endif; ?>