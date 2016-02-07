<?php 

$app->get('/article/new', $author(), function() use ($app) {
    $app->render('Pages/Article/New/article-new.html');
})->name('article_new');


$app->post('/article/new', $author(), function() use ($app) {

    $request = $app->request;

    $title   = filter_var($request->post('title'), FILTER_SANITIZE_STRING);
    $content = $request->post('content');
    $publish = $request->post('publish');
    $save    = $request->post('save');

    $v = $app->validation;

    $v->addRuleMessage('uniqueTitle', '{field} is already exist. Please change the title.');

    $v->addRule('uniqueTitle', function($value, $input, $args) use ($app) {
        $article = $app->article->where('title_slug', $app->slug->slugify($value));
        return ! (bool) $article->exists();
    });

    $v->validate([
        'Title'   => [$title, 'required|uniqueTitle'],
        'Content' => [$content, 'required'],
    ]);

    if ($v->passes()) {

        $user = $app->auth;
        $id   = uniqid();
        $slug = $app->slug;

        if (isset($publish)) {

            $app->article->create([
                'id'           => $id,
                'title'        => $title,
                'title_slug'   => $slug->slugify($title),
                'content'      => $content,
                'published_at' => date("Y-m-d H:i:s"),
                'user_id'      => $user->id,
            ]);

            $app->flash('success', 'Successfully posted new article.');
            return $app->redirect('/home');

        } elseif (isset($save)) {
            
            $app->article->create([
                'id'         => $id,
                'title'      => $title,
                'title_slug' => $slug->slugify($title),
                'content'    => $content,
                'user_id'    => $user->id,
            ]);

            $app->flash('success', 'Successfully created new article.');
            return $app->redirect('/home');

        }
    }

    $app->render('Pages/Article/New/article-new.html', [
        'errors'  => $v->errors()->all(),
        'request' => $request,
    ]);

})->name('article_new_post');