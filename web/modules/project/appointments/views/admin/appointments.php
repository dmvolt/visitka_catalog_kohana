<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<h2 class="title"><?= $cat_name ?> <a href="/admin/appointments/add<?= $parameters ?>" title=""><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>
<form action="" method="get" name="form" id="form" style="float:left;">
    <div class="form_item">
        <label for="cat"><?= $text_cat_appointments ?></label></br>
        <select name="cat" style="width:200px;">
			<option value="0"> -- Все -- </option>
            <?php $tree = new Tree(); ?>
			<?php $tree->selectOutTree(1, 0, 1, $parent = (isset($parent)) ? $parent : ''); //Выводим дерево в элемент выбора ?>
        </select>
    </div>
	<?php if ($doctors): ?>
		<div class="form_item">
			<label for="doctor"><?= $text_doctor_appointments ?></label></br>
			<select name="doctor" style="width:200px;">
				<option value="0"> -- Все -- </option>
				<?php foreach($doctors as $value): ?>
					<option value="<?= $value['id'] ?>"><?= $value['descriptions'][1]['title'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	<?php endif; ?>
    <div class="form_item" style="top:32px">
        <a onclick="$('#form').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
    </div>
</form>
<?php if (isset($contents) and count($contents) > 0): ?>
    <form method="post" action="/admin/weight/update" id="weight_form">
		<table>
			<thead>
				<tr>
					<td><strong><?= $text_appointments_thead_date ?></strong></td>
					<td><strong><?= $text_appointments_thead_time ?></strong></td>
					<td><strong><?= $text_appointments_thead_name ?></strong></td>
					<td><strong><?= $text_appointments_thead_contact ?></strong></td>
					<td class="last"><strong><?= $text_appointments_thead_status ?></strong>&nbsp;&nbsp;<a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td class="last"><strong><?= $text_thead_weight ?></strong>&nbsp;&nbsp;<a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td class="last"><strong><?= $text_appointments_thead_action ?></strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($contents as $value): ?>
					<tr>
						<td class="first"><?= $value['date'] ?></td>
						<td class="first"><?= $value['time'] ?></td>
						<td class="first"><?= $value['name'] ?></td>
						<td class="first"><?= $value['contact'] ?></td>
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
						<td class="last"><a href="/admin/appointments/edit/<?= $value['id'] ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/appointments/delete/<?= $value['id'] ?>" class="delete"><?= $text_delete_img ?></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>		
		</table>
        <input type="hidden" name="module" value="appointments" />
    </form>
<?php endif; ?>