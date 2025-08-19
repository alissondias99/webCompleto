<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Produto;

//Rota para produtos

//ORM -> Object relational mapper (Mapeador de objeto relacional) (Illuminate) 
$app->group('/api/v1', function () {

    //Listar
    $this->get('/produtos/lista', function ($request, $response) {
        $produtos = Produto::get();
        return $response->withJson($produtos);
    });

    //Adicionar
    $this->get('/produtos/adiciona', function ($request, $response) {
        $dados = $request->getParsedBody();
        $produto = Produto::create($dados);
        return $response->withJson($produto);
    });

    //Recupera produto pelo id
    $this->get('/produtos/lista/{id}', function ($request, $response, $args) {
        $produto = Produto::findOrFail($args['id']);
        return $response->withJson($produto);
    });

    //Atualiza produto pelo id
    $this->put('/produtos/atualiza/{id}', function ($request, $response, $args) {

        $dados = $request->getParsedBody();
        $produto = Produto::findOrFail($args['id']);
        $produto->update($dados);
        return $response->withJson($produto);

    });

    //Remove produto pelo id
    $this->get('/produtos/remove/{id}', function ($request, $response, $args) {
        $produto = Produto::findOrFail($args['id']);
        $produto->delete();
        return $response->withJson($produto);
    });
});

// Teste e validações foram feitos pelo software postman
