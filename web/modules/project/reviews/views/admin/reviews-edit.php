<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<div style="padding-top:50px;">
    <h2 class="title"><?= $text_edit_content ?> - <?= $content['descriptions'][1]['title'] ?></h2>
    <form action="" method="post" name="form1" id="page_edit">
	
		<?//= $categories_form ?>
	
        <div class="form_item">
            <label for="date"><?= $text_reviews_date ?></label></br>
            <input type="text" id="datepicker" name="date" value="<?= $content['date'] ?>" class="text">
        </div>
		
        <div class="form_item">
            <label for="title"><?= $text_name ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value="<?= $content['descriptions'][$item['lang_id']]['title'] ?>" class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value="<?= $content['descriptions'][1]['title'] ?>" class="text">
			<?php endif; ?>
        </div>
		
        <div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="body" class="lang_img_<?= $item['lang_id']?>"><?= $text_body ?> </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][body]" class="textarea_lang_<?= $item['lang_id']?>"><?= $content['descriptions'][$item['lang_id']]['body'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="body"><?= $text_body ?></label><textarea name="descriptions[1][body]" class="lang_editor" id="editor1"><?= $content['descriptions'][1]['body'] ?></textarea>
			<?php endif; ?>
        </div>
		
        <div class="form_item">
            <label for="weight"><?= $text_weight ?></label></br>
            <input type="text" name="weight" value="<?= $content['weight'] ?>" class="text" value="0">
        </div>
		
        <div class="form_item" style="top:32px">
            <label for="status"><?= $text_reviews_status ?></label>
            <?php if ($content['status']): ?>
                <input type="checkbox" id="status" name="status" checked="checked" value="1">
            <?php else: ?>
                <input type="checkbox" id="status" name="status" value="1">
            <?php endif; ?>
        </div>
		<h2 class="title"><?= $text_file_illustration ?></h2>
		<div class="images_content" id="sortable"></div>
	</form>
		
	<!--<h2 class="title"><?//= $text_file_files ?></h2>
	<div class="files_content"></div>-->
		
	<?= $files_form ?>
	
    <div class="form_item" style="top:32px">
        <a onclick="$('#page_edit').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
    </div>
</div>