<?php if (!empty($doimagesdata)): ?>
	<span class="description">Для изменения сортировки перетащите картинку в нужное место. Изменения сохраняются автоматически.</span>	
	<?php foreach ($doimagesdata as $doimages): ?>
		<div class="form_item_file" id="<?= $doimages['file']->id ?>">
			<span class="form_item_file_delete" title="Удалить" ONCLICK="deletedoimages(<?= $doimages['file']->id ?>); "></span>
			<img src="/files/doimages/thumbnails/<?= $doimages['file']->filepathname ?>" />
		</div>
	<?php endforeach; ?>
<?php endif;?>