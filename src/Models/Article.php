<?php 

namespace Blog\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * 
 */
class Article extends Eloquent 
{
    protected $table = 'articles';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'title_slug',
        'content',
        'published_at',
        'created_at',
        'updated_at',
        'user_id',
    ];
    
    /**
     * Relationship for users
     * Get the user author that owns the article.
     */
    public function user() 
    {
        return $this->belongsTo('Blog\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('Blog\Models\Comment');
    }
}