<?php

require_once 'data.php';
require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/validators.php';
require_once 'functions/upload.php';

$config = require 'config.php';
$connection = connect($config['db']);
$categories = get_all_categories($connection);
$errors = null;
$login = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST;
    $result = validate_login_form($login, $connection);

    if ($result === true) {
        $login['$result'] = get_user_by_email($connection, $login['email']);

        if (!$login['$result']) {
            die('При попытке авторизоваться произошла ошибка');
        }

        $_SESSION['user'] = $login['$result'];

        header('Location: /index.php');
        exit;
    }
    $errors = $result;
}

if (isset($_SESSION['user'])) {
    $is_auth = $_SESSION['user'];

    $page_content = include_template(
        'index.php',
        [
            'categories' => $categories,
            'lots' => $lots
        ]
    );
}
else {
    $page_content = include_template(
        'login.php',
        [
            'categories' => $categories,
            'login' => $login,
            'errors' => $errors,
        ]
    );
}

$layout_content = include_template(
    'layout.php',
    [
        'title' => 'YetiCave - Вход',
        'is_auth' => $is_auth,
        'categories' => $categories,
        'content' => $page_content,
    ]
);

print($layout_content);
