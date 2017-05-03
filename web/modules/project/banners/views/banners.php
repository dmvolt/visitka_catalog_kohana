<?php if(!empty($banners_data)): ?>
	<div class="slider">
		<div id="slider-pictures">
			<?php foreach($banners_data['files'] as $file): ?>
				<a href="<?=$file['description']->title ?>"><img src="/files/top/<?=$file['file']->filepathname ?>" alt="slider-image"></a>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

			
	  

