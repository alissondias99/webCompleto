<?php
if (PHP_SAPI != 'cli') {
   exit('Rodar via CLI');
}

require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

// set up dependencies
$dependencies = require __DIR__ . '/src/dependencies.php';
$container = $dependencies($app);
$db = $container->get('db');

$schema = $db->schema();
$tabela = 'produtos';
$schema->dropIfExists($tabela);

//Criando a tabela produtos
$schema->create($tabela, function($table){
    $table->increments('id');
    $table->string('titulo', 100);
    $table->string('descricao');
    $table->decimal('preco', 11,2);
    $table->string('fabricante', 60);
    $table->timestamps();
});

$db->table($tabela)->insert([
    'titulo' => 'Smartphone',
    'descricao' => '8gb ram + 128 memória',
    'preco' => 899.00,
    'fabricante' => 'Motorola',
    'created_at' => '2019-10-22',
    'updated_At' => '2019-10-22'
]);
?>