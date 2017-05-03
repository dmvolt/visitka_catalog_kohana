<?php if(count($content)>0): ?>
	<div class="appointments">
		<h2><?= $group_name ?></h2>
		<?php foreach($content as $value): ?>
		<div class="appointments-entry">
			<div class="date"><?= $value['date'] ?></div>
			<h3><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></h3>
			<p><?= $value['descriptions'][Data::_('lang_id')]['body'] ?></p>
		</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>