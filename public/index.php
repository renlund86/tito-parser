<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../classes/TITO.php';

$app = AppFactory::create();

$app->post('/parse', function (Request $request, Response $response, $args) {
    
    $requestData = json_decode($request->getBody());
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
