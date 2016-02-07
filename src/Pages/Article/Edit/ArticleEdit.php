<?php 

$app->get('/article/:id/edit', $author(), function($id) use ($app) {
    
    $article = $app->article->find($id);

    $app->render('Pages/Article/Edit/article-edit.html', [
        'article' => $article
    ]);

})->name('article_edit');


$app->put('/article/:id/edit', $author(), function($id) use ($app) {

    $request = $app->request;

    $title   = filter_var($request->put('title'), FILTER_SANITIZE_STRING);
    $content = $request->put('content');
    $publish = $request->put('publish');
    $save    = $request->put('save');

    $v = $app->validation;

    $v->addRuleMessage('uniqueTitle', '{field} is already exist. Please change the title.');

    $v->addRule('uniqueTitle', function($value, $input, $args) use ($id, $app) {
        $article = $app->article->where('title_slug', $app->slug->slugify($value))
                                ->first();
        return $article->id == $id;
    });

    $v->validate([
        'Title'   => [$title, 'required|uniqueTitle'],
        'Content' => [$content, 'required'],
    ]);

    $article = $app->article->find($id);
    
    if ($v->passes()) {
        
        if (isset($publish)) {

            $article->title      = $title;
            $article->title_slug = $app->slug->slugify($title);
            $article->content    = $content;

            if (!$article->published_at) {
                $article->published_at = date("Y-m-d H:i:s");
            }

            $article->save();
            
            $app->flash('success', 'Successfully modified article.');
            return $app->redirect($app->urlFor('article_show', [
                'id' => $id
            ]));

        } elseif (isset($save)) {
            
            $article->update([
                'title'        => $title,
                'title_slug'   => $app->slug->slugify($title),
                'content'      => $content,
            ]);

            $app->flash('success', 'Successfully modified article.');
            return $app->redirect($app->urlFor('article_show', [
                'id' => $id
            ]));

        }
    }
    
    $app->render('Pages/Article/Edit/article-edit.html', [
        'errors'  => $v->errors()->all(),
        'request' => $request,
        'article' => $app->article->find($id),
    ]);

})->name('article_edit_post');