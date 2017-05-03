<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<div style="padding-top:50px;">
    <h2 class="title"><?= $text_edit_content ?> - <?= $content['title'] ?></h2>
    <form action="" method="post" name="form1" id="banners_edit">

        <div class="form_item">
            <label for="title"><?= $text_name ?></label></br>
            <input type="text" id="name" name="title" value="<?= $content['title'] ?>" class="text">
        </div>
		<br>
        <div class="form_item">
            <?php if ($content['display_all']): ?>
                <input type="checkbox" id="display_all" name="display_all" onclick="displayPages();" checked="checked" value="1">
            <?php else: ?>
                <input type="checkbox" id="display_all" name="display_all" onclick="displayPages();" value="1">
            <?php endif; ?>
            <label for="display_all"><?= $text_banners_display_all ?></label>
        </div>
		<br>
        <div class="form_item_textarea" id="display_pages_block">
            <label for="display_pages"><?= $text_banners_display_pages ?></label></br>	
            <textarea name="display_pages" id="display_pages" cols="60" rows="5"><?= $content['display_pages'] ?></textarea>
        </div>
		<br>
        <div class="form_item">
			<label for="status"><?= $text_banners_status ?></label>
            <?php if ($content['status']): ?>
                <input type="checkbox" id="status" name="status" checked="checked" value="1">
            <?php else: ?>
                <input type="checkbox" id="status" name="status" value="1">
            <?php endif; ?>
        </div>

        <h2 class="title"><?= $text_banners_files ?></h2>
        <div class="images_content" id="sortable"></div>
    </form>
	<?= $files_form ?>

    <div class="form_item">
        <a onclick="$('#banners_edit').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	displayPages();
});
</script>


