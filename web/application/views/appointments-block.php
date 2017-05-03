<section class="site-row wide-row bottom-row">
	<div class="site-row site-padding" id="appointments-block">
		<h2>Оставьте заявку прямо сейчас!</h2>
		<form class="narrow-form" id="appointments-form" method="post">
			<div class="form-group">
				<label for="category_id">Направление<span class="r">*</span></label>
				<select name="category_id" onchange="getCurrentDoctors(this.value);">
					<option value="0" selected disabled>Выберите направление</option>
					<?php $tree = new Tree(); ?>
					<?php $tree->selectOutTree(1, 0, 1, $parent = (isset($parent)) ? $parent : ''); //Выводим дерево в элемент выбора ?>
				</select>
			</div>
			<?php if ($doctors): ?>
				<div class="form-group">
					<label for="doctor_id">Врач</label>
					<select name="doctor_id" id="doctor_select">
						<option value="0" selected disabled>Выберите врача</option>
						<?php foreach($doctors as $value): ?>
							<option value="<?= $value['id'] ?>"><?= $value['descriptions'][1]['title'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>
			<div class="form-group">
				<label for="name">Имя<span class="r">*</span></label> <input type="text" name="name" placeholder="Как вас зовут?">
			</div>
			<div class="form-group">
				<label for="contact">Телефон или E-mail<span class="r">*</span></label> <input type="text" name="contact" placeholder="Как с вами связаться?">
			</div>
			<div class="form-group">
				<label for="time">Время</label> <input type="text" name="time" placeholder="Удобное для вас время">
			</div>
			<div id="appointments_thanks" style="display:none;"></div>
			<div class="form-group">
				<button type="submit">Отправить <img src="/images/admin/loader.gif" class="loading" style="display:none;"></button>
			</div>
		</form>
	</div>
</section>