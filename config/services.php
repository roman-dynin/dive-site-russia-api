<?php

return [

    'vkontakte' => [

        'client_id'     => env('VKONTAKTE_CLIENT_ID'),
        'client_secret' => env('VKONTAKTE_CLIENT_SECRET'),
        'redirect'      => env('VKONTAKTE_REDIRECT_URI'),
    ],

    'telegram' => [

        'bot'           => env('TELEGRAM_BOT_NAME'),
        'client_id'     => null,
        'client_secret' => env('TELEGRAM_TOKEN'),
        'redirect'      => env('TELEGRAM_REDIRECT_URI'),
    ],
];
