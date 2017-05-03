<?php if($cats): ?>
	<div class="content-row">
		<?php foreach($cats as $value): ?>
			<a href="<?= Data::_('lang_uri') . '/butiks/' . $value['alias'] ?>">
				<img src="/files/<?= $value['thumb'] ?>" alt=""> <?= $value['descriptions'][Data::_('lang_id')]['title'] ?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
