<?php

use Illuminate\Http\Request;
use Tochka\JsonRpc\Facades\JsonRpcServer;

/**
 * @var \Laravel\Lumen\Routing\Router $router
 */
$router->get('/api/v1/user', [
    'uses' => 'AuthController@getUser',
]);

$router->post('/api/v1/jsonrpc', function (Request $request) {
    return JsonRpcServer::handle($request->getContent());
});
