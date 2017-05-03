<?php if($infoblocks AND count($infoblocks)>0): ?>
	<?php foreach($infoblocks as $key => $block): ?>
		<?= $block['descriptions'][Data::_('lang_id')]['teaser'] ?>
	<?php endforeach; ?>
<?php endif; ?>