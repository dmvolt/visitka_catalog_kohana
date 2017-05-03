<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs($good['id'], 'catalog', $cat1, $cat2) ?>
	</div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: entry/entry.html - START -->
<section class="">
	<div class="container">
		<div class="row">
		
			<div class="col-md-3">
				<div class="list-group bright background-clouds color-text">
					<?= Catalog::left_menu_block() ?>
				</div>
			</div>
			
			<div class="col-md-9">
				<div class="content">
					<h1><span><?= $good['descriptions'][Data::_('lang_id')]['title'] ?></span></h1>
					<?= $edit_interface ?>
					<div class="row">	
						<div class="col-xs-12 col-sm-6 col-md-6">
							<?php if($good['thumb']): ?>
								<div class="row">	
									<div class="col-md-12">
										<a href="<?= URL::imagepath('colorbox', $good['thumb'])?>" class="fancybox" rel="gal1"><img class="good-left-img" src="<?= URL::imagepath('preview2', $good['thumb'])?>" alt=""></a>
									</div>
									<?php if(count($good['images'])>1): ?>
										<?php foreach($good['images'] as $key => $file): ?>
											<?php if($key): ?>
												<div class="col-xs-6 col-sm-3 col-md-3">
													<a href="<?= URL::imagepath('colorbox', $file['file']->filepathname)?>" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>" class="fancybox" rel="gal1">
														<img src="<?= URL::imagepath('preview3', $file['file']->filepathname)?>" alt="<?= $file['description'][Data::_('lang_id')]['title'] ?>" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>">
													</a>
												</div>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<?= $good['descriptions'][Data::_('lang_id')]['body'] ?>
							<p><a href="#order" class="order-button fancybox"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> Заказать</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>