<?php 

$app->delete('/article/delete/:id', $authenticated(), function($id) use ($app) {
    
    $article = $app->article->find($id);
    $article->delete();

    $user  = $app->auth;
    $title = ucwords($article->title);

    $app->flash('success', "Deleted article {$title}.");

    if ($user->role == 'admin') {
        return $app->redirect($app->urlFor('dashboard'));
    }

    return $app->redirect('/home');
    
})->name('article_delete');