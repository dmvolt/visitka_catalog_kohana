<?php if($languages): ?>
	<div class="lang">
		<?php foreach ($languages as $lang_ident => $item): ?>
			<a href="<?= Request::detect_uri_with_langpart($lang_ident) ?>" <?php if(Data::_('lang_id') == $item['lang_id']) echo 'class="active"'; ?>><?= $item['name']?></a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>