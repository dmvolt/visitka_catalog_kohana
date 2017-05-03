(function($) {
	$.fn.imageUpload = function(url, options) {
		if (url) {
			var settings = $.extend({
				previewImageSize: 100,
				attributeId: 0,
				defaultImage: '/images/admin/add_image.png',
				defaultLinkImage: '',
				productId: 0,
				module: 'options',
				onSuccess: function(response) {

				}
			}, options);

			return this.each(function() {
				if(settings.module == 'options'){
					$(this).html('\
						<div class="img_container" id="img-container-'+settings.attributeId+'">\
							<span class="upload_status" id="upload-status-'+settings.attributeId+'"></span>\
							<img id="add-option-img-'+settings.attributeId+'" class="add_option_img" src="'+settings.defaultImage+'" style="width:'+settings.previewImageSize+'px;">\
							<img id="del-option-img-'+settings.attributeId+'" class="del_option_img" src="/images/admin/delete.png">\
						</div>\
						<input type="hidden" name="attribute_img['+settings.attributeId+']" id="attribute-img-'+settings.attributeId+'" value="">\
						<input type="file" name="file" id="file-field-'+settings.attributeId+'" style="width:85px; font-size:9px;" />\
					');
				} else {
					$(this).html('\
						<div class="img_container" id="img-container-'+settings.attributeId+'">\
							<span class="upload_status" id="upload-status-'+settings.attributeId+'"></span>\
							<img id="add-option-img-'+settings.attributeId+'" class="add_option_img" src="'+settings.defaultImage+'" style="width:'+settings.previewImageSize+'px;">\
							<img id="del-option-img-'+settings.attributeId+'" class="del_option_img" src="/images/admin/delete.png">\
						</div>\
						<input type="hidden" name="img['+settings.attributeId+']" id="attribute-img-'+settings.attributeId+'" value="">\
						<input type="file" name="file" id="file-field-'+settings.attributeId+'" style="width:85px; font-size:9px;" />\
					');
				}

				var fileInput = $('#file-field-'+settings.attributeId);
				var dropBox = $('#img-container-'+settings.attributeId);
				var addImage = $('#add-option-img-'+settings.attributeId);
				var delImage = $('#del-option-img-'+settings.attributeId);
				var hiddenField = $('#attribute-img-'+settings.attributeId);
				var uploadStatus = $('#upload-status-'+settings.attributeId);
				
				hiddenField.attr('value', settings.defaultLinkImage);
				
				if(settings.defaultImage == '/images/admin/add_image.png'){
					delImage.hide();
				}
				
				var deleteImage = function() {
					if(settings.module == 'options'){
						$.ajax({
							type: "POST",
							data: 'filename=' + hiddenField.val() + '&module=' + settings.module + '&delfile=' + settings.attributeId,
							url: "/ajaxoptions/delete_by_filename",
							dataType: "json",
							beforeSend: function() {
								uploadStatus.show();
								uploadStatus.html('<img src="/images/admin/loader.gif" />');
							},
							success: function(data)
							{
								if(data)
								{
									hiddenField.attr('value', '');
									addImage.attr('src', '/images/admin/add_image.png');
									delImage.hide();
									uploadStatus.html('<span class="text_ok">OK!</span>');
									window.setTimeout(function(){ uploadStatus.hide() }, 1000);
								}
								else
								{
									uploadStatus.html('<span class="text_error">Error!</span>');
									window.setTimeout(function(){ uploadStatus.hide() }, 1000);
								}
							}
						})
					} else {
						$.ajax({
							type: "POST",
							data: 'module=' + settings.module + '&id=' + settings.attributeId,
							url: "/ajaxmenu/delete_by_id",
							dataType: "json",
							beforeSend: function() {
								uploadStatus.show();
								uploadStatus.html('<img src="/images/admin/loader.gif" />');
							},
							success: function(data)
							{
								if(data)
								{
									addImage.attr('src', '/images/admin/add_image.png');
									delImage.hide();
									uploadStatus.html('<span class="text_ok">OK!</span>');
									window.setTimeout(function(){ uploadStatus.hide() }, 1000);
								}
								else
								{
									uploadStatus.html('<span class="text_error">Error!</span>');
									window.setTimeout(function(){ uploadStatus.hide() }, 1000);
								}
							}
						})
					}
				}

				fileInput.bind({
					change: function() {
						displayFiles(this.files);
					}
				});

				dropBox.bind({
					dragenter: function() {
						$(this).addClass('highlighted');
						return false;
					},
					dragover: function() {
						return false;
					},
					dragleave: function() {
						$(this).removeClass('highlighted');
						return false;
					},
					drop: function(e) {
						var dt = e.originalEvent.dataTransfer;
						displayFiles(dt.files);
						return false;
					}
				});

				function displayFiles(files) 
				{
					$.each(files, function(i, file) {      
						if (!file.type.match(/image.*/)) 
							return true;
					    
					    var reader = new FileReader();
					    addImage.get(0).file = file;
						reader.onload = (function(aImg) {
							return function(e) {
								
								aImg.attr('src', e.target.result);
								aImg.attr('width', settings.previewImageSize);
							};
						})(addImage);
						reader.readAsDataURL(file);
					});
					up();
				}

				function up() {
					var formdata = new FormData;

					if (settings)
						for(var key in settings) {
							formdata.append(key, settings[key]);
						}

					dropBox.children("img").each(function(indx) {
						var fi = $(this).get(0).file;
						//fi.width = 100;
						formdata.append("file", fi);
					});

					xhr = new XMLHttpRequest();
					xhr.open("POST", url);
					uploadStatus.show();
					uploadStatus.html('<img src="/images/admin/loader.gif" />');
					xhr.send(formdata);
					xhr.onreadystatechange = function () {
						if (xhr.readyState == 4) {
					        if (xhr.status == 200) {
					            settings.onSuccess(xhr.responseText);
								if(settings.module == 'options'){
									if(hiddenField.val() != '' && settings.attributeId){
										$.ajax({
											type: "POST",
											data: 'filename=' + hiddenField.val() + '&module=' + settings.module + '&delfile=' + settings.attributeId,
											url: "/ajaxoptions/delete_by_filename",
											dataType: "json",
											success: function(data){}
										})
									}
									hiddenField.attr('value', xhr.responseText);
								} else {
									$.ajax({
										type: "POST",
										data: 'filename=' + xhr.responseText + '&module=' + settings.module + '&id=' + settings.attributeId,
										url: "/ajaxmenu/update_img",
										dataType: "json",
										success: function(data){}
									})
								}
								uploadStatus.html('<span class="text_ok">OK!</span>');
								window.setTimeout(function(){ uploadStatus.hide() }, 1000);
								delImage.show();
					        } else {
								uploadStatus.html('<span class="text_error">Error!</span>');
								window.setTimeout(function(){ uploadStatus.hide() }, 1000);
							}
					    }	
					};
				}
				delImage.on('click', deleteImage);
				
			});	
		}
		else {
			console.log("Please enter valid URL for the upload.php file.");
			return false;
		}
	}
})(jQuery);