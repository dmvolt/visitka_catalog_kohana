<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<?= Modulinfo::get_admin_block('catalog') ?>
<h2 class="title"><?= $text_catalog ?> <a href="/admin/catalog/add<?= $parameters ?>" title="<?= $text_add_new_catalog ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>

<form action="" method="get" name="form" id="form" style="float:left;">
    <div class="form_item">
        <label for="cat"><?= $text_cat_catalog ?></label></br>
        <select name="cat" style="width:200px;">
			<option value="0">-- Все --</option>
            <?php
            $tree = new Tree();
            foreach ($group_cat as $group):
                ?>
                <?php if ($group['dictionary_id'] == 1): ?>
                    <?php $tree->selectOutTree($group['dictionary_id'], 0, 1, $parent = (isset($parent)) ? $parent : ''); //Выводим дерево в элемент выбора ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form_item" style="top:32px">
        <a onclick="$('#form').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
    </div>
</form>
<div class="clear"></div>
<h2 class="title"><?= $cat_name ?></h2>

<?php if (isset($contents) AND count($contents) > 0): ?>
	<?= $pagination ?>
    <form method="post" action="/admin/weight/update" id="weight_form">
        <table>
            <thead>
                <tr>
					<td><input type='checkbox' onclick="$('input[name*=\'multidelete\']').prop('checked', this.checked);"><strong><?= $text_thead_select_all ?></strong><br><a onclick="multiDelete();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_delete ?></span></a></td>
                    <td><strong><?= $text_catalog_thead_name ?></strong><br><a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td><strong><?= $text_catalog_thead_alias ?></strong><br><a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_catalog_thead_status ?></strong><br><a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_thead_weight ?></strong><br><a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_catalog_thead_action ?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contents as $key => $value): ?>
                    <tr>
						<td class="first"><input type="checkbox" name="multidelete[]" value="<?= $value['id'] ?>"></td>
                        <td class="first">
						<?php if(isset($languages)): ?>
							<?php foreach ($languages as $item): ?>
								<input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $value['id'] ?>][<?= $item['lang_id']?>][title]" value="<?= htmlspecialchars($value['descriptions'][$item['lang_id']]['title']) ?>" class="text"><?= $item['icon']?>
							<?php endforeach; ?>
						<?php else: ?>
							<input type="text" name="descriptions[<?= $value['id'] ?>][1][title]" value="<?= htmlspecialchars($value['descriptions'][1]['title']) ?>" class="text">
						<?php endif; ?>
						</td>
                        <td><input type="text" name="alias[<?= $value['id'] ?>]" class="text" value="<?= $value['alias'] ?>"></td>
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
                        <td class="last"><a href="/admin/catalog/edit/<?= $value['id'] ?><?= $parameters ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/catalog/delete/<?= $value['id'] ?><?= $parameters ?>" class="delete"><?= $text_delete_img ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>		
        </table>
		<input type="hidden" name="parameters" value="<?= $parameters ?>" />
        <input type="hidden" name="module" value="catalog" />
    </form>
<?= $pagination2 ?>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>