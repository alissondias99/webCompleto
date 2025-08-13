<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

//Tipos de resposta (cabeçalho, texto, json, XML)

$app->get('/header', function (Request $request, Response $response) {

    $response->write("Esse é o retorno header");
    return $response->withHeader('allow', 'PUT') // método que altera o objeto header para um nova objeto response
        ->withAddedHeader('Content-Length', 10); // o método define a quantidade de caracteres que será exibido
});

$app->get('/json', function (Request $request, Response $response) {

    return $response->withJson([ // converte um array para formato Json
        "nome" => 'Alisson',
        'email' => 'ali@gmail.com'
    ]);
});

$app->get('/xml', function (Request $request, Response $response) {

    $xml = file_get_contents('arquivo.xml');
    $response->write($xml);

    return $response->withHeader('Content-Type', 'application/xml');
});

// middleware; Pode ser usado para validar um usuário antes dele poder acessar a aplicação 

$app->add(function ($request, $response, $next) {

    $response->write('Camada 1 + '); // adiciona a camada extra

    $response = $next($request, $response); // chama a proxima rota após a camada anterior ser validada
    $response->write(' + Fim camada 1'); // adiciona uma resposta na saída do middleware
    return $response;
});

$app->add(function ($request, $response, $next) { // o middleware 2 é executado primeiro

    $response->write('Camada 2 + ');

    $response = $next($request, $response);
    $response->write(' + Fim camada 2'); 
    return $response;
});

$app->get('/user', function (Request $request, Response $response) {

    $response->write('Ação da página');
});

$app->run();