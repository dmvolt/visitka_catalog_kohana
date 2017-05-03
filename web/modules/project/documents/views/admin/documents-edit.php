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
		<li><a href="#tabs-3">Иллюстрации и файлы</a></li>
	</ul>
	
	<div id="tabs-1">
	
		<div class="form_item">
			<label for="parent_id">Вложенно в материал</label></br>
			<select name="parent_id" style="width:200px;">
				<option value="0">-- Нет --</option>
				<?php if($parent_content AND count($parent_content)>0):?>
					<?php foreach ($parent_content as $value):?>
						<option value="<?= $value['id'] ?>" <?php if($value['id'] == $content['parent_id']):?>selected<?php endif;?> <?php if($value['id'] == $content['id']):?>disabled<?php endif;?>><?= $value['descriptions'][1]['title'] ?></option>
						
						<?php if($value['children'] AND count($value['children'])>0):?>
							<?php foreach ($value['children'] as $value2):?>
								<option value="<?= $value2['id'] ?>" <?php if($value2['id'] == $content['parent_id']):?>selected<?php endif;?> <?php if($value2['id'] == $content['id']):?>disabled<?php endif;?>> - <?= $value2['descriptions'][1]['title'] ?></option>
							
								<?php if($value2['children'] AND count($value2['children'])>0):?>
									<?php foreach ($value2['children'] as $value3):?>
										<option value="<?= $value3['id'] ?>" <?php if($value3['id'] == $content['parent_id']):?>selected<?php endif;?> <?php if($value3['id'] == $content['id']):?>disabled<?php endif;?>> - - <?= $value3['descriptions'][1]['title'] ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							
							<?php endforeach; ?>
						<?php endif; ?>
					
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
		
		<div class="form_item">
			<label for="date"><?= $text_documents_date ?></label></br>
			<input type="text" id="datepicker" name="date" value="<?= $content['date'] ?>" class="text">
		</div>
	
		<div class="form_item">
			<label for="title"><?= $text_name ?></label><?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value="<?= htmlspecialchars($content['descriptions'][$item['lang_id']]['title']) ?>" class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value="<?= htmlspecialchars($content['descriptions'][1]['title']) ?>" class="text">
			<?php endif; ?>
		</div>
		
		<div class="form_item">
			<label for="link">Ссылка</label></br>
			<input type="text" name="link" value="<?= $content['link'] ?>" class="text">
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
			<label for="status"><?= $text_documents_status ?></label>
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