<div id="order" class="fancybox-hidden" style="display:none;">
	<h3>Заказ товара</h3>
	<p>Пожалуйста оставьте ваш номер телефона и мы свяжемся с вами в ближайшее время для уточнения деталей</p>
	<form id="order_form" method="post" role="form">
		<div class="form-group">
			<label for="name">Имя<span class="r">*</span></label>
			<input class="form-control" type="text" name="name" placeholder="Как вас зовут?">
		</div>
		
		<div class="form-group">
			<label for="phone">Телефон<span class="r">*</span></label>
			<input class="form-control phone" type="text" name="phone" placeholder="Ваш номер телефона">
		</div>
		
		<div class="form-group">
			<label for="text" class="control-label">Комментарий</label>
			<textarea name="text" class="form-control" rows="5" placeholder="Если хотите что то дополнительно сообщить, напишите это здесь."></textarea>
		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-lead btn-block"><img src="/images/admin/loader.gif" class="loading" style="border-radius:20px;display:none;"> Заказать</button>
		</div>
	</form>
</div>