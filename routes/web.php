<?php

/**
 * @var \Laravel\Lumen\Routing\Router $router
 */

$router->get('auth/vkontakte', [
    'uses' => 'AuthController@vkontakte',
]);

$router->get('auth/vkontakte/callback', [
    'uses' => 'AuthController@vkontakteCallback',
]);

$router->get('auth/telegram', [
    'uses' => 'AuthController@telegram',
]);

$router->get('auth/telegram/callback', [
    'uses' => 'AuthController@telegramCallback',
]);
