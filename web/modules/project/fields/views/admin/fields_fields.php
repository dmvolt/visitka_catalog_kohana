<div class="tab_wrap">
	<div id="fields_block_container">
		<h2 class="title"><?= $group_fieldname ?> <a onclick="addField();" title="<?= $text_add_new_field ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>
		<?php if($fields): ?>	
			<?php foreach($fields as $key => $field): ?>
				<div class="form_item field_item" style="display:block">
					<span class="form_item_file_delete" title="<?= $text_delete_field ?>" onclick="deleteField(this);"></span>
					<div class="form_item" style="width:49%">	
						<label><?= $fieldname1 ?></label><br>
						<input type="text" name="fields[<?= $key ?>][0]" value="<?= $field['field0'] ?>" class="text" style="width:95%">
					</div>
					<div class="form_item" style="width:49%">	
						<label><?= $fieldname2 ?></label><br>
						<input type="text" name="fields[<?= $key ?>][1]" value="<?= $field['field1'] ?>" class="text" style="width:95%">
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
<script>
function addField(){
	var count = $('.field_item').length;
	var	html = '<div class="form_item field_item" style="display:block">';
		html += '<span class="form_item_file_delete" title="<?= $text_delete_field ?>" onclick="deleteField(this);"></span>';
		html += '<div class="form_item" style="width:49%">';
		html += '<label><?= $fieldname1 ?></label><br>';
		html += '<input type="text" name="fields['+count+'][0]" value="" class="text" style="width:95%">';
		html += '</div>';
		html += '<div class="form_item" style="width:49%">';
		html += '<label><?= $fieldname2 ?></label><br>';
		html += '<input type="text" name="fields['+count+'][1]" value="" class="text" style="width:95%">';
		html += '</div>';
		html += '</div>';
		
	$("#fields_block_container").append(html);
}


function deleteField(elem){
	if(confirm("<?= $text_confirm_delete_field ?>")){
		var parentElement = elem.parentNode;
		$(parentElement).remove();
	}
}
</script>