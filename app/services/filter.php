<?php 

$authenticationCheck = function($required) use ($app) {
    return function() use ($required, $app) {
        if ( (!$app->auth && $required) || ($app->auth && !$required) ) {
            $app->notFound();
        }
    };
};

$authenticated = function() use ($authenticationCheck) {
    return $authenticationCheck(true);
};

$guest = function() use ($authenticationCheck) {
    return $authenticationCheck(false);
};

$authForRole = function($role) use ($app) {
    return function() use ($role, $app) {
        if (!$app->auth || $app->auth->role != $role ) {
            $app->notFound();
        }
    };
};

$author = function() use ($authForRole) {
    return $authForRole('author');
};

$admin = function() use ($authForRole) {
    return $authForRole('admin');
};