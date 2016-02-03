<?php 

use Noodlehaus\Config;

require ROOT_PATH . '/vendor/autoload.php';

session_start();
session_cache_limiter(false);

ini_set('display_errors', 'On');
date_default_timezone_set('Asia/Jakarta');

// Instantiate the app
$app = new \Slim\Slim(array(
    'mode'           => file_get_contents(ROOT_PATH . '/mode.php'),
    'debug'          => true,
    'templates.path' => ROOT_PATH . '/src',
    'view'           => new \Slim\Views\Twig(),
));

// Configuration application mode
$app->configureMode($app->config('mode'), function() use ($app) {
	$app->config = Config::load(ROOT_PATH . "/app/config/{$app->mode}.php");
});

// Initial authentication
$app->auth = false;

// Set up dependencies
require ROOT_PATH . '/app/services/dependencies.php';
// Register middleware
require ROOT_PATH . '/app/services/middleware.php';
// Set up database
require ROOT_PATH . '/app/services/database.php';
// Filter routes
require ROOT_PATH . '/app/services/filter.php';
// Helpers class and function
require ROOT_PATH . '/src/Helpers/Helper.php';
// Register routes
require ROOT_PATH . '/app/routes.php';