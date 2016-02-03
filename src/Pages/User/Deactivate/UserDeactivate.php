<?php 

$app->put('/deactivate', $authenticated(), function() use ($app) {

    $user = $app->auth;

    $user->update([
        'active' => false
    ]);

    unset($_SESSION[$app->config->get('auth.session')]);

    if ($app->getCookie($app->config->get('auth.remember'))) {
        $app->auth->removeRememberCredentials();
        $app->deleteCookie($app->config->get('auth.remember'));
    }

    $app->flash('success', 'Your account successfully deactivated.');
    return $app->redirect($app->urlFor('notice'));

})->name('user_deactivate');


$app->put('/user/:id/deactivate', $authenticated(), function($id) use ($app) {

    $user = $app->user->find($id);

    $user->update([
        'active' => false
    ]);

    $app->flash('success', "Account {$user->email} successfully deactivated.");
    return $app->redirect($app->urlFor('user_show', ['id' => $user->id]));

})->name('user_deactivate_id');