<div class="form_item">
	<label><?= $group_cat['name'] ?></label><br>
	<select name="categoryId1[]" multiple style="width:200px; height:370px;">
		<?php
		$tree = new Tree();
		$tree->selectOutTree($dictionary_id, 0, 1, $parent = (isset($parent)) ? $parent : 0); //Выводим дерево в элемент выбора 
		?>
	</select>
</div>