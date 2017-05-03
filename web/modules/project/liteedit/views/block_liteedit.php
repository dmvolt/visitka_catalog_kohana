<script type="text/javascript">
function clickToEdit(module, Id, air)
{
	$('#' + module + '_content' + '_' + Id).redactor({
		focus: true,
		lang: 'ru',
		observeLinks: true,
		air: air,
		convertVideoLinks: true,
		convertImageLinks: true,
		imageUpload: '/liteedit/load_image_in_text',
		fileUpload: '/liteedit/load_file_in_text'
	});
	$('#save_' + module + '_' + Id).show();
}

function clickToSave(module, Id, langId, field)
{
	// save content if you need
	var html = $('#' + module + '_content' + '_' + Id).redactor('get');
	
	$.ajax({
		type: 'POST',
		data: 'module=' + module + '&id=' + Id + '&lang_id=' + langId + '&field=' + field + '&html=' + html,
		url: '/liteedit/editfield',
		dataType: 'json',
		beforeSend: function() {
			$('#save_' + module + '_' + Id).hide();
			$('#loading_' + module + '_' + Id).show();
		},		
		complete: function() {
			$('#loading_' + module + '_' + Id).hide();
		},			
		success: function(data)
		{
			if(data.result)
			{
				$('#success_' + module + '_' + Id).show();
				$('#success_' + module + '_' + Id).html(data.result);
				// destroy editor
				$('#' + module + '_content' + '_' + Id).redactor('destroy');
				window.setTimeout(function(){ $('#success_' + module + '_' + Id).hide(200) }, 3000);			
			}
			else
			{
				$('#success_' + module + '_' + Id).show();
				$('#success_' + module + '_' + Id).html('не получилось, попробуйте еще раз.');
				window.setTimeout(function(){ $('#success_' + module + '_' + Id).hide(200) }, 3000);	
				$('#save_' + module + '_' + Id).show();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
}
</script>