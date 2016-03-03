<?php

return [
	'table'        => 'messages',
	'model'        => App\Models\Message::class,
	'token_length' => '6',
	'time'         => '5', // 验证码有效期
];