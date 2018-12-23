<?php

require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/validators.php';
require_once 'functions/upload.php';
require_once 'functions/auth.php';

$config = require 'config.php';
$connection = connect($config['db']);
$categories = get_all_categories($connection);
$user = auth_user_by_session($connection);
$errors = null;
$sign_up = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sign_up = $_POST;
    $result = validate_sign_up_form($sign_up, $_FILES, $connection);

    if ($result === null) {
        $sign_up['image'] = upload_image($_FILES);
        $sign_up['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sign_up['$result'] = db_add_user($connection, $sign_up);

        if (!$sign_up['$result']) {
            die('При создании пользователя произошла ошибка');
        }

        header('Location: /login.php');
        exit;
    }
    $errors = $result;
}

$page_content = include_template(
    'sign-up.php',
    [
        'categories' => $categories,
        'sign_up' => $sign_up,
        'errors' => $errors,
    ]
);

$layout_content = include_template(
    'layout.php',
    [
        'title' => 'YetiCave - Регистрация',
        'user' => $user,
        'categories' => $categories,
        'content' => $page_content,
    ]
);

print($layout_content);
