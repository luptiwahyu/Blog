<?php 

$app->get('/home', $author(), function() use ($app) {
        
    $user = $app->auth;

    $articles = $app->article->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->get();

    $app->render('Pages/Dashboard/Author/dashboard-author.html', [
        'articles' => $articles,
    ]);

})->name('user_home');