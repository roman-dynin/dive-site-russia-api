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
