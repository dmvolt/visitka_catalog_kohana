<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
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
					
					<?php  if($articles): ?>
						
						<?//= $pagination ?>
						
						<?php  if(isset($articles['pages'])): ?>
							<?php foreach($articles['pages'] as $article): ?>
								<div class="row">	
									<div class="col-sm-12 col-md-12">
										<h3><a href="<?= Data::_('lang_uri') ?><?= $article['link'] ?>"><?= Text::mark($article['content']['descriptions'][Data::_('lang_id')]['title'], $words) ?></a></h3>
										<?= Text::mark($article['content']['descriptions'][Data::_('lang_id')]['teaser'], $words) ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
							
						<?php if(isset($articles['catalog'])): ?>
							<?php foreach($articles['catalog'] as $article): ?>
								<div class="row">	
									<div class="col-sm-12 col-md-12">
										<h3><a href="<?= Data::_('lang_uri') ?><?= $article['link'] ?>"><?= Text::mark($article['content']['descriptions'][Data::_('lang_id')]['title'], $words) ?></a></h3>
										<?= Text::mark($article['content']['descriptions'][Data::_('lang_id')]['teaser'], $words) ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
							
						<?php if(isset($articles['services'])): ?>
							<?php foreach($articles['services'] as $article): ?>
								<div class="row">	
									<div class="col-sm-12 col-md-12">
										<h3><a href="<?= Data::_('lang_uri') ?><?= $article['link'] ?>"><?= Text::mark($article['content']['descriptions'][Data::_('lang_id')]['title'], $words) ?></a></h3>
										<?= Text::mark($article['content']['descriptions'][Data::_('lang_id')]['teaser'], $words) ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						
						<?php if(isset($articles['projects'])): ?>
							<?php foreach($articles['projects'] as $article): ?>
								<div class="row">	
									<div class="col-sm-12 col-md-12">
										<h3><a href="<?= Data::_('lang_uri') ?><?= $article['link'] ?>"><?= Text::mark($article['content']['descriptions'][Data::_('lang_id')]['title'], $words) ?></a></h3>
										<?= Text::mark($article['content']['descriptions'][Data::_('lang_id')]['teaser'], $words) ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						
						<?//= $pagination ?>
						
					<?php else: ?>
						<h3>По вашему запросу ничего не найдено.</h3>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>