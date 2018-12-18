<?php

require_once 'data.php';
require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/validators.php';
require_once 'functions/server.php';

$config = require 'config.php';
$connection = connect($config['db']);

$categories = get_all_categories($connection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_lot = $_POST;
    $required = ['product', 'category', 'description', 'opening_price', 'price_increment', 'closing_time'];
    $errors = [];

    check_required_filled($new_lot, $required, $errors);

    if (isset($_FILES['jpg_img']['name']) && !empty ($_FILES['jpg_img']['name'])) {
        $file_name = $_FILES['jpg_img']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $file_name);

        if (validate_image($errors, $file_type)) {
            $file_url = upload_image($file_name, $file_type);
        }
    } else {
        $errors['image'] = 'Вы не добавили изображение';
    }

    if (!validate_input_number($new_lot['opening_price'])) {
        $errors['opening_price'] = 'Введите положительное число';
    }

    if (!validate_input_number($new_lot['price_increment'])) {
        $errors['price_increment'] = 'Введите положительное число';
    }

    if (!empty($new_lot['closing_time'])) {
        if (!validate_input_date($new_lot['closing_time'])) {
            $errors['closing_time'] = 'Введите дату (не ранее завтрашнего дня)';
        }
    }

    if (count($errors)) {
        $errors['hints'] = 'Пожалуйста, исправьте ошибки в форме.';
        $page_content = include_template('add-lot.php', [
            'new_lot' => $new_lot,
            'errors' => $errors,
            'categories' => $categories,
        ]);
    } else {
        $new_lot['image'] = $file_url;
        $new_lot['category'] = get_category_id($connection, $new_lot['category']);
        $result = db_add_lot($connection, $new_lot);

        if (!$result) {
            $error = mysqli_connect_error();
            die($error);
        }

        $new_lot = mysqli_insert_id($connection);
        header('Location: lot.php?id=' . $new_lot);
        exit;
    }

} else {
    $page_content = include_template(
    'add-lot.php',
    ['categories' => $categories,
    ]);
}

$layout_content = include_template(
    'layout.php',
    ['title' => 'YetiCave - Добавить лот',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'content' => $page_content,
    ]
);

print($layout_content);
