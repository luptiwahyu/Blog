<?php 

$app->get('/', function() use ($app) { 

    $articles = $app->article->with('user')
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->take(5)
                ->get();

    $articleAll = $app->article->with('user')
                    ->whereNotNull('published_at')
                    ->orderBy('published_at', 'desc')
                    ->get();

    // for number pagination
    // $pages = intval(ceil(count($articleAll) / 5));

    $app->render('Pages/Home/home.html', [
        'articles'   => $articles,
        'articleAll' => $articleAll,
    ]);

})->name('home');