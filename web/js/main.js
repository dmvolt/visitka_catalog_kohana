$(document).ready(function(){
    // fancybox
	$('.fancybox').fancybox();
	
	// Маска поля формы (телефон)
	$('.phone').mask('+79999999999');
	
	// Валидация формы "Обратный звонок"
	$("#recall_form").validate({
		rules: {
			name:{
				required: true,
				maxlength: 64
			},
			phone:{
				required: true,
				maxlength: 64
			},
			text:{
				minlength: 10,
				maxlength: 2000
			}
		},
		messages: {
			name:{
				required: 'Пожалуйста, заполните это поле.',
				maxlength: 'Максимальное количество символов - 64.'
			},
			phone:{
				required: 'Пожалуйста, заполните это поле.',
				maxlength: 'Максимальное количество символов - 64.'
			},
			text:{
				minlength: 'Минимальное количество символов - 10.',
				maxlength: 'Максимальное количество символов - 2000.'
			}
		},
		submitHandler: function(form) {
			recall(form);
		}
	});
	
	// Валидация формы "Обратная связь" в футере
	$("#feedback_form").validate({
		rules: {
			name:{
				required: true,
				maxlength: 64
			},
			phone:{
				maxlength: 64
			},
			email:{
				required: true,
				email: true
			},
			text:{
				required: true,
				minlength: 10,
				maxlength: 2000
			}
		},
		messages: {
			name:{
				required: 'Пожалуйста, заполните это поле.',
				maxlength: 'Максимальное количество символов - 64.'
			},
			phone:{
				maxlength: 'Максимальное количество символов - 64.'
			},
			email:{
				required: 'Пожалуйста, заполните это поле.',
				email: 'Некорректный E-mail адрес.'
			},
			text:{
				required: 'Пожалуйста, заполните это поле.',
				minlength: 'Минимальное количество символов - 10.',
				maxlength: 'Максимальное количество символов - 2000.'
			}
		},
		submitHandler: function(form) {
			feedback(form);
		}
	});
	
	// Валидация формы "Заявка на замер"
	$("#order_form").validate({
		rules: {
			name:{
				required: true,
				maxlength: 64
			},
			phone:{
				required: true,
				maxlength: 64
			},
			text:{
				minlength: 10,
				maxlength: 2000
			}
		},
		messages: {
			name:{
				required: 'Пожалуйста, заполните это поле.',
				maxlength: 'Максимальное количество символов - 64.'
			},
			phone:{
				required: 'Пожалуйста, заполните это поле.',
				maxlength: 'Максимальное количество символов - 64.'
			},
			text:{
				minlength: 'Минимальное количество символов - 10.',
				maxlength: 'Максимальное количество символов - 2000.'
			}
		},
		submitHandler: function(form) {
			order(form);
		}
	});
});

function order(form)
{
	var data = $(form).serialize();
	$.ajax({
		type: "POST",
		data: data,
		url: "/feedback/order",
		dataType: "json",
		beforeSend: function() {
			$(".loading").show();
		},		
		complete: function() {
			$(".loading").hide();
		},			
		success: function(data)
		{
			if(data.result)
			{
				$("#order_form").html('<h4>Спасибо, что обратились в нашу компанию!<br>Мы получили Ваше сообщение и в ближайшее время свяжемся с вами.</h4>');
			}
			else
			{
				$("#order_thanks").show();
				if(data.errors){
					$("#order_thanks").html('<strong>Ошибка!</strong> ' + data.errors);
				} else {
					$("#order_thanks").html('<strong>Ошибка!</strong> Ошибка в заполнении полей сообщения.');
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
}

function recall(form)
{
	var data = $(form).serialize();
	$.ajax({
		type: "POST",
		data: data,
		url: "/feedback/recall",
		dataType: "json",
		beforeSend: function() {
			$(".loading").show();
		},		
		complete: function() {
			$(".loading").hide();
		},			
		success: function(data)
		{
			if(data.result)
			{
				$("#recall_form").html('<h4>Спасибо, что обратились в нашу компанию!<br>Мы получили Ваше сообщение и в ближайшее время свяжемся с вами.</h4>');
			}
			else
			{
				$("#recall_thanks").show();
				if(data.errors){
					$("#recall_thanks").html('<strong>Ошибка!</strong> ' + data.errors);
				} else {
					$("#recall_thanks").html('<strong>Ошибка!</strong> Ошибка в заполнении полей сообщения.');
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
}

function feedback(form)
{
	var data = $(form).serialize();
	$.ajax({
		type: "POST",
		data: data,
		url: "/feedback/feedback",
		dataType: "json",
		beforeSend: function() {
			$(".loading").show();
		},		
		complete: function() {
			$(".loading").hide();
		},			
		success: function(data)
		{
			if(data.result)
			{
				$("#feedback_form").html('<h3>Спасибо, что обратились в нашу компанию!<br>Мы получили Ваше сообщение и в ближайшее время свяжемся с вами.</h3>');
			}
			else
			{
				$("#feedback_thanks").show();
				if(data.errors){
					$("#feedback_thanks").html('<strong>Ошибка!</strong> ' + data.errors);
				} else {
					$("#feedback_thanks").html('<strong>Ошибка!</strong> Ошибка в заполнении полей сообщения.');
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
}