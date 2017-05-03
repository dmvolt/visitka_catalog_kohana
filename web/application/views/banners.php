<?php if(!empty($banners_data) AND $banners_data['files']): ?>
	<div id="carousel-example-generic" class="carousel slide main-banner" data-ride="carousel">
	
		<?php if(count($banners_data['files'])>1): ?>
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<?php foreach($banners_data['files'] as $num => $file): ?>
					<li data-target="#carousel-example-generic" data-slide-to="<?= $num ?>" <?php if(!$num): ?>class="active"<?php endif; ?>></li>
				<?php endforeach; ?>
			</ol>
		<?php endif; ?>
	
		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<?php foreach($banners_data['files'] as $num => $file): ?>
				<div class="item <?php if(!$num): ?>active<?php endif; ?>">
				
					<?php if(!empty($file['description'][Data::_('lang_id')]['link'])): ?>
						<a href="<?=$file['description'][Data::_('lang_id')]['link'] ?>"><img src="/files/<?= $file['file']->filename; ?>" class="main-banner-img" alt=""></a>
					<?php else: ?>
						<img src="/files/<?= $file['file']->filename; ?>" class="main-banner-img" alt="">
					<?php endif; ?>
					
					<div class="carousel-caption">
						<?php if(!empty($file['description'][Data::_('lang_id')]['title'])): ?>
							<h2><?=$file['description'][Data::_('lang_id')]['title'] ?></h2>
						<?php endif; ?>
						<?php if(!empty($file['description'][Data::_('lang_id')]['description'])): ?>
							<p><?=$file['description'][Data::_('lang_id')]['description'] ?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if(count($banners_data['files'])>1): ?>
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		<?php endif; ?>
	</div>
<?php endif; ?>