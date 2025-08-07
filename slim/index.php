<?php

require "vendor/autoload.php";

$app = new \Slim\App;

$app->get('/postagens2', function () {
    echo 'Lista postagens';
});

$app->get('/users[/{id}]', function ($request, $response) {
    $id = $request->getAttribute('id');
    echo 'Lista usuarios ' . $id;
});

$app->get('/postagens[/{ano}[/{mes}]]', function ($request, $response) {
    $ano = $request->getAttribute('ano');
    $mes = $request->getAttribute('mes');
    echo 'Lista postagens ' .  ' Ano: ' . $ano . ' Mês: ' . $mes;
});

$app->get('/lista/{itens:.*}', function ($request, $response) {
    $itens = $request->getAttribute('itens');
    var_dump(explode("/", $itens)); // mostra que cada itens acresentado na url é retornado dentro de um array e pode ser tratado como tal
});

$app->get('/blog/postagens/{id}', function ($request, $response) {
    $itens = $request->getAttribute('itens');
    var_dump(explode("/", $itens)); // mostra que cada itens acresentado na url é retornado dentro de um array e pode ser tratado como tal
})->setName('blog'); // define um nome para a rota para que seja mais facil reutilizar

$app->get('/meusite', function ($request, $response) {
    echo $retorno = $this->get("router")->pathFor("blog", ["id" => "5"]);
});

//agrupar rotas
$app->group('/v5', function () {
    $this->get('/postagens', function () {
        echo 'Lista postagens';
    });

    $this->get('/users[/{id}]', function () {
        echo 'Lista usuarios ';
    });

});

$app->run();