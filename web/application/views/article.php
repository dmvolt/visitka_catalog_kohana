<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs($article['id'], 'articles') ?>
	</div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: entry/entry.html - START -->
<section class="">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="blog-entry">
					<div class="blog-entry-content no-border">
						<?php if($article): ?>
							<!--<div class="category">Webdesign</div>-->
							<h1><span><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></span></h1>
							<!--<div class="date">2013.11.30 16:34, <a href="">4 <sup><span class="fa fa-comment-o"></span></sup></a></div>-->
							<div class="content">
								<?= $edit_interface ?>
								<?= $article['descriptions'][Data::_('lang_id')]['body'] ?>
							</div>
						<?php else: ?>
							<h2><?= $text_page_not_found ?></h2>
						<?php endif; ?>
					</div>
				</div>
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

		<?php //if($article AND $article['images'] AND count($article['images'])>1): ?>
			<?php //foreach($article['images'] as $file): ?>
				<!--<a href="/files/colorbox/<?//= $file['file']->filepathname ?>" title="<?//= $file['description'][Data::_('lang_id')]['title'] ?>" class="fancybox" rel="1">
					<img src="/files/preview2/<?//= $file['file']->filepathname ?>" alt="<?//= $file['description'][Data::_('lang_id')]['title'] ?>" title="<?//= $file['description'][Data::_('lang_id')]['title'] ?>">
					<h4 class="text-center"><?//= $file['description'][Data::_('lang_id')]['title'] ?></h4>
				</a>-->
			<?php //endforeach; ?>
		<?php //endif; ?>

	</div>
</section>