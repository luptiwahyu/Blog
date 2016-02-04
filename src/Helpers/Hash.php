<?php 

namespace Blog\Helpers;

/**
 * 
 */
class Hash
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function passwordHash($password)
    {
        return password_hash(
            $password, 
            $this->config->get('security.password.algo'), 
            ['cost' => $this->config->get('security.password.cost')]
        );
    }

    public function passwordCheck($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function hash($input)
    {
        return hash($this->config->get('security.hash.algo'), $input);
    }

    public function hashCheck($known_string, $user_string)
    {
        return hash_equals($known_string, $user_string);
    }
}