<?php 

$app->get('/contact-us', function() use ($app) {

    $app->render('Pages/ContactUs/contact-us.html');

})->name('contact_us');


$app->post('/contact-us', function() use ($app) {

    $request = $app->request;

    $name    = filter_var($request->post('name'), FILTER_SANITIZE_STRING);
    $email   = filter_var($request->post('email'), FILTER_SANITIZE_EMAIL);
    $subject = filter_var($request->post('subject'), FILTER_SANITIZE_STRING);
    $message = filter_var($request->post('message'), FILTER_SANITIZE_STRING);

    $v = $app->validation;

    $v->validate([
        'Name'    => [$name, 'required'],
        'Email'   => [$email, 'required|email'],
        'Subject' => [$subject, 'required'],
        'Message' => [$message, 'required'],
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
        'request' => $request,
    ]);

})->name('contact_us_post');