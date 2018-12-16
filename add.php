<?php

require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';

$is_auth = rand(0, 1);
$user_name = 'Снежок';
$user_avatar = 'img/user.jpg';

$config = require 'config.php';
$connection = connect($config['db']);

$categories = getAllCategories($connection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_lot = $_POST;
    $required = ['product', 'category', 'description', 'opening_price', 'price_increment', 'closing_time'];
    $dictionary = [
        'product' => 'Наименование',
        'category' => 'Категория',
        'description' => 'Описание',
        'opening_price' => 'Начальная цена',
        'price_increment' => 'Шаг ставки',
        'closing_time' => "Дата окончания торгов",
        'image' => 'Изображение',
        ];
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

    if ($new_lot['opening_price'] <= 0 || $new_lot['opening_price'] !== (string)(int)$new_lot['opening_price'])  {
        $errors['opening_price'] = 'Цена не может быть отрицательной';
    }

    if ($new_lot['price_increment'] <= 0 || $new_lot['price_increment'] !== (string)(int)$new_lot['price_increment'])  {
        $errors['price_increment'] = 'Шаг ставки должен быть положительным числом';
    }

    if ($new_lot['closing_time'] !== date("Y-m-d" , strtotime($new_lot['closing_time']))) {
        $new_lot['closing_time'] = date("Y-m-d" , strtotime($new_lot['closing_time']));
    }

    if (strtotime($new_lot['closing_time']) < strtotime('tomorrow')) {
        $errors['closing_time'] = 'Введите дату окончания торгов (не ранее завтрашнего дня)';
    }

    if (count($errors)) {
        $errors['hints'] = 'Пожалуйста, исправьте ошибки в форме.';
        $page_content = include_template('add-lot.php', [
            'new_lot' => $new_lot,
            'errors' => $errors,
            'dictionary' => $dictionary,
            'categories' => $categories,
        ]);
    } else {
        $new_lot['image'] = $file_url;

        $category_name = $new_lot['category'];
        $category_id = getCategoryID($connection, $category_name);

        $add_lot_query = 'INSERT INTO
                lots (
                start_time,
                product,
                description,
                image,
                opening_price,
                closing_time,
                price_increment,
                category_id,
                seller_id,
                )
                VALUES
                (NOW(), ?, ?, ?, ?, ?, ?, ?, 1)';

        $statement = db_get_prepare_stmt($connection, $add_lot_query,
            [
            $new_lot['product'],
            $new_lot['description'],
            $new_lot['image'],
            $new_lot['opening_price'],
            $new_lot['closing_time'],
            $new_lot['price_increment'],
            $category_id,
            ]
        );

        $result = mysqli_stmt_execute($statement);

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