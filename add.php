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
$new_lot = null;

if (!$user) {
    http_response_code(403);
    $error = http_response_code() . ' (Доступ неавторизированным пользователям запрещён)';
    error_template($error, $user, $categories);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_lot = $_POST;
    $result = validate_lot_form($new_lot, $_FILES);

    if ($result === null) {
        $new_lot['image'] = 'img/' . upload_image($_FILES);
        $result = db_add_lot($connection, $new_lot);

        $new_lot = mysqli_insert_id($connection);
        if (!$new_lot) {
            die('При добавлении лота произошла ошибка');
        }

        header('Location: lot.php?id=' . $new_lot);
        exit;
    }
    $errors = $result;
}

$page_content = include_template(
    'add-lot.php',
    [
        'categories' => $categories,
        'new_lot' => $new_lot,
        'errors' => $errors,
    ]
);

$layout_content = include_template(
    'layout.php',
    [
        'title' => 'YetiCave - Добавить лот',
        'user' => $user,
        'categories' => $categories,
        'content' => $page_content,
    ]
);

print($layout_content);
