<?php

use Core\SessionHelper;

$container = require_once __DIR__ . '/../config/bootstrap.php';
SessionHelper::start();

$dispatcher = new \Http\Dispatcher($container);

$dispatcher->dispatch();



