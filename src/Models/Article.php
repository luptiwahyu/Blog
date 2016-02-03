<?php 

namespace Blog\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * 
 */
class Article extends Eloquent {
    
    protected $table = 'articles';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'content',
        'published',
        'created_at',
        'updated_at',
        'user_id',
    ];
    
    /**
     * Relationship for users
     * Get the user author that owns the article.
     */
    public function user() {
        return $this->belongsTo('Blog\Models\User');
    }
}