<?php 

namespace Blog\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * 
 */
class User extends Eloquent {
	
    protected $table = 'users';
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'dob',
        'role',
        'active',
        'active_hash',
        'remember_identifier',
        'remember_token',
        'forgot_hash',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationship for article
     * Get the articles for the user author.
     */
    public function articles() {
        return $this->hasMany('Blog\Models\Article');
    }

    public function activateAccount()
    {
        $this->update([
            'active'      => true,
            'active_hash' => null,
        ]);
    }

    public function getAvatarUrl($options = [])
    {
        $size = isset($options['size']) ? $options['size'] : 45;

        return 'http://www.gravatar.com/avatar/' . md5($this->email) . '?s=' . $size . '&d=mm';
    }

    public function updateRememberCredentials($identifier, $token)
    {
        $this->update([
            'remember_identifier' => $identifier,
            'remember_token'      => $token,
        ]);
    }

    public function removeRememberCredentials()
    {
        $this->updateRememberCredentials(null, null);
    }
}