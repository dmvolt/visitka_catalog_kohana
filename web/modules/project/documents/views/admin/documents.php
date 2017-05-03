<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<h2 class="title"><?= $text_documents ?> <a href="/admin/documents/add<?= $parameters ?>" title="<?= $text_add_new_documents ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>

<?php if (isset($contents) AND count($contents) > 0): ?>
	<?= $pagination ?>
    <form method="post" action="/admin/weight/update" id="weight_form">
        <table>
            <thead>
                <tr>
					<td><input type='checkbox' onclick="$('input[name*=\'multidelete\']').prop('checked', this.checked);"><strong><?= $text_thead_select_all ?></strong><br><a onclick="multiDelete();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_delete ?></span></a></td>
                    <td><strong><?= $text_documents_thead_name ?></strong><br><a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td><strong><?= $text_documents_thead_alias ?></strong><br><a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_documents_thead_status ?></strong><br><a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_thead_weight ?></strong><br><a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_documents_thead_action ?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contents as $value): ?>
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
                        <td class="last"><a href="/admin/documents/edit/<?= $value['id'] ?><?= $parameters ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/documents/delete/<?= $value['id'] ?><?= $parameters ?>" class="delete"><?= $text_delete_img ?></a></td>
                    </tr>
					
					<?php if ($value['children'] AND count($value['children']) > 0): ?>
						<?php foreach ($value['children'] as $value2): ?>
							<tr>
								<td class="first"><input type="checkbox" name="multidelete[]" value="<?= $value2['id'] ?>"></td>
								<td class="first">
								<?php if(isset($languages)): ?>
									<?php foreach ($languages as $item): ?>
										<input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $value2['id'] ?>][<?= $item['lang_id']?>][title]" value="<?= htmlspecialchars($value2['descriptions'][$item['lang_id']]['title']) ?>" class="text" style="margin-left:25px;"><?= $item['icon']?>
									<?php endforeach; ?>
								<?php else: ?>
									<input type="text" name="descriptions[<?= $value2['id'] ?>][1][title]" value="<?= htmlspecialchars($value2['descriptions'][1]['title']) ?>" class="text" style="margin-left:25px;">
								<?php endif; ?>
								</td>
								<td><input type="text" name="alias[<?= $value2['id'] ?>]" class="text" value="<?= $value2['alias'] ?>"></td>
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
								<td class="last"><a href="/admin/documents/edit/<?= $value2['id'] ?><?= $parameters ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/documents/delete/<?= $value2['id'] ?><?= $parameters ?>" class="delete"><?= $text_delete_img ?></a></td>
							</tr>
							
							<?php if ($value2['children'] AND count($value2['children']) > 0): ?>
								<?php foreach ($value2['children'] as $value3): ?>
									<tr>
										<td class="first"><input type="checkbox" name="multidelete[]" value="<?= $value3['id'] ?>"></td>
										<td class="first">
										<?php if(isset($languages)): ?>
											<?php foreach ($languages as $item): ?>
												<input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $value3['id'] ?>][<?= $item['lang_id']?>][title]" value="<?= htmlspecialchars($value3['descriptions'][$item['lang_id']]['title']) ?>" class="text" style="margin-left:50px;"><?= $item['icon']?>
											<?php endforeach; ?>
										<?php else: ?>
											<input type="text" name="descriptions[<?= $value3['id'] ?>][1][title]" value="<?= htmlspecialchars($value3['descriptions'][1]['title']) ?>" class="text" style="margin-left:50px;">
										<?php endif; ?>
										</td>
										<td><input type="text" name="alias[<?= $value3['id'] ?>]" class="text" value="<?= $value3['alias'] ?>"></td>
										<?php if ($value3['status']): ?>
											<td class="last"><span style="color:green"><?= $text_active ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value3['id'] ?>);" id='status_<?= $value3['id'] ?>' checked value='1'></td>
										<?php else: ?>
											<td class="last"><span style="color:red"><?= $text_inactive ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value3['id'] ?>);" id='status_<?= $value3['id'] ?>' value='1'></td>
										<?php endif; ?>
										<input type='hidden' name='status[<?= $value3['id'] ?>]' id="statusfield_<?= $value3['id'] ?>" value=''>
										<script>
										$(document).ready(function(){
											checkboxStatus(<?= $value3['id'] ?>);
										});
										</script>
										<td class="last"><input type="text" name="weight[<?= $value3['id'] ?>]" class="text short" value="<?= $value3['weight'] ?>"></td>
										<td class="last"><a href="/admin/documents/edit/<?= $value3['id'] ?><?= $parameters ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/documents/delete/<?= $value3['id'] ?><?= $parameters ?>" class="delete"><?= $text_delete_img ?></a></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							
						<?php endforeach; ?>
					<?php endif; ?>
                <?php endforeach; ?>
            </tbody>		
        </table>
		<input type="hidden" name="parameters" value="<?= $parameters ?>">
        <input type="hidden" name="module" value="documents">
    </form>
<?= $pagination2 ?>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>