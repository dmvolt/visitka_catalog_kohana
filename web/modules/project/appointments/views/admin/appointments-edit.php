<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<div style="padding-top:50px;">
    <h2 class="title"><?= $text_edit_content ?> - <?= $content['name'] ?></h2>
    <form action="" method="post" name="form1" id="page_edit">
        <div class="form_item">
            <label for="date"><?= $text_appointments_date ?></label></br>
            <input type="text" id="datepicker" name="date" value="<?= $content['date'] ?>" class="text">
        </div>
		
		<div class="form_item">
			<label for="category_id"><?= $text_cat_appointments ?></label></br>
			<select name="category_id" style="width:200px;">
				<?php $tree = new Tree(); ?>
				<?php $tree->selectOutTree(1, 0, 1, $parent = (isset($content['category_id'])) ? $content['category_id'] : ''); //Выводим дерево в элемент выбора ?>
			</select>
		</div>
		<?php if ($doctors): ?>
			<div class="form_item">
				<label for="doctor_id"><?= $text_doctor_appointments ?></label></br>
				<select name="doctor_id" style="width:200px;">
					<?php foreach($doctors as $value): ?>
						<option value="<?= $value['id'] ?>" <?php if($value['id'] == $content['doctor_id']):?>selected<?php endif; ?>><?= $value['descriptions'][1]['title'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>
		
        <div class="form_item">
            <label for="name"><?= $text_appointments_name ?></label><br>
			<input type="text" name="name" value="<?= $content['name'] ?>" class="text">
        </div>
		<div class="form_item">
            <label for="contact"><?= $text_appointments_contact ?></label><br>
			<input type="text" name="contact" value="<?= $content['contact'] ?>" class="text">
        </div>
		<div class="form_item">
            <label for="time"><?= $text_appointments_time ?></label><br>
			<input type="text" name="time" value="<?= $content['time'] ?>" class="text">
        </div>
		
        <div class="form_item">
            <label for="weight"><?= $text_weight ?></label></br>
            <input type="text" name="weight" value="<?= $content['weight'] ?>" class="text" value="0">
        </div>
		
        <div class="form_item" style="top:32px">
            <label for="status"><?= $text_appointments_status ?></label>
            <?php if ($content['status']): ?>
                <input type="checkbox" id="status" name="status" checked="checked" value="1">
            <?php else: ?>
                <input type="checkbox" id="status" name="status" value="1">
            <?php endif; ?>
        </div>
	</form>
    <div class="form_item" style="top:32px">
        <a onclick="$('#page_edit').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
    </div>
</div>