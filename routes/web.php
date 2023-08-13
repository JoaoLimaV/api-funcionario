<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
use App\Models\Funcionario;

$router->get('/', function () use ($router) {
	$response = [
		"response" => "Use api/funcionario to access the api. Read the documentation on github",
		"link_documentation" => "https://github.com/PedroAbreu04/Lab_DevWeb"
	];

	return response()->json( $response );
});

$router->group(['prefix' => '/api/funcionario'], function () use ($router) {
	$router->get('/', "FuncionarioController@getAll");
	$router->get('/{id}', "FuncionarioController@findById");
	$router->post('/save', "FuncionarioController@save");
	$router->put('/update/{id}', "FuncionarioController@update");
	$router->delete('/delete/{id}', "FuncionarioController@delete");
});








