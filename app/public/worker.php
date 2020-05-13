<?php

// session_start();

require_once __DIR__ . '/../bootstrap/bootstrap.php';

/**
 * @var \Api\Worker $worker
 */
$worker = $container['worker'];

// Run app
$worker->run();
