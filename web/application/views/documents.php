<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container">
		<?= Breadcrumbs::get_breadcrumbs(0, 'documents') ?>
	</div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: entry/entry.html - START -->
<section class="">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="content">
					<h1><span><?= $page_title ?></span></h1>
					<?php  if($documents): ?>
					
						<?php  foreach($documents as $value): ?>
							
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value['id']?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a>
									</h4>
								</div>
								<div id="collapse<?= $value['id']?>" class="panel-collapse collapse">
									<div class="panel-body background-clouds">
										<?php  if($value['children'] AND count($value['children'])>0): ?>
											<?php  foreach($value['children'] as $value2): ?>
												
												<?php  if($value2['children'] AND count($value2['children'])>0): ?>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
																<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value2['id']?>"><?= $value2['descriptions'][Data::_('lang_id')]['title'] ?></a>
															</h4>
														</div>
														<div id="collapse<?= $value2['id']?>" class="panel-collapse collapse">
															<div class="panel-body background-clouds">
																<?php  if($value2['children'] AND count($value2['children'])>0): ?>
																	
																	<?php  foreach($value2['children'] as $value4): ?>
																		<?php  if(!empty($value4['link'])): ?>
																			<div class="media blog-entry">
																				<div class="pull-left">
																					<?php if($value4['thumb']): ?>
																						<img class="media-object" src="<?= URL::imagepath('preview', $value4['thumb'])?>" alt="">
																					<?php endif; ?>
																				</div>
																				<div class="media-body">
																					<div class="blog-entry-content">
																						<h4><?= $value4['descriptions'][Data::_('lang_id')]['title'] ?></h4>
																						<div class="date"><?= Text::format_date($value4['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?></div>
																						<div class="content">
																							<?= $value4['descriptions'][Data::_('lang_id')]['teaser'] ?>
																							<a href="<?= $value4['link'] ?>">Скачать</a>
																						</div>
																					</div>
																				</div>
																			</div>
																		<?php endif; ?>
																	<?php endforeach; ?>
																
																	<?php  if(!empty($value2['link'])): ?>
																		<div class="media blog-entry">
																			<div class="pull-left">
																				<?php if($value2['thumb']): ?>
																					<img class="media-object" src="<?= URL::imagepath('preview', $value2['thumb'])?>" alt="">
																				<?php endif; ?>
																			</div>
																			<div class="media-body">
																				<div class="blog-entry-content">
																					<h4><?= $value2['descriptions'][Data::_('lang_id')]['title'] ?></h4>
																					<div class="date"><?= Text::format_date($value2['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?></div>
																					<div class="content">
																						<?= $value2['descriptions'][Data::_('lang_id')]['teaser'] ?>
																						<a href="<?= $value2['link'] ?>">Скачать</a>
																					</div>
																				</div>
																			</div>
																		</div>
																	<?php endif; ?>
																	
																<?php endif; ?>
															</div>
														</div>
													</div>
												<?php endif; ?>
										
												<?php  if(!empty($value2['link'])): ?>
													<div class="media blog-entry">
														<div class="pull-left">
															<?php if($value2['thumb']): ?>
																<img class="media-object" src="<?= URL::imagepath('preview', $value2['thumb'])?>" alt="">
															<?php endif; ?>
														</div>
														<div class="media-body">
															<div class="blog-entry-content">
																<h4><?= $value2['descriptions'][Data::_('lang_id')]['title'] ?></h4>
																<div class="date"><?= Text::format_date($value2['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?></div>
																<div class="content">
																	<?= $value2['descriptions'][Data::_('lang_id')]['teaser'] ?>
																	<a href="<?= $value2['link'] ?>">Скачать</a>
																</div>
															</div>
														</div>
													</div>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
							
						<?php endforeach; ?>
						
					<?php else: ?>
						<h2><?= $text_page_not_found ?></h2>
					<?php endif; ?>
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
	</div>
</section>