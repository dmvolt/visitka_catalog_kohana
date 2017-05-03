<!--===============================================================  Intro =====================================================================================--> 
<?php if(isset($errors) AND $errors): ?>
	<div class="wrapper">
 		<div class="grids">
			<div class="grid-16 grid intro grey">
				<p>
				<?php foreach($errors as $item): ?>
					<span style="color:red"><?= $item ?></span>
				<?php endforeach; ?>
				</p>
			</div>
		</div>
    </div>
<?php endif; ?>

<?php if(isset($ok) AND $ok): ?>
	<div class="wrapper">
 		<div class="grids">
			<div class="grid-16 grid intro grey">
				<p style="color:green"><?= $ok ?></p>
			</div>
		</div>
    </div>
<?php endif; ?>

<!--===============================================================  Green box (sidebar) =====================================================================================-->     
      
	<div class="wrapper">
		<hr> 
		
		<div class="grids">
			<div class="grid-10 grid">
			
				<h2><?= $page_title ?></h2>
				
				<?php if($reviews): ?>
				
					<?php  foreach($reviews as $article): ?>
						
							<!--<h4><?//= $article['descriptions'][Data::_('lang_id')]['title'] ?></h4>-->
							
								<?php if(isset($article['thumb']) AND $article['thumb']): ?>
									<img src="/files/preview/<?= $article['thumb'] ?>" alt="" class="left">
								<?php endif; ?>
								<em><?= $article['descriptions'][Data::_('lang_id')]['body'] ?></em>
								<div class="date"><small><?= $article['descriptions'][Data::_('lang_id')]['title'] ?> (<?= Text::format_date($article['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?>)</small></div>
							
						
						<?php if($article['answer']): ?>
							<?php  foreach($article['answer'] as $article2): ?>
								<!--<h4><?//= $article2['descriptions'][Data::_('lang_id')]['title'] ?></h4>-->
								
									<?php if(isset($article2['thumb']) AND $article2['thumb']): ?>
										<img src="/files/preview/<?= $article2['thumb'] ?>" alt="" class="left">
									<?php endif; ?>
									<em><?= $article2['descriptions'][Data::_('lang_id')]['body'] ?></em>
									<div class="date"><small><?= $article2['descriptions'][Data::_('lang_id')]['title'] ?> (<?= Text::format_date($article2['date'], 'd m Y', ' ', false, Data::_('lang_id')) ?>)</small></div>
								
							<?php endforeach; ?>
						<?php endif; ?>
						<hr>
					<?php endforeach; ?>
					
				<?php else: ?>
					<h2><?= $text_page_not_found ?></h2>
				<?php endif; ?>
                           
			</div><!--end of grid-10-->
			
			<div class="grid-6 grid green">
				<h4>Оставить отзыв</h4>
				
				<form id="reviews-form" method="post">
					<table class="form">
						<tr>	
							<td>
								<label for="name">Имя<span class="r">*</span></label><br>
								<input class="input_full" type="text" name="name" required="required" placeholder="Как вас зовут?">
							</td>
						</tr>
						<tr>
							<td>
								<label for="text">Текст отзыва<span class="r">*</span></label><br>
								<textarea name="text" rows="8" placeholder="Напишите сюда что-то хорошее"></textarea>
							</td>
						</tr>
						<tr>
							<th>
								<input type="submit" value="Отправить" class="button-services">
							</th>
						</tr>
					</table>
				</form>
			</div>		 
		</div><!--end of grids-->    
	</div><!--end of wrapper-->