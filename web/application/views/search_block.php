<form action="<?= Data::_('lang_uri') ?>/search" method="get" class="form-inline" role="form">
	<div class="input-group">
		<input type="text" name="q" placeholder="поиск по каталогу ..." value="<?= $q ?>" class="form-control">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit"><?= $text_search ?></button>
		</span>
	</div>
</form>