<?php

use Api\Http\ScheduleController;
use Slim\App;

/* Schedules */
$app->group(
    '/schedules',
    function (App $app) {
        /** @see ScheduleController::uploadFile */
        $app->post('/file', ScheduleController::class . ':uploadFile');
    }
);
