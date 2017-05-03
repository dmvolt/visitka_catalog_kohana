<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs(0, 'articles') ?>
	</div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: entry/entry.html - START -->
<section class="">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<?php  if($articles): ?>
				
					<?= $pagination ?>
					
					<?php  foreach($articles as $value): ?>
						<div class="media blog-entry">
							<div class="pull-left">
								<?php if($value['thumb']): ?>
									<img class="media-object" src="<?= URL::imagepath('preview', $value['thumb'])?>" alt="">
								<?php endif; ?>
							</div>
							<div class="media-body">
								<div class="blog-entry-content">
									<!--<div class="category">Webdesign</div>-->
									<?= $value['edit_interface'] ?>
									<h2><a href="<?= Data::_('lang_uri') ?>/articles/<?= $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a></h2>
									<div class="date"><?= Text::format_date($value['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?> <a href="">, 4 <sup><span class="fa fa-comment-o"></span></sup></a></div>
									<div class="content">
										<?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?>
										<a href="<?= Data::_('lang_uri') ?>/articles/<?= $value['alias'] ?>"><?= $text_read_more ?> <span class="fa fa-long-arrow-right"></span></a>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					
					<?= $pagination ?>
					
				<?php else: ?>
					<h2><?= $text_page_not_found ?></h2>
				<?php endif; ?>
			</div>
			
			<div class="col-md-3">
			<!-- Responsive calendar - START -->
				<div class="responsive-calendar background-belize-hole color-white">
					<div class="controls">
						<a class="btn btn-primary pull-left" data-go="prev"><i class="fa fa-chevron-left"></i></a>
						<h4><span data-head-year>&nbsp;</span> <span data-head-month>&nbsp;</span></h4>
						<a class="btn btn-primary pull-right" data-go="next"><i class="fa fa-chevron-right"></i></a>
					</div>
					<div class="day-headers">
						<div class="day header">Mon</div>
						<div class="day header">Tue</div>
						<div class="day header">Wed</div>
						<div class="day header">Thu</div>
						<div class="day header">Fri</div>
						<div class="day header">Sat</div>
						<div class="day header">Sun</div>
					</div>
					<div class="days" data-group="days">
					<!-- the place where days will be generated -->
					</div>
				</div>
				<!-- Responsive calendar - END -->
				
				
			</div>
		</div>
	</div>
</section>