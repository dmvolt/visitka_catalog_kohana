<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<h2 class="title"><?= $text_edit_content ?> - <?= $content['descriptions'][1]['title'] ?></h2>
<form action="" method="post" name="form1" id="page_edit">
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Основная информация</a></li>
		<li><a href="#tabs-2">SEO</a></li>
		<li><a href="#tabs-3">Иллюстрации</a></li>
	</ul>
	
	<div id="tabs-1">	
	
		<div class="form_item">
            <label for="type"><?= $text_news_type ?></label>
			<?php if ($content['type']): ?>
                <input type="checkbox" name="type" checked="checked" value="1">
            <?php else: ?>
                <input type="checkbox" name="type" value="1">
            <?php endif; ?>
        </div>
		
		<div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="poll" class="lang_img_<?= $item['lang_id']?>"><?= $text_news_poll ?> </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][poll]" class="seo_textarea_lang_<?= $item['lang_id']?> text" style="width:400px; height:150px; display:block"><?= $content['descriptions'][$item['lang_id']]['poll'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="poll"><?= $text_news_poll ?></label><textarea name="descriptions[1][poll]" class="text" style="width:400px; height:150px; display:block"><?= $content['descriptions'][1]['poll'] ?></textarea>
			<?php endif; ?>
        </div>
		
        <div class="form_item">
            <label for="date"><?= $text_news_date ?></label></br>
            <input type="text" id="datepicker" name="date" value="<?= $content['date'] ?>" class="text">
        </div>
		
        <div class="form_item">
            <label for="title"><?= $text_name ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value="<?= htmlspecialchars($content['descriptions'][$item['lang_id']]['title']) ?>" class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value="<?= htmlspecialchars($content['descriptions'][1]['title']) ?>" class="text">
			<?php endif; ?>
        </div>
		
        <div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="teaser" class="lang_img_<?= $item['lang_id']?>"><?= $text_teaser ?> </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][teaser]" class="textarea_lang_<?= $item['lang_id']?>"><?= $content['descriptions'][$item['lang_id']]['teaser'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>			
				<label for="teaser"><?= $text_teaser ?></label><textarea name="descriptions[1][teaser]" class="lang_editor" id="editor1"><?= $content['descriptions'][1]['teaser'] ?></textarea></br>
			<?php endif; ?>
        </div>
		
        <div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="body" class="lang_img_<?= $item['lang_id']?>"><?= $text_body ?> </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][body]" class="textarea_lang_<?= $item['lang_id']?>"><?= $content['descriptions'][$item['lang_id']]['body'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="body"><?= $text_body ?></label><textarea name="descriptions[1][body]" class="lang_editor" id="editor2"><?= $content['descriptions'][1]['body'] ?></textarea>
			<?php endif; ?>
        </div>
		
        <div class="form_item">
            <label for="alias"><?= $text_alias ?></label></br>
            <input id="alias" type="text" name="alias" value="<?= $content['alias'] ?>" class="text"></br>
            <input type="checkbox" id="autoalias"><label for="autoalias"><?= $text_auto_zapolnenie ?></label>
        </div>
		
        <div class="form_item">
            <label for="weight"><?= $text_weight ?></label></br>
            <input type="text" name="weight" value="<?= $content['weight'] ?>" class="text" value="0">
        </div>
		
        <div class="form_item" style="top:35px">
            <label for="status"><?= $text_news_status ?></label>
            <?php if ($content['status']): ?>
                <input type="checkbox" id="status" name="status" checked="checked" value="1">
            <?php else: ?>
                <input type="checkbox" id="status" name="status" value="1">
            <?php endif; ?>
        </div>
    </div>
	
	<div id="tabs-2">
		<?= $seo_form ?>
	</div>
	
	<div id="tabs-3">
			<h2 class="title"><?= $text_file_illustration ?></h2>
			<div class="images_content" id="sortable"></div>
		</form>
		
		<!--<h2 class="title"><?//= $text_file_files ?></h2>
		<div class="files_content"></div>-->
		
		<?= $files_form ?>
	</div>
</div>
<div class="form_item" style="top:35px">
	<a onclick="$('#page_edit').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#name").keyup(generatealias);
	$('[id^="name"]').keyup(generatealias);
});
</script>