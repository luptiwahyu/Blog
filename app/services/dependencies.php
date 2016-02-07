<?php 

use Blog\Models\User;
use Blog\Models\Article;

use Blog\Helpers\Hash;
use Blog\Helpers\Validator;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Cocur\Slugify\Bridge\Twig\SlugifyExtension;
use Cocur\Slugify\Slugify;


$view = $app->view();

$view->parserOptions = array(
    'debug' => $app->config->get('twig.debug'),    
    'cache' => ROOT_PATH . '/app/cache/twig'
);

$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
    new Twig_Extensions_Extension_Date(),
    new SlugifyExtension(Slugify::create()),
);

$app->container->set('user', function() {
    return new User;
});

$app->container->set('article', function() {
    return new Article;
});

$app->container->singleton('mail', function() use ($app) {
    $mailer = new PHPMailer;

    $mailer->isSMTP();
    
    $mailer->Host       = $app->config->get('mail.host');
    $mailer->SMTPAuth   = $app->config->get('mail.smtp_auth');
    $mailer->SMTPSecure = $app->config->get('mail.smtp_secure');
    $mailer->Port       = $app->config->get('mail.port');
    $mailer->Username   = $app->config->get('mail.username');
    $mailer->Password   = $app->config->get('mail.password');

    $mailer->isHTML($app->config->get('mail.html'));

    return $mailer;
});

$app->container->singleton('randomlib', function() {
    $factory = new RandomLib\Factory;
    return $factory->getMediumStrengthGenerator();
});

$app->container->singleton('hash', function() use ($app) {
    return new Hash($app->config);
});

$app->container->singleton('slug', function() {
    return new Slugify;
});

$app->container->singleton('validation', function() use ($app) {
    return new Validator(new User, $app->hash, $app->auth);
});

$app->container->singleton('log', function() {
    $log = new Logger('log');
    $log->pushHandler(new StreamHandler(ROOT_PATH . '/app/logs/app.log', Logger::DEBUG));
    
    return $log;
});