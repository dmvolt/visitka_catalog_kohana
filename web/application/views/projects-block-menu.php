<?php if($projects): ?>
	<div class="list-group-item"><h3>Другие проекты</h3></div>
	<?php foreach($projects as $value): ?>
		<a href="<?= Data::_('lang_uri') . '/projects/' . $value['alias'] ?>" class="list-group-item"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a>
	<?php endforeach; ?>
<?php endif; ?>