<?php

use Api\Http\StatsController;
use Slim\App;

/* Schedules */
$app->group(
    '/stats',
    function (App $app) {
        /** @see StatsController::get() */
        $app->get('', StatsController::class . ':get');

        /** @see StatsController::set() */
        $app->put('/{code:[a-z]+}', StatsController::class . ':set');
    }
);
