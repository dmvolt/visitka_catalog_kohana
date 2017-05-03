<?php if($services): ?>
	<?php foreach($services as $value): ?>
		<a href="<?= Data::_('lang_uri') . '/services/' . $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a><br>
	<?php endforeach; ?>
<?php endif; ?>