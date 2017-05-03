<? if(isset($errors)){?>
<? foreach($errors as $item){?>
<p style="color:red"><?=$item ?></p>
<?}?>
<?}?>
   
<h2 class="title"><?=$text_banners ?> <a href="/admin/banners/add" title="<?=$text_add_new_banners ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>
<?php if (isset($contents) AND count($contents)>0): ?>
<table>
<thead>
<tr>
	<td><strong><?=$text_banner_thead_img ?></strong></td>
	<td><strong><?=$text_banner_thead_name ?></strong></td>
	<td><strong><?=$text_banner_thead_disp ?></strong></td>
	<td><strong><?=$text_banner_thead_status ?></strong></td>
	<td class="last"><strong><?=$text_banner_thead_action ?></strong></td>
</tr>
</thead>
<tbody>
	<?php foreach ($contents as $key => $value): ?>
		
		<tr>
			<td class="first"><div class="banners_preview">
				<?php if(isset($value['files'][0]['file']->filepathname)): ?>
					<img src="/files/thumbnails/<?=$value['files'][0]['file']->filepathname ?>" />
				<?php endif; ?>
			</div></td>	
			
			<td><?=$value['title'] ?></td>
			
			<?php if($value['display_all']): ?>
				<td><?=$text_banners_display_all ?></td>
			<?php else: ?>
				<td><?=$value['display_pages'] ?></td>
			<?php endif; ?>
			
			
			<?php if($value['status']): ?>
				<td><span style="color:green"><?=$text_active ?></span></td>
			<?php else: ?>
				<td><span style="color:red"><?=$text_inactive ?></span></td>
			<?php endif; ?>
			<td class="last"><a href="/admin/banners/edit/<?=$value['id'] ?>" class="edit"><?=$text_edit ?></a>&nbsp;&nbsp;<a href="/admin/banners/delete/<?=$value['id'] ?>" class="delete"><?=$text_delete_img ?></a></td>
		</tr>
	
	<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
	<h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>