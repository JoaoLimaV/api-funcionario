<?php



require '../vendor/autoload.php';
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

$router->get('/', function () use ($router) {
	$response = [
		"response" => "Use api/cliente to access the api. Read the documentation on github",
		"link_documentation" => ""
	];

	return response()->json( $response );

});

$router->get('/api/cliente', "ClienteController@getAll");
$router->get('/api/cliente/resume', "ClienteController@getResume");
$router->get('/api/cliente/{id}', "ClienteController@findById");

$router->get('/api/carrinho', "CarrinhoController@getAll");
$router->get('/api/carrinho/{id}', "CarrinhoController@findByCustomerId");
$router->post('/api/carrinho/add/item/{id}', "CarrinhoController@addItem");
$router->put('/api/carrinho/update/item/{id}', "CarrinhoController@updateItem");

$router->get('/api/pedido', "PedidoController@getAll");
$router->get('/api/pedido/{id}', "PedidoController@findByCustomerId");







$router->get('/api/funcionario', "FuncionarioController@getAll");








