<!-- Breadcrumbs - START -->
<div class="breadcrumbs-container">
	<div class="container"></div>
</div>
<!-- Breadcrumbs - END -->

<!-- Component: error404/404.html - START -->
<section class="">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="http-error">
					<h1 class="text-center http-error-number color-lead"><?=$answer_message ?></h1>
					<?php if(!empty($answer_errors)){ ?>
						<p>
						<?foreach($answer_errors as $item){?>
							</br><?=$item?>
						<?}?>
						</p>
					<?}?>
					<input type="button" onclick="history.back();" value="Вернуться назад" class="button">
					<p class="text-center">
						<span class="fa fa-frown-o icon-image color-lead"></span>
					</p>
				</div>
			</div>
		</div>      
	</div>
</section>
<!-- Component: error404/404.html - END -->