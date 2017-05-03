<?php if (count($menu) > 0): ?>
	<div class="list-group-item"><h3>Каталог</h3></div>
	<?php foreach ($menu as $item): ?>
		
		<a href="/catalog/<?= $item['alias'] ?>" class="list-group-item <?= $item['active'] ?>"><b><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></b></a>
		
		<?php if ($item['children']): ?>
			<?php foreach ($item['children'] as $item2): ?>
				<a href="/catalog/<?= $item['alias'] ?>/<?= $item2['alias'] ?>" class="list-group-item list-group-child"> - <?= $item2['descriptions'][Data::_('lang_id')]['title'] ?></a>
			<?php endforeach; ?>
		<?php endif; ?>
	
	<?php endforeach; ?>
<?php endif; ?>