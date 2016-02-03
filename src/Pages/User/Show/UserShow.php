<?php 

$app->get('/user/:id', $admin(), function($id) use ($app) {

    $user = $app->user->find($id);

    $app->render('Pages/User/Show/user-show.html', array(
        'user' => $user
    ));

})->name('user_show');