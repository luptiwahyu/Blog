<?php 

$app->get('/change-password', $authenticated(), function() use ($app) {
    $app->render('Pages/Password/Change/password-change.html');
})->name('password_change');


$app->post('/change-password', $authenticated(), function() use($app) {

    $passwordOld  = $app->request->post('password_old');
    $passwordNew  = $app->request->post('password_new');
    $passwordHash = $app->hash->passwordHash($passwordNew);

    $v = $app->validation;

    $v->validate([
        'old password' => [$passwordOld, 'required|matchesCurrentPassword'],
        'new password' => [$passwordNew, 'required|min(6)'],
    ]);  

    if ($v->passes()) {

        $user = $app->auth;
        
        $user->update([
            'password' => $passwordHash
        ]);

        $body = $app->view->render('Templates/Email/Password/changed.html');

        $app->mail->addAddress($user->email);
        $app->mail->Subject = 'You changed your password.';
        $app->mail->Body    = $body;
        $app->mail->send();
        
        $app->flash('success', 'You changed your password.');
        return $app->redirect($app->urlFor('user_change_password'));

    } 
    
    $app->render('Pages/Password/Change/password-change.html', [
        'errors' => $v->errors()->all()
    ]);

})->name('password_change_post');