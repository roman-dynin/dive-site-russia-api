<?php

use Illuminate\Http\Request;
use Tochka\JsonRpc\Facades\JsonRpcServer;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 * @var \Laravel\Lumen\Routing\Router $router
 */

$router->get('/api/v1/user', [
    'uses' => 'AuthController@getUser',
]);

$router->post('/api/v1/jsonrpc', function (Request $request) {
    return JsonRpcServer::handle($request->getContent());
});
