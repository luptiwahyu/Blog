<?php 

$app->get('/page/:number', function($number) use ($app) {

    $articles = $app->article->with('user')
                ->where('published', true)
                ->orderBy('updated_at', 'desc')
                ->skip(5 * ($number - 1))
                ->take(5)
                ->get();

    $articleAll = $app->article->with('user')
            ->where('published', true)
            ->orderBy('updated_at', 'desc')
            ->get();

    $pages = intval(ceil(count($articleAll) / 5));

    $app->render('Pages/Article/Page/page.html', [
        'articles' => $articles,
        'pages'    => $pages,
        'number'   => $number,
    ]);

})->name('article_page');