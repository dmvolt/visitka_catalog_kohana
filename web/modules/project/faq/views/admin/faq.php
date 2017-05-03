<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<?= Modulinfo::get_admin_block('faq') ?>
<h2 class="title"><?= $text_add_new_faq ?></h2>
<form method="post" action="" id="form_add_faq">
	<?//= $categories_form ?>
	
	<div class="form_item">
		<label for="date"><?= $text_faq_date ?></label></br>
		<input type="text" id="datepicker" name="date" class="text" value="<?= $post['date'] ?>">
	</div>
	
	<?php if ($doctors): ?>
		<div class="form_item">
			<label for="doctor">Кому вопрос?:</label></br>
			<select name="doctor_id" style="width:200px;">
				<?php foreach($doctors as $value): ?>
					<option value="<?= $value['id'] ?>"><?= $value['descriptions'][1]['title'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	<?php endif; ?>
		
	<div class="form_item">
		<label for="name">Имя:</label>
		<?php if(isset($languages)): ?>
			<?php foreach ($languages as $item): ?>
				<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value='<?= $post['descriptions'][$item['lang_id']]['title'] ?>' class="text">
			<?php endforeach; ?>
		<?php else: ?>
			<br><input type="text" id="name" name="descriptions[1][title]" value='<?= $post['descriptions'][1]['title'] ?>' class="text">
		<?php endif; ?>
	</div>
	<div class="form_item">
		<label for="weight"><?= $text_weight ?></label><br>
		<input type="text" name="weight" class="short" value="0">
	</div>
	<div class="form_item" style="top:32px;">
		<a onclick="$('#form_add_faq').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_create ?></span></a>
	</div>
	<br>
	<div class="form_item">
		<input type="text" name="parent_id" class="short" value="<?= $post['parent_id'] ?>">
		<label for="parent_id">ID отзыва на который ответ (если это не ответ, оставьте поле пустым)</label>
	</div>
	
	<div class="form_item_textarea">
		<?php if(isset($languages)): ?>
			<?php foreach ($languages as $item): ?>
				<label for="body" class="lang_img_<?= $item['lang_id']?>"><?= $text_body_faq ?> </label><?= $item['icon']?><br class="lang_img_<?= $item['lang_id']?>"><textarea name="descriptions[<?= $item['lang_id']?>][body]" class="textarea_lang_<?= $item['lang_id']?>"><?= $post['descriptions'][$item['lang_id']]['body'] ?></textarea>
			<?php endforeach; ?>
		<?php else: ?>
			<label for="body"><?= $text_body_faq ?></label><br><textarea name="descriptions[1][body]" class="lang_editor" id="editor1"><?= $post['descriptions'][1]['body'] ?></textarea>
		<?php endif; ?>
	</div>
</form>
<h2 class="title"><?= $cat_name ?></h2>
<!--<form action="" method="get" name="form" id="form" style="float:left;">
    <div class="form_item">
        <label for="cat"><?//= $text_cat_articles ?></label></br>
        <select name="cat" style="width:200px;">
            <?php
            //$tree = new Tree();
            //foreach ($group_cat as $group):
                ?>
                <?php //if ($group['dictionary_id'] == 1): ?>
                    <?php //$tree->selectOutTree($group['dictionary_id'], 0, 1, $parent = (isset($parent)) ? $parent : ''); //Выводим дерево в элемент выбора ?>
                <?php //endif; ?>
            <?php //endforeach; ?>
        </select>
    </div>
    <div class="form_item" style="top:32px">
        <a onclick="$('#form').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
    </div>
</form>-->
<?php if (isset($contents) and count($contents) > 0): ?>
    <form method="post" action="/admin/weight/update" id="weight_form">
		<!--<h2><?//= $group_faq[2][Data::_('lang_id')]['name'] ?></h2>-->
		<table>
			<thead>
				<tr>
					<td><strong>ID вопроса(ответа)</strong></td>
					<td><strong><?= $text_faq_thead_date ?></strong></td>
					<td><strong><?= $text_faq_thead_name ?></strong></td>
					<td><strong>Контакт</strong></td>
					<td><strong>Вопрос(ответ)</strong></td>
					<td class="last"><strong><?= $text_faq_thead_status ?></strong>&nbsp;&nbsp;<a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td class="last"><strong><?= $text_thead_weight ?></strong>&nbsp;&nbsp;<a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td class="last"><strong><?= $text_faq_thead_action ?></strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($contents as $value): ?>
					<tr>
						<td class="first"><?= $value['id'] ?></td>
						<td class="first"><?= $value['date'] ?></td>
						<td class="first"><?= $value['descriptions'][1]['title'] ?></td>
						<td class="first"><?= $value['contact'] ?></td>
						<td class="first"><?= $value['descriptions'][1]['body'] ?></td>
						<?php if ($value['status']): ?>
							<td class="last"><span style="color:green"><?= $text_active ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value['id'] ?>);" id='status_<?= $value['id'] ?>' checked value='1'></td>
						<?php else: ?>
							<td class="last"><span style="color:red"><?= $text_inactive ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value['id'] ?>);" id='status_<?= $value['id'] ?>' value='1'></td>
						<?php endif; ?>
							<input type='hidden' name='status[<?= $value['id'] ?>]' id="statusfield_<?= $value['id'] ?>" value=''>
						<script>
						$(document).ready(function(){
							checkboxStatus(<?= $value['id'] ?>);
						});
						</script>
						<td class="last"><input type="text" name="weight[<?= $value['id'] ?>]" class="text short" value="<?= $value['weight'] ?>"></td>
						<td class="last"><a href="/admin/faq/edit/<?= $value['id'] ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/faq/delete/<?= $value['id'] ?>" class="delete"><?= $text_delete_img ?></a></td>
					</tr>
					<?php if ($value['answer']): ?>
						<?php foreach ($value['answer'] as $value2): ?>
							<tr style="background:#a4f6cd;">
								<td class="first"><?= $value2['id'] ?></td>
								<td class="first"><?= $value2['date'] ?></td>
								<td class="first"><?= $value2['descriptions'][1]['title'] ?></td>
								<td class="first"><?= $value2['contact'] ?></td>
								<td class="first"><?= $value2['descriptions'][1]['body'] ?></td>
								<?php if ($value2['status']): ?>
									<td class="last"><span style="color:green"><?= $text_active ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value2['id'] ?>);" id='status_<?= $value2['id'] ?>' checked value='1'></td>
								<?php else: ?>
									<td class="last"><span style="color:red"><?= $text_inactive ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value2['id'] ?>);" id='status_<?= $value2['id'] ?>' value='1'></td>
								<?php endif; ?>
									<input type='hidden' name='status[<?= $value2['id'] ?>]' id="statusfield_<?= $value2['id'] ?>" value=''>
								<script>
								$(document).ready(function(){
									checkboxStatus(<?= $value2['id'] ?>);
								});
								</script>
								<td class="last"><input type="text" name="weight[<?= $value2['id'] ?>]" class="text short" value="<?= $value2['weight'] ?>"></td>
								<td class="last"><a href="/admin/faq/edit/<?= $value2['id'] ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/faq/delete/<?= $value2['id'] ?>" class="delete"><?= $text_delete_img ?></a></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>		
		</table>
        <input type="hidden" name="module" value="faq" />
    </form>
<?php endif; ?>