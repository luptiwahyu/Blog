<?php 

$app->get('/', function() use ($app) { 

    $articles = $app->article->with('user')
                ->where('published', true)
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();

    // for number pagination
    /*$articleAll = $app->article->with('user')
                    ->where('published', true)
                    ->orderBy('updated_at', 'desc')
                    ->get();

    $pages = intval(ceil(count($articleAll) / 5));*/

    $app->render('Pages/Home/home.html', [
        'articles' => $articles,
    ]);

})->name('home');