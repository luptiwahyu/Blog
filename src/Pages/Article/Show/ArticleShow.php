<?php 

$app->get('/article/:id', $authenticated(), function($id) use ($app) {

    $article = $app->article->find($id);

    $app->render('Pages/Article/Show/article-show.html', [
        'article' => $article
    ]);

})->name('article_show');