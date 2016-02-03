<?php 

$app->get('/:id', function($id) use ($app) {

    $article = $app->article->with('user')->find($id);

    $app->render('Pages/Article/View/article-view.html', [
        'article' => $article
    ]);

})->name('article_view');