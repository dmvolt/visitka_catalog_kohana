<form id="doimagesupload" enctype="multipart/form-data">
	<div class="form_item_textarea">
		<input type="file" id="doimages" name="doimages[]" multiple >
		<a onclick="$('#doimagesupload').submit();" id="sub2" class="btn_core btn_core_green btn_core_md" style="margin-right:25px; margin-bottom:15px;"><span><?= $text_doimages_upload ?></span></a>
		<a onclick="$('#doimagesupload').each(function(){this.reset();});" id="res2" class="btn_core btn_core_green btn_core_md" style="margin-right:25px; margin-bottom:15px;"><span><?= $text_doimages_noupload ?></span></a>
		<input type="hidden" name="id" id="id2" value="<?= $id ?>">
		<input type="hidden" name="module" id="module2" value="<?= $module ?>">
	</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	getdoimages("<?= $module ?>");
	
	$("#sortable2").sortable(
	{
		beforeStop: function(event, ui) { 
			savenewsort2("<?= $module ?>");
		},
		cursor: 'crosshair',
		tolerance: 'pointer'		
	});
	
	var formData2 = $('#doimagesupload').serialize();
	var options2 = {
		type: "POST",
		data: formData2,
		url: "/ajaxdoimages/loadfiles",
		dataType: "json",
		iframe: true,
		beforeSend: function() {
			$('#res2').after('<div class="wait"></div>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(data)
		{
			if(data.result)
			{
				getdoimages("<?= $module ?>");
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	}; 
	// bind 'doimagesupload' and provide a simple callback function 
	$('#doimagesupload').ajaxForm(options2);
});
function getdoimages(module)
{
	var formData = $('#doimagesupload').serialize();
	$.ajax({
		type: "POST",
		data: formData,
		url: "/ajaxdoimages/getfiles",
		dataType: "json",
		success: function(data)
		{
			if(data)
			{
				$('.doimages_content').html(data);
			}
			else
			{
				$('.doimages_content').html('нет загруженных файлов');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	})
}

function deletedoimages(id, module)
{
	var id = id;
	$.ajax({
		type: "POST",
		data: "id=" + id + "&content_id=" + $('#id2').attr('value') + "&module=" + $('#module2').attr('value'),
		url: "/ajaxdoimages/deletefiles",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				getdoimages(module);
			}
		}
	})
}

function savenewsort2(module)
{
	var newsortstring = $('#sortable2').sortable('toArray');
	$.ajax({
		type: "POST",
		data: "newsortstring=" + newsortstring,
		url: "/ajaxdoimages/savenewsort",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				//getdoimages(module);
			}
		}
	})
}
</script>