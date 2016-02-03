<?php 


$app->get('/reset-password', $guest(), function() use ($app) {

    $email      = $app->request->get('email');
    $identifier = $app->request->get('identifier');

    $hashedIdentifier = $app->hash->hash($identifier);

    $user = $app->user->where('email', $email)->first();

    if (!$user) {
        return $app->redirect('/');
    }

    if (!$user->forgot_hash) {
        return $app->redirect('/');
    }

    if (!$app->hash->hashCheck($user->forgot_hash, $hashedIdentifier)) {
        return $app->redirect('/');
    }

    $app->render('Pages/Password/Reset/password-reset.html', [
        'email'      => $user->email,
        'identifier' => $identifier,
    ]);

})->name('password_reset');

$app->put('/reset-password', $guest(), function() use ($app) {

    $email      = $app->request->get('email');
    $identifier = $app->request->get('identifier');

    $hashedIdentifier = $app->hash->hash($identifier);

    $password        = $app->request->post('password');
    $passwordConfirm = $app->request->post('password_confirm');

    $passwordHash = $app->hash->passwordHash($password);

    $user = $app->user->where('email', $email)->first();

    if (!$user) {
        return $app->redirect('/');
    }

    if (!$user->forgot_hash) {
        return $app->redirect('/');
    }

    if (!$app->hash->hashCheck($user->forgot_hash, $hashedIdentifier)) {
        return $app->redirect('/');
    }

    $v = $app->validation;

    $v->validate([
        'password'         => [$password, 'required|min(6)'],
        'confirm password' => [$passwordConfirm, 'required|matches(password)'],
    ]);

    if ($v->passes()) {
        $user->update([
            'password'    => $passwordHash,
            'forgot_hash' => null,
        ]);

        $app->flash('success', 'Your password has been reset and you can now sign in.');
        return $app->redirect($app->urlFor('notice'));
    }

    $app->render('Pages/Password/Reset/password-reset.html', [
        'errors'     => $v->errors()->all(),
        'email'      => $user->email,
        'identifier' => $identifier,
    ]);

})->name('password_reset_post');