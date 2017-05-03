<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs(0, 'photos') ?>
	</div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: entry/entry.html - START -->
<section class="">
	<div class="container">
		<!--<h1><span><?//= $page_title ?></span></h1>-->
		
		<?php if($modulinfo AND count($modulinfo)>0): ?>
			<?= $modulinfo[0]['descriptions'][Data::_('lang_id')]['body'] ?>
		<?php endif; ?>
		
		<div class="row">
			<?php  if($photos): ?>
				<?php foreach($photos as $photo): ?>
					
					<?php if(!empty($photo['descriptions'][1]['body'])): ?>
					
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="<?php if($is_photo): ?>active<?php endif; ?>"><h3><a href="#photo" aria-controls="photo" role="tab" data-toggle="tab">Фотогалерея</a></h3></li>
							<li role="presentation" class="<?php if($is_video): ?>active<?php endif; ?>"><h3><a href="#video" aria-controls="video" role="tab" data-toggle="tab">Видео</a></h3></li>
						</ul>
						
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane <?php if($is_photo): ?>active<?php endif; ?>" id="photo">
								<div class="content photo-block">
									<?php if($photo['images']): ?>
										<?php foreach($photo['images'] as $item): ?>
											<div class="col-xs-6 col-sm-4 col-md-3">
												<a class="info-thumbnail-link fancybox" href="<?= URL::imagepath('colorbox', $item['file']->filepathname)?>" rel="photo<?= $photo['id'] ?>">
													<div class="thumbnail info-thumbnail background-clouds color-text">
														<div class="service">
															<div class="service-name"><span class="fa fa-search-plus"></span></div>
														</div>
														<img class="round" src="<?= URL::imagepath('preview3', $item['file']->filepathname)?>" alt="">
													</div>
												</a>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane <?php if($is_video): ?>active<?php endif; ?>" id="video">
								<div class="content video-block">
									<?= $photo['descriptions'][1]['body'] ?>
								</div>
							</div>
						</div>
					<?php else: ?>
					
						<h2><?= $page_title ?></h2>
						
						<?php if($photo['images']): ?>
							<?php foreach($photo['images'] as $item): ?>
								<div class="col-xs-6 col-sm-4 col-md-3">
									<a class="info-thumbnail-link fancybox" href="<?= URL::imagepath('colorbox', $item['file']->filepathname)?>" rel="photo<?= $photo['id'] ?>">
										<div class="thumbnail info-thumbnail background-clouds color-text">
											<div class="service">
												<div class="service-name"><span class="fa fa-search-plus"></span></div>
											</div>
											<img class="round" src="<?= URL::imagepath('preview3', $item['file']->filepathname)?>" alt="">
										</div>
									</a>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>	
					
					<?php endif; ?>
				<?php endforeach; ?>
			
			<?php else: ?>
				<h2><?= $text_page_not_found ?></h2>
			<?php endif; ?>
			
		</div>
	</div>
</section>