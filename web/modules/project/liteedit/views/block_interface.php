<button class="edit_button" onclick="clickToEdit('<?= $edit['module'] ?>', <?= $edit['id'] ?>, <?= $edit['mode'] ?>);"><?= $text_edit ?></button>
<button class="save_button" id="save_<?= $edit['module'] ?>_<?= $edit['id'] ?>" onclick="clickToSave('<?= $edit['module'] ?>', <?= $edit['id'] ?>, <?= Data::_('lang_id') ?>, '<?= $edit['field'] ?>');"><?= $text_save ?></button>
<img class="loading" id="loading_<?= $edit['module'] ?>_<?= $edit['id'] ?>" src="/images/load.gif" />
<span class="success" id="success_<?= $edit['module'] ?>_<?= $edit['id'] ?>"></span>