<?php 

namespace Blog\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * 
 */
class Comment extends Eloquent 
{    
    protected $table = 'comments';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_name',
        'body',
        'created_at',
        'updated_at',
        'article_id',
    ];
    
    /**
     * Relationship for users
     * Get the user author that owns the article.
     */
    public function article() 
    {
        return $this->belongsTo('Blog\Models\Comment');
    }
}