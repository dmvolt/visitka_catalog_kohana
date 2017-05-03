<?php if($articles): ?>
	<?php foreach($articles as $value): ?>
		<a href="<?= Data::_('lang_uri') . '/articles/' . $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a><br>
	<?php endforeach; ?>
<?php endif; ?>