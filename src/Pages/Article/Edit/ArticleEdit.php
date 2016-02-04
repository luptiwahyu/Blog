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

    $v->validate([
        'title'   => [$title, 'required'],
        'content' => [$content, 'required'],
    ]);

    $article = $app->article->find($id);
    
    if ($v->passes()) {
        
        if (isset($publish)) {
            
            $article->update([
                'title'     => $title,
                'content'   => $content,
                'published' => true,
            ]);

            $app->flash('success', 'Successfully modified and posted new article.');
            return $app->redirect('/home');

        } elseif (isset($save)) {
            
            $article->update([
                'title'     => $title,
                'content'   => $content,
                'published' => false,
            ]);

            $app->flash('success', 'Successfully modified new article.');
            return $app->redirect('/home');

        }
    }
    
    $app->render('Pages/Article/Edit/article-edit.html', [
        'errors'  => $v->errors()->all(),
        'request' => $request,
    ]);

})->name('article_edit_post');