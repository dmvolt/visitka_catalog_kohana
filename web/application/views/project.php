<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs($project['id'], 'projects') ?>
	</div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: entry/entry.html - START -->
<section class="">
	<div class="container">
		<div class="row">
		
			<div class="col-md-3">
				<div class="list-group bright background-clouds color-text">
					<?= Projects::projects_current_block($project['id'], 100) ?>
				</div>
			</div>

			<div class="col-md-9">
				<div class="content">
					<h1><span><?= $project['descriptions'][Data::_('lang_id')]['title'] ?></span></h1> 
					<?= $edit_interface ?>
					<?= $project['descriptions'][Data::_('lang_id')]['body'] ?>
				</div>
			</div>
		</div> 
	</div>
</section>