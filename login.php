<?php

session_start();

require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/validators.php';
require_once 'functions/upload.php';
require_once 'functions/auth.php';

$config = require 'config.php';
$connection = connect($config['db']);
$categories = get_all_categories($connection);
$errors = null;
$login_form = null;
$user = auth_user_by_session($connection);

if ($user) {
    header('Location: /index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_form = $_POST;
    $errors = errors_validate_login_form($login_form, $connection);

    if ($errors === null) {
        if (login($connection, $login_form['email'], $login_form['password'])) {
            $_SESSION['user'] = login($connection, $login_form['email'], $login_form['password']);
            header('Location: /index.php');
            exit;
        }

        if (!login($connection, $login_form['email'], $login_form['password'])) {
            $errors['password'] = WRONG_PASSWORD;
        }
    }
}

$page_content = include_template(
    'login.php',
    [
        'categories' => $categories,
        'login' => $login_form,
        'errors' => $errors,
    ]
);

$layout_content = include_template(
    'layout.php',
    [
        'title' => 'YetiCave - Вход',
        'user' => $user,
        'categories' => $categories,
        'content' => $page_content,
    ]
);

print($layout_content);
