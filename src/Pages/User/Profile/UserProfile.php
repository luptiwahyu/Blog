<?php 


$app->get('/profile', $authenticated(), function() use ($app) {

    $app->render('Pages/User/Profile/user-profile.html', array(
        'user' => $app->auth
    ));
    
})->name('user_profile');