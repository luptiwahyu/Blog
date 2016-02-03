<?php 

$app->get('/article/new', $author(), function() use ($app) {
    $app->render('Pages/Article/New/article-new.html');
})->name('article_new');


$app->post('/article/new', $author(), function() use ($app) {

    $title   = $app->request->post('title');
    $content = $app->request->post('content');
    $publish = $app->request->post('publish');
    $save    = $app->request->post('save');

    $v = $app->validation;

    $v->validate([
        'title'   => [$title, 'required'],
        'content' => [$content, 'required'],
    ]);

    if ($v->passes()) {

        $user = $app->auth;
        $id   = uniqid();

        if (isset($publish)) {
            
            $app->article->create([
                'id'        => $id,
                'title'     => $title,
                'content'   => $content,
                'published' => true,
                'user_id'   => $user->id,
            ]);

            $app->flash('success', 'Successfully posted new article.');
            return $app->redirect('/home');

        } elseif (isset($save)) {
            
            $app->article->create([
                'id'        => $id,
                'title'     => $title,
                'content'   => $content,
                'published' => false,
                'user_id'   => $user->id,
            ]);

            $app->flash('success', 'Successfully created new article.');
            return $app->redirect('/home');

        }
    }

    $app->render('Pages/Article/New/article-new.html', [
        'errors'  => $v->errors()->all(),
        'request' => $app->request,
    ]);

})->name('article_new_post');