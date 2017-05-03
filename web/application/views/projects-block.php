<?php if($projects): ?>
	<h2><span>Наши проекты</span></h2>
	<div class="row">
		<?php $i = 0; foreach($projects as $value): ?>
		
			<div class="col-sm-4 col-md-4">
				<div class="info-thumbnail-link">
					<div class="thumbnail info-thumbnail background-clouds color-black">
						<?php if($value['thumb']): ?>
							<img class="round" src="<?= URL::imagepath('preview3', $value['thumb'])?>" alt="">
						<?php endif; ?>
						<div class="caption">
							<h3><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></h3>
							<div class="description"><?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
							<p class="buttons"><a href="<?= Data::_('lang_uri') ?>/projects/<?= $value['alias'] ?>" class="btn btn-lead">Подробнее</a></p>
						</div>
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
<?php endif; ?>