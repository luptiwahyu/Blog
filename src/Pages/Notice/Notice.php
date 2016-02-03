<?php 

$app->get('/notice', function() use ($app) {
    $app->render('Pages/Notice/notice.html');
})->name('notice');