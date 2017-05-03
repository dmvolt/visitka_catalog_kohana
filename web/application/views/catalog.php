<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs(0, 'catalog') ?>
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
					<?//= $pagination ?>
					<?php  if($catalog): ?>
						<div class="row">	
							<?php $i = 0; foreach($catalog as $value): ?>
							
								<div class="col-sm-6 col-md-3">
									<div class="info-thumbnail-link">
										<div class="thumbnail info-thumbnail background-clouds color-text">
											<div class="service">
												<div class="service-name"><h3><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></h3><button onclick="location='<?= Data::_('lang_uri') ?>/catalog/<?= $value['alias'] ?>'" class="btn btn-service">Перейти</button></div>
											</div>
											<?php if($value['thumb']): ?>
												<img class="round" src="<?= URL::imagepath('preview3', $value['thumb'])?>" alt="">
												<h4><center><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></center></h4>
											<?php endif; ?>
										</div>
									</div>
								</div>
								
								<?php  if($i<3): ?>
									<?php $i++; ?>
								<?php else: ?>
									<?php $i = 0; ?>
									</div><div class="row">
								<?php endif; ?>
					  
							<?php endforeach; ?>
						</div>	
					<?php else: ?>
						<h2><?= $text_page_not_found ?></h2>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>