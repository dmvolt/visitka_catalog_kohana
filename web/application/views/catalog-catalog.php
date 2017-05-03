<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs(0, 'catalog', $cat1, $cat2, $cat3) ?>
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
		
					<h1><span><?= $page_title ?></span></h1>
					
					<?= $catpage[0]['descriptions'][Data::_('lang_id')]['body'] ?>
					
					<?php  if($categories): ?>
						<div class="row">	
							<?php $i = 0; foreach($categories as $value): ?>
							
								<?php if($value['thumb']): ?>
									<div class="col-sm-6 col-md-3">
										<div class="info-thumbnail-link">
											<div class="thumbnail info-thumbnail background-clouds color-text">
												<div class="service">
													<div class="service-name"><h3><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></h3><button onclick="location='<?= Data::_('lang_uri') ?>/catalog/<?= $cat1 ?><?php if($cat2):?>/<?= $cat2 ?><?php endif; ?>/<?= $value['alias'] ?>'" class="btn btn-service">Перейти</button></div>
												</div>
												<img class="round" src="<?= URL::imagepath('preview3', $value['thumb'])?>" alt="">
												<h4><center><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></center></h4>
											</div>
										</div>
									</div>
								<?php else: ?>
									<div class="col-sm-6 col-md-3">
										<div class="info-thumbnail-link">
											<h3><a href="<?= Data::_('lang_uri') ?>/catalog/<?= $cat1 ?><?php if($cat2):?>/<?= $cat2 ?><?php endif; ?>/<?= $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a></h3>
										</div>
									</div>
								<?php endif; ?>
								
								<?php  if($i<3): ?>
									<?php $i++; ?>
								<?php else: ?>
									<?php $i = 0; ?>
									</div><div class="row">
								<?php endif; ?>
					  
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					
					<?php  if($catalog): ?>
						
						<?= $pagination ?>
						
						<div class="row row-striped">
						
							<?php $i = 0; foreach($catalog as $value): ?>
								
								<div class="col-sm-12 col-md-12 spriped">
									<div class="col-xs-5 col-sm-2 col-md-2">
										<?php if($value['thumb']): ?>
											<a href="<?= Data::_('lang_uri') ?>/catalog/<?= $cat1 ?><?php if($cat2):?>/<?= $cat2 ?><?php endif; ?><?php if($cat3):?>/<?= $cat3 ?><?php endif; ?>/g-<?= $value['alias'] ?>"><img class="round" src="<?= URL::imagepath('preview', $value['thumb'])?>" alt=""></a>
										<?php endif; ?>
									</div>
									
									<div class="col-xs-7 col-sm-7 col-md-7">
										<h4><a href="<?= Data::_('lang_uri') ?>/catalog/<?= $cat1 ?><?php if($cat2):?>/<?= $cat2 ?><?php endif; ?><?php if($cat3):?>/<?= $cat3 ?><?php endif; ?>/g-<?= $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a></h4>
										<?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?>
									</div>
									
									<div class="col-xs-12 col-sm-3 col-md-3">
										<a href="#order" class="order-button fancybox"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> Заказать</a>
									</div>
								</div>
									
								<?php  //if($i<1): ?>
									<?php //$i++; ?>
								<?php //else: ?>
									<?php //$i = 0; ?>
									<!--</div><div class="row">-->
								<?php //endif; ?>
							<?php endforeach; ?>
						</div>
						
						<?= $pagination ?>
						
					<?php else: ?>
						<?php if($cat2):?>
							<h3>Товаров в категории не найдено.</h3>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>