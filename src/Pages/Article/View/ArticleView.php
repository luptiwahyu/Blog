<?php 

$app->get('/:titleSlug', function($titleSlug) use ($app) {

    $article = $app->article->with('user')
                            ->where('title_slug', $titleSlug)
                            ->first();

    if (!$article) {
        return $app->notFound();
    }

    $app->render('Pages/Article/View/article-view.html', [
        'article' => $article
    ]);

})->name('article_view');