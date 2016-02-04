<?php 


$app->get('/forgot-password', $guest(), function() use ($app) {
    $app->render('Pages/Password/Forgot/password-forgot.html');
})->name('password_forgot');


$app->post('/forgot-password', $guest(), function() use ($app) {

    $email = $app->request->post('email');

    $v = $app->validation;

    $v->validate([
        'email' => [$email, 'required|email']
    ]);

    if ($v->passes()) {
        $user = $app->user->where('email', $email)->first();

        if (!$user) {
            $app->flash('error', 'Could not find that user email.');
            return $app->redirect($app->urlFor('password_forgot'));
        } else {
            $identifier = $app->randomlib->generateString(128);

            $user->update([
                'forgot_hash' => $app->hash->hash($identifier)
            ]);

            $body = $app->view->render('Templates/Email/Password/forgot.html', [
                'user'       => $user,
                'identifier' => $identifier,
            ]);

            $app->mail->addAddress($user->email);
            $app->mail->Subject = 'Recover your password.';
            $app->mail->Body    = $body;
            $app->mail->send();

            $app->flash('success', 'We have emailed you instructions to reset your password.');
            return $app->redirect($app->urlFor('notice'));
        }
    }

    $app->render('Pages/Password/Forgot/password-forgot.html', [
        'errors'  => $v->errors()->all(),
        'request' => $app->request,
    ]);

})->name('password_forgot_post');