<?php if(count($products)>0): 
    $count = count($products)-1; ?>
    <ul class="breadcrumbs">
	    <?php foreach($products as $key => $product): ?>
			<?php if($key != $count): ?>
			    <li><a <?=$product['href'] ?>><?=$product['name'] ?></a><span>/</span></li>
			<?php elseif($key == $count): ?>
			    <li class="last"><a><?=$product['name'] ?></a></li>
			<?php endif; ?>
	    <?php endforeach; ?>
	</ul>
	<div class="clear"></div>
<?php endif; ?>