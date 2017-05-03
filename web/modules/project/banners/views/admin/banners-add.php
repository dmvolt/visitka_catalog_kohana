<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<div style="padding-top:50px;">
    <h2 class="title"><?= $text_add_new_banners ?></h2>
    <form action="" method="post" name="form1" id="banners_add">

        <div class="form_item">
            <label for="title"><?= $text_name ?></label></br>
            <input type="text" id="name" name="title" class="text">
        </div>

        <div class="form_item">
            <input type="checkbox" id="display_all" name="display_all" value="1"><label for="display_all"><?= $text_banners_display_all ?></label>
        </div>

        <div class="form_item_textarea" id="display_pages_block">
            <label for="display_pages"><?= $text_banners_display_pages ?></label></br>	
            <textarea name="display_pages" id="display_pages" cols="60" rows="5"></textarea>
        </div>

        <div class="form_item">
            <label for="status"><?= $text_banners_status ?></label><input type="checkbox" id="status" name="status" checked="checked" value="1">
        </div>

        <h2 class="title"><?= $text_banners_files ?></h2>
        <div class="images_content" id="sortable"></div>

    </form>
	<?= $files_form ?>
        
    <div class="form_item">
        <a onclick="$('#banners_add').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
    </div>


</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#display_all").click(displayPages);
    });
</script>

<script type="text/javascript">
    function displayPages()
    {
        var checked = $("#display_all").attr('checked');
		
        if(checked == "checked")
        {
	  
            $('#display_pages_block').css({'display':'none'});
        }
        else
        {
            $('#display_pages_block').css({'display':'block'});
        }		
    }
</script>


