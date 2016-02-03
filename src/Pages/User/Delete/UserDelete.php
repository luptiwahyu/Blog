<?php 

$app->delete('/delete/:id', $authenticated(), function($id) use ($app) {

    // $user = $app->auth;
    $app->user->destroy($id);

    $app->flash('success', 'Your account successfully deleted.');
    return $app->redirect($app->urlFor('register'));

})->name('user_delete');