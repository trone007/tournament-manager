<?php

use DI\ContainerBuilder;

define('ROOT', str_replace("public/index.php", "", $_SERVER["SCRIPT_FILENAME"]));
define('VIEWS_ROOT', sprintf("%ssrc/Views/", ROOT));
define('CACHE_DIR', sprintf("%scache/", ROOT));
define('MAX_ON_PAGE', 3);

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/router.php";

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

$containerBuilder = new ContainerBuilder();

if (boolval($_ENV['DEV_MODE']) === false) {
    $containerBuilder->enableCompilation(__DIR__ . '/cache');
}

$containerBuilder->addDefinitions(__DIR__ . '/config.php');

return $containerBuilder->build();