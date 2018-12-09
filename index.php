<?php

require_once 'functions.php';

$is_auth = rand(0, 1);

$user_name = 'Снежок'; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';

$db = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => 'A7YWh8$#',
    'database' => 'yeticave'
];

$con = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

mysqli_set_charset($con, "utf8");

if (!$con) {
    $error = mysqli_connect_error();
    $page_content = include_template('pages/404.php', [
        'error' => $error
    ]);
} else {
    $categories_query = 'SELECT name FROM categories;';
    $result_categories = mysqli_query($con, $categories_query);

    if ($result_categories) {
        $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($con);
        $page_content = include_template('pages/404.php', [
            'error' => $error
        ]);
    }

    $lots_query = 'SELECT
    lots.product,
    lots.opening_price,
    lots.image,
    categories.name
    FROM
    lots
    INNER JOIN categories ON categories.id = lots.category_id
    WHERE
    lots.closing_time > CURRENT_TIMESTAMP()
    ORDER BY
    lots.start_time DESC;';

    if ($result_lots = mysqli_query($con, $lots_query)) {
        $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($con);
        $page_content = include_template('pages/404.php', [
            'error' => $error
        ]);
    }
}

$page_content = include_template(
    'index.php',
    ['categories' => $categories,
    'lots' => $lots]
);

$layout_content = include_template(
    'layout.php',
    ['title' => 'YetiCave - Главная страница',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'content' => $page_content,]
);

print($layout_content);
