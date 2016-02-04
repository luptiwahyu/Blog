<?php 

$app->get('/edit', $authenticated(), function() use ($app) {

    $months = months();

    $app->render('Pages/User/Edit/user-edit.html', array(
        'months' => $months,
        'user'   => $app->auth,
    ));

})->name('user_edit');


$app->put('/edit', $authenticated(), function() use ($app) {

    $request = $app->request;

    $name = filter_var($request->put('name'), FILTER_SANITIZE_STRING);

    $dayBirth   = $request->put('day_birth');
    $monthBirth = $request->put('month_birth');
    $yearBirth  = $request->put('year_birth');
    $dob        = $yearBirth . "-" . $monthBirth . "-" . $dayBirth;

    $dobCheck = checkdate(
        intval($monthBirth), 
        intval($dayBirth), 
        intval($yearBirth)
    );

    if (!$dobCheck) {
        $dob = null;
    }

    $v = $app->validation;

    $v->validate([
        'name'  => [$name, 'required|max(50)'],
    ]);

    if ($v->passes()) {
        $user = $app->auth;

        $user->update([
            'name' => $name,
            'dob'  => $dob,
        ]);

        $app->flash('success', 'Successfully modified profile.');
        return $app->redirect($app->urlFor('user_profile'));
    }

    $months = months();

    $app->render('Pages/User/Edit/user-edit.html', [
        'errors'  => $v->errors()->all(),
        'months'  => $months,
        'request' => $request,
    ]);

})->name('user_edit_post');