<?php

function login($connection, $email, $password)
{
    $db_user = get_user_by_email($connection, $email);
    if (password_verify($password, $db_user['password'])) {
        return $db_user;
    }
    return null;
}

function auth_user_by_session($connection)
{
    if (isset($_SESSION['user']['id'])) {
        return get_user_by_id($connection, $_SESSION['user']['id']);
    };

    return null;
}
