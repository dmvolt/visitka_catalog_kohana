<?php if($infoblocks): ?>
	<?php foreach($infoblocks as $key => $block): ?>
		<div class="left-block">
			<h3><a href="<?= $block['date'] ?>"><?= $block['descriptions'][Data::_('lang_id')]['title'] ?></a></h3>
			<?= $block['edit_interface'] ?>
			<div class="left-block-text"><div id="infoblock_teaser_<?= $block['id'] ?>"><?= $block['descriptions'][Data::_('lang_id')]['teaser'] ?></div></div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>