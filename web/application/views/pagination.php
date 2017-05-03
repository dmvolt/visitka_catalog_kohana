<?php if ($pagination_data['total'] > 10): ?>
	<ul class="pagination">
		<?= $pagination_data['page_nav_links'] ?> 
	</ul>
<?php endif; ?>