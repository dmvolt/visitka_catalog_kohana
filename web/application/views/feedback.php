<form class="narrow-form" id="feedback-form">
	<h2><?= $text_contact_form ?></h2>
	<div id="feedback_thanks"></div>
	<div class="form-group">
		<label for="feedback_name"><?= $text_contact_form_name ?><span class="r">*</span></label> <input type="text" id="feedback_name" name="feedback_name">
	</div>
	<div class="form-group">
		<label for="feedback_tell"><?= $text_contact_form_phone ?></label> <input type="text" class="phone" id="feedback_tell" name="feedback_tell">
	</div>
	<div class="form-group">
		<label for="feedback_email"><?= $text_contact_form_email ?><span class="r">*</span></label> <input type="text" id="feedback_email" name="feedback_email">
	</div>
	<div class="form-group">
		<label for="feedback_city"><?= $text_contact_form_city ?></label> <input type="text" id="feedback_city" name="feedback_city">
	</div>
	<div class="form-group">
		<label for="feedback_message"><?= $text_contact_form_message ?><span class="r">*</span></label> <textarea id="feedback_message" name="feedback_message"></textarea>
	</div>
	<p><?= $text_contact_form_notice ?></p>
	<div class="form-group">
		<button type="button" onclick="$('#feedback-form').submit();" class="button"><img src="/images/admin/loader.gif" class="loading" style="display:none;"><?= $text_contact_form_submit ?></button>
	</div>
</form>