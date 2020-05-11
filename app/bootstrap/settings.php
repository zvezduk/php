<?php

return [
    'settings' => [
        'displayErrorDetails'               => IS_DEV, // set to false in production
        'addContentLengthHeader'            => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => false, // This Slim setting is required for the middleware to work

        // Monolog settings
        'logger'                            => [
            'name'  => getenv('APP_NAME'),
            'path'  => 'php://stdout',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
