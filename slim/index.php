<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as Capsule;

require 'vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$container = $app->getContainer();
$container['db'] = function () {

    $capsule = new Capsule;
    $capsule->addConnection(array(

        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'slim',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',

    ));

    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

$app->get('/users', function (Request $request, Response $response) {

    $db = $this->get('db'); //->schema(); // schema é usado para comandos DDL
    /*$db->dropIfExists('usuarios');

    $db->create('usuarios', function($table){
        $table->increments('id'); // auto-increment
        $table->string('nome');
        $table->string('email');
        $table->timestamps(); // cria dois campos (created_at e updated_at) para controlar a criação ou alteração de registros
    });*/

    //Inserir
    /*$db->table('usuarios')->insert([
        'nome' => 'Alisson',
        'email' => 'ali@gmail.com'
    ]);*/

    /*$db->table('usuarios')
            -> where('id', 1)
            ->update([
                'nome' => 'Alisson Dias'
    ]);*/

    // Deletar
    $db->table('usuarios')
            -> where('id', 1)
            ->delete();
});

$app->run();