<?php 

$app->add(new \Blog\Middleware\BeforeMiddleware);
$app->add(new \Blog\Middleware\CsrfMiddleware);