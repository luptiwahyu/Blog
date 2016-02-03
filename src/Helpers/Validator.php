<?php 

namespace Blog\Helpers;

use Violin\Violin;
use Blog\Helpers\Hash;
use Blog\Models\User;

/**
 * 
 */
class Validator extends Violin
{
    protected $user;
    protected $hash;
    protected $auth;

    public function __construct(User $user, Hash $hash, $auth = null)
    {
        $this->user = $user;
        $this->hash = $hash;
        $this->auth = $auth;

        $this->addRuleMessages([
            'uniqueEmail'            => '{field} is already in use.',
            'uniqueUsername'         => '{field} is already in use.',
            'activation'             => 'Please check the email to activate your account.',
            'matchesCurrentPassword' => '{field} does not match your current password.',
        ]);
    }

    public function validate_uniqueEmail($value, $input, $args)
    {
        $user = $this->user->where('email', $value);

        return ! (bool) $user->exists();
    }

    public function validate_uniqueUsername($value, $input, $args)
    {
        $user = $this->user->where('username', $value);

        return ! (bool) $user->exists();
    }

    public function validate_matchesCurrentPassword($value, $input, $args)
    {
        if ($this->auth && $this->hash->passwordCheck($value, $this->auth->password)) {
            return true;
        }

        return false;
    }

    public function validate_activation($value, $input, $args)
    {
        $user = $this->user->where('email', $value)->first();

        if (!$user->active && $user->active_hash) {
            return false;
        }

        return true;
    }
}