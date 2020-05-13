<?php
// DIC configuration

use Api\Http\StatsController;
use Api\Model\StatsModel;
use Slim\Container;

$container = $app->getContainer();

$container['redis'] = function (Container $c): Redis {
    $settings = $c['settings']['redis'];

    $redis = new Redis();
    $redis->connect(
        $settings['host']
    );

    return $redis;
};

$container['worker'] = function (Container $c): \Api\Worker {
    $redis = $c['redis'];
    $statsModel = new StatsModel($redis);

    $settings = $c['settings']['redis'];

    $redis = new Redis();
    $redis->connect(
        $settings['host']
    );

    return new \Api\Worker($redis, $statsModel);
};

$container[StatsController::class] = function (Container $c): StatsController {
    $redis = $c['redis'];
    $worker = $c['worker'];

    $statsModel = new StatsModel($redis);

    return new StatsController($statsModel, $worker);
};