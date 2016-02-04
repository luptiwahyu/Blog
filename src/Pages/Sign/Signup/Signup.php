<?php 


$app->get('/register', $guest(), function() use ($app) {
    $app->render('Pages/Sign/Signup/signup.html');
})->name('register');


$app->post('/register', $guest(), function () use ($app) {

    $request = $app->request;

    $name  = filter_var($request->post('name'), FILTER_SANITIZE_STRING);
    $email = filter_var($request->post('email'), FILTER_SANITIZE_EMAIL);
    
    $password     = $request->post('password');
    $passwordHash = $app->hash->passwordHash($password);
    
    $v = $app->validation;

    $v->validate([
        'name'     => [$name, 'required'],
        'email'    => [$email, 'required|email|uniqueEmail'],
        'password' => [$password, 'required|min(6)'],
    ]);

    if ($v->passes()) {

        $id         = uniqid();
        $identifier = $app->randomlib->generateString(128);

        $user = $app->user;

        $user->id          = $id;
        $user->name        = $name;
        $user->email       = $email;
        $user->password    = $passwordHash;
        $user->role        = 'author';
        $user->active      = false;
        $user->active_hash = $app->hash->hash($identifier);

        $body = $app->view->render('Templates/Email/registered.html', [
            'user'       => $user,
            'identifier' => $identifier,
        ]);

        $app->mail->addAddress($user->email);
        $app->mail->Subject = 'Thanks for registering.';
        $app->mail->Body    = $body;

        if (!$app->mail->send()) {
            $app->flash('error', 'Registration failed. Please try again.');
            return $app->redirect($app->urlFor('notice'));
        } else {
            $user->save();

            $app->flash('success', 'Thank you for registering. Check the email to activated your account.');
            return $app->redirect($app->urlFor('notice'));
        }
        
    }

    $app->render('Pages/Sign/Signup/signup.html', array(
        'errors'  => $v->errors()->all(),
        'request' => $request,
    ));

})->name('register_post');


$app->get('/activate', function() use ($app) {

    $email      = $app->request->get('email');
    $identifier = $app->request->get('identifier');

    $hashedIdentifier = $app->hash->hash($identifier);

    $user = $app->user->where('email', $email)
                ->where('active', false)
                ->first();

    if (!$user || !$app->hash->hashCheck($user->active_hash, $hashedIdentifier)) {
        $app->flash('error', 'There was a problem activating your account.');
        return $app->redirect('/login');
    } else {
        $user->activateAccount();

        $app->flash('success', 'Your account has been activated and you can log in.');
        return $app->redirect($app->urlFor('notice'));
    }
    
})->name('activate');