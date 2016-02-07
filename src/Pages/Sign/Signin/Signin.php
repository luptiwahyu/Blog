<?php 


$app->get('/login', $guest(), function() use ($app) {
    $app->render('Pages/Sign/Signin/signin.html');
})->name('login');


$app->post('/login', $guest(), function () use ($app) {

    $email    = $app->request->post('email');
    $password = $app->request->post('password');
    $remember = $app->request->post('remember');

    $v = $app->validation;

    $v->validate([
        'Email'    => [$email, 'required|email'],
        'Password' => [$password, 'required'],
    ]);

    if ($v->passes()) {

        $user = $app->user->where('email', $email)
                ->where('active', true)
                ->first();
        
        if ($user && $app->hash->passwordCheck($password, $user->password)) {
            
            $_SESSION[$app->config->get('auth.session')] = $user->id;

            if ($remember === 'on') {
                $rememberIdentifier = $app->randomlib->generateString(128);
                $rememberToken      = $app->randomlib->generateString(128);

                $user->updateRememberCredentials(
                    $rememberIdentifier,
                    $app->hash->hash($rememberToken)
                );

                $app->setCookie(
                    $app->config->get('auth.remember'),
                    "{$rememberIdentifier}___{$rememberToken}",
                    '2 weeks'
                );
            }

            if ($user->role == 'admin') {
                return $app->redirect($app->urlFor('dashboard'));
            }
            
            return $app->redirect($app->urlFor('user_home'));

        } else {

            $app->flash('error', 'Incorrect email address or password.');
            return $app->redirect('/login');
        
        }
    }

    $app->render('Pages/Sign/Signin/signin.html', array(
        'errors'  => $v->errors()->all(),
        'request' => $app->request,
    ));

})->name('login_post');