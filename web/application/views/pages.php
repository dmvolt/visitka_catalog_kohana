<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs($page['id'], 'pages') ?>
	</div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: entry/entry.html - START -->
<section class="">
	<div class="container">
        
		<?php if($page AND $page['alias'] == 'contacts'): ?>
			<h1><span><?= $page['descriptions'][Data::_('lang_id')]['title'] ?></span></h1>
			<div class="row">
				<div class="col-sm-12 col-md-4">
					<?= $page['descriptions'][Data::_('lang_id')]['body'] ?>
				</div>
				<div class="col-md-12 col-md-8">
					<div class="main-map"><?= $site_map ?></div>
				</div>
			</div>

		<?php else: ?>
			
			<div class="row">
				<div class="col-md-12">
					<div class="content">
						<h1><span><?= $page['descriptions'][Data::_('lang_id')]['title'] ?></span></h1> 
						<?= $edit_interface ?>
						<?= $page['descriptions'][Data::_('lang_id')]['body'] ?>
					</div>
				</div>
			</div>

			<?php if($page AND $page['images'] AND count($page['images'])>1): ?>
				<?php foreach($page['images'] as $file): ?>
					<a href="/files/colorbox/<?= $file['file']->filepathname ?>" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>" class="fancybox" rel="1">
						<img src="/files/preview2/<?= $file['file']->filepathname ?>" alt="<?= $file['description'][Data::_('lang_id')]['title'] ?>" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>">
						<h4 class="text-center"><?= $file['description'][Data::_('lang_id')]['title'] ?></h4>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
			
		<?php endif; ?>
			
	</div>
</section>