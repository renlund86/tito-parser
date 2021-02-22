<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../classes/TITO.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$app = AppFactory::create();

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', $_SERVER['CORS_ALLOWED_DOMAIN'])
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->post('/parse', function (Request $request, Response $response, $args) {
    
    $requestData = json_decode($request->getBody());
    
    if(!file_exists(__DIR__ . '/../'.$requestData->fileName)) {
        throw new Exception("File not found!");
    }
    
    $fn = fopen(__DIR__ . '/../'.$requestData->fileName, "r");

    $file_contents = array();

    while (!feof($fn)) {
        $result = fgets($fn);
        $file_contents[] = utf8_encode($result);
    }

    fclose($fn);
    $tito = new TITO($file_contents);
    $payload = $tito->categorize();
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$errorMiddleware = $app->addErrorMiddleware(false, false, false);
$app->run();
