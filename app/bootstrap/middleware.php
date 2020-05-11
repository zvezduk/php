<?php
// Application middleware

// CORS
use Slim\Http\Request;
use Slim\Http\Response;

$app->add(function(Request $request, Response $response, callable $next) use ($app) {
    $response = $next($request, $response);

    // Headers for CORS
    return $response->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
        ->withHeader(
            'Access-Control-Allow-Headers',
            'X-Requested-With, Content-Type, Accept, Origin, Authorization'
        );
});
