<?php if(count($breadcrumbs)>0): 
    $count = count($breadcrumbs)-1; ?>
	<ol class="breadcrumb">
		<?php foreach($breadcrumbs as $key => $item): ?>
			<?php if($key != $count): ?>
				<li><a <?=$item['href'] ?>><?=$item['name'] ?></a></li>
			<?php elseif($key == $count): ?>
				<li class="active"><?=$item['name'] ?></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>