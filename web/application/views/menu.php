<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $item): ?>
		<li class="<?php if ($item['childs']): ?>dropdown<?php endif; ?> <?php if ($item['url'] == $url OR Data::_('lang_uri').$item['url'] == $url): ?>active<?php endif; ?>">
			<a href="<?= Data::_('lang_uri') ?><?= $item['url'] ?>" <?php if ($item['childs']): ?>class="dropdown-toggle" data-toggle="dropdown"<?php endif; ?>><?= $item['descriptions'][Data::_('lang_id')]['title'] ?><?php if ($item['childs']): ?> <b class="caret"></b><?php endif; ?></a>
			<?php if ($item['childs']): ?>
				<ul class="dropdown-menu">
					<?php foreach ($item['childs'] as $item2): ?>
						<li <?php if ($item2['url'] == $url OR Data::_('lang_uri').$item2['url'] == $url): ?>class="active"<?php endif; ?>>
							<a href="<?= Data::_('lang_uri') ?><?= $item2['url'] ?>"><?= $item2['descriptions'][Data::_('lang_id')]['title'] ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
<?php endif; ?>