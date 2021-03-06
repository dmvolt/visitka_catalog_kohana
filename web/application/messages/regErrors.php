<?
return array(
    'login' => array(
        'not_empty' => 'Вы не ввели логин.',
		'min_length' => 'Логин должен содержать от 3 до 64 символов.',
		'max_length' => 'Логин должен содержать от 3 до 64 символов.',
	    'username_unique' => 'Такой логин уже зарегистрирован в системе.',
		'alpha_numeric' => 'Логин может состоять из латинских символов ( A - Z, a - z ) и (или) цифр ( 0 - 9 ).',
 ),
	'email' => array(
		'not_empty' => 'Вы не ввели E-mail',
		'email' => 'Неверный формат E-mail',
		'email_unique' => 'Такой E-mail уже зарегистрирован в системе.',
),
);
