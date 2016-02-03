<?php 

$app->get('/dashboard', $admin(), function() use ($app) {
    
    $users = $app->user->where('role', 'author')->get();

    $articles = $app->article->with('user')
                ->where('published', true)
                ->get();

    $app->render('Pages/Dashboard/Admin/dashboard-admin.html', array(
        'users'    => $users,
        'articles' => $articles,
    ));

})->name('dashboard');