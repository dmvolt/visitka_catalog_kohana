<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs(0, 'actions') ?>
	</div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: entry/entry.html - START -->
<section class="">
	<div class="container">
		<h1><span><?= $page_title ?></span></h1>
        <?//= $pagination ?>
		<?php  if($actions): ?>
			<div class="row">	
				<?php $i = 0; foreach($actions as $value): ?>
				
					<div class="col-sm-6 col-md-6">
						<div class="info-thumbnail-link">
							<div class="thumbnail info-thumbnail background-clouds color-text">
								<div class="service">
									<div class="service-name"><h3><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></h3><button onclick="location='<?= Data::_('lang_uri') ?>/actions/<?= $value['alias'] ?>'" class="btn btn-service">Перейти</button></div>
								</div>
								<?php if($value['thumb']): ?>
									<img class="round" src="<?= URL::imagepath('preview3', $value['thumb'])?>" alt="">
								<?php endif; ?>
								<h4><center><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></center></h4>
							</div>
						</div>
					</div>
					
					<?php  if($i<1): ?>
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
</section>