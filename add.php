<?php

require_once 'data.php';
require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/validators.php';

$config = require 'config.php';
$connection = connect($config['db']);

$categories = get_all_categories($connection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_lot = $_POST;
    $required = ['product', 'category', 'description', 'opening_price', 'price_increment', 'closing_time'];
    $errors = [];

    foreach ($required as $key) {
        if (empty($new_lot[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    };

    if (isset($_FILES['jpg_img']['name']) && !empty ($_FILES['jpg_img']['name'])) {
        $file_name = $_FILES['jpg_img']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $file_name);
        if ($file_type !== "image/png" & $file_type !== "image/jpeg" & $file_type !== "image/jpg") {
            $errors['image'] = 'Загрузите изображение в формате JPG или PNG';
        } else {
            if ($file_type === "image/png") {
                $file_name = uniqid() . '.png';
            } elseif ($file_type === "image/jpg") {
                $file_name = uniqid() . '.jpg';
            } elseif ($file_type === "image/jpeg") {
                $file_name = uniqid() . '.jpeg';
            }
            $file_path = __DIR__ . '/img/';
            $file_url = '/img/' . $file_name;
            move_uploaded_file($_FILES['jpg_img']['tmp_name'], $file_path . $file_name);
        }
    } else {
        $errors['image'] = 'Вы не добавили изображение';
    };

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
