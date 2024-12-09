<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

require __DIR__ . '/../../vendor/autoload.php';

$sfContainer = new ContainerBuilder();
$loader = new YamlFileLoader($sfContainer, new FileLocator(__DIR__.'/../../config'));
$loader->load('services.yaml');

AppFactory::setContainer($sfContainer);
$app = AppFactory::create();

$applier = $app->getContainer()->get('OrderDiscountsApplier');
var_dump($applier);die(1);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('{"mensaje": "Hola Mundo!"}');
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});


$app->run();
