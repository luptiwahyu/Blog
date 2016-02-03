<?php 

$app->get('/contact-us', function() use ($app) {

    $app->render('Pages/ContactUs/contact-us.html');

})->name('contact_us');


$app->post('/contact-us', function() use ($app) {

    $name    = $app->request->post('name');
    $email   = $app->request->post('email');
    $subject = $app->request->post('subject');
    $message = $app->request->post('message');

    $v = $app->validation;

    $v->validate([
        'name'    => [$name, 'required'],
        'email'   => [$email, 'required|email'],
        'subject' => [$subject, 'required'],
        'message' => [$message, 'required'],
    ]);

    if ($v->passes()) {

        $mail = $app->mail;

        $mail->setFrom($email, ucwords($name));
        $mail->addAddress($app->config->get('mail.username'));

        $mail->Subject = ucwords($subject);
        $mail->Body    = $message;

        if (!$mail->send()) {
            $app->flash('error', 'Message could not be sent. Please try again.');
            return $app->redirect($app->urlFor('notice'));
        }

        $app->flash('success', 'Your message has been sent.');
        return $app->redirect($app->urlFor('notice'));
    }

    $app->render('Pages/ContactUs/contact-us.html', [
        'errors'  => $v->errors()->all(),
        'request' => $app->request,
    ]);

})->name('contact_us_post');