<?php 

$app->get('/:titleSlug', function($titleSlug) use ($app) {

    $article = $app->article->with('user')
                            ->where('title_slug', $titleSlug)
                            ->first();

    if (!$article) {
        return $app->notFound();
    }

    $comments = $app->comment->where('article_id', $article->id)
                ->orderBy('created_at', 'desc')
                ->get();

    $app->render('Pages/Article/View/article-view.html', [
        'article'  => $article,
        'comments' => $comments,
    ]);

})->name('article_view');


$app->post('/:titleSlug', function($titleSlug) use ($app) {

    $article = $app->article->with('user')
                            ->where('title_slug', $titleSlug)
                            ->first();
                            
    $comments = $app->comment->where('article_id', $article->id)
                ->orderBy('created_at', 'desc')
                ->get();

    $comment = filter_var($app->request->post('comment'), FILTER_SANITIZE_STRING);

    $v = $app->validation;

    $v->validate([
        'Comment' => [$comment, 'required']
    ]);

    if ($v->passes()) {
        
        $id = uniqid();

        $app->comment->create([
            'id'         => $id,
            'user_name'  => 'anonymous',
            'body'       => $comment,
            'article_id' => $article->id,
        ]);

        $app->redirect($app->urlFor('article_view', [
            'titleSlug' => $titleSlug
        ]));
    }

    $app->render('Pages/Article/View/article-view.html', [
        'article'  => $article,
        'comments' => $comments,
        'errors'   => $v->errors(),
    ]);

})->name('article_comment_post');