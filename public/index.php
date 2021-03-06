<?php
require(__DIR__ . '/../vendor/autoload.php');

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Preflight
if (isset($_SERVER['HTTP_ORIGIN'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        echo '1';
        exit;
    }
}

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        'CartApp\Core' => APP_PATH . '/Core/',
        'CartApp\User' => APP_PATH . '/User/',
        'CartApp\Offer' => APP_PATH . '/Offer/',
        'CartApp\Order' => APP_PATH . '/Order/',
    ]
);

$loader->register();

$container = (new \CartApp\Core\Application\Container())->getDefault();

$application = new \CartApp\Core\Application\Application($container);
$application->useImplicitView(false);
$application->registerRoutes();

$application->handle($_SERVER["REQUEST_URI"]);