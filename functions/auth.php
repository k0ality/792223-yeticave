<?php

/**
 * Authentication. Verify user by email & password.
 *
 * @param $connection
 * @param $email
 * @param $password
 * @return array|null
 */
function login($connection, $email, $password)
{
    $db_user = get_user_by_email($connection, $email);
    if (password_verify($password, $db_user['password'])) {
        return $db_user;
    }
    return null;
}

/**
 * Authorization. Create a session for the user after the user logs in.
 *
 * @param $connection
 * @return array|null
 */
function auth_user_by_session($connection)
{
    if (isset($_SESSION['user']['id'])) {
        return get_user_by_id($connection, $_SESSION['user']['id']);
    };

    return null;
}
