<?php

// O software postamn está sendo usado para realizar os testes sem ter usar um documento de formulário

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';

$app = new \Slim\App;

/* Padrão PSR7: define interfaces para mensagens HTTP, como requisições e respostas, em aplicações PHP */
$app->get('/postagens', function(Request $request, Response $response){

	/* Escreve no corpo da resposta utilizando o padrão PSR7 */
	$response->getBody()->write("Listagem de postagens");
	return $response;

});

/*
Tipos de requisição ou Verbos HTTP
get -> Recuperar recursos do servidor (Select)
post -> Criar dado no servidor (Insert)
put -> Atualizar dados no servidor (Update)
delete -> Deletar dados do servidor (Delete)
*/

$app->delete('/usuarios/remove/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');
	
	/*Deletar do banco de dados com DELETE..
	....*/

	return $response->getBody()->write( "Sucesso ao deletar: " . $id );

} );

$app->put('/usuarios/atualiza', function(Request $request, Response $response){

	//Recupera post ($_POST)
	$post  = $request->getParsedBody();
	$id    = $post['id'];
	$nome  = $post['nome'];
	$email = $post['email'];

	/*
	Atualizar no banco de dados com UPDATE..
	....
	*/

	return $response->getBody()->write( "Sucesso ao atualizar: " . $id );

} );

$app->post('/usuarios/adiciona', function(Request $request, Response $response){

	//Recupera post ($_POST)
	$post  = $request->getParsedBody();
	$nome  = $post['nome'];
	$email = $post['email'];

	/*
	Salvar no banco de dados com INSERT INTO..
	....
	*/

	return $response->getBody()->write( "Sucesso" );

} );

$app->run();
?>