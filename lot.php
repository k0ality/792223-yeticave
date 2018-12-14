<?php

require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/time.php';

$is_auth = rand(0, 1);
$user_name = 'Снежок';
$user_avatar = 'img/user.jpg';

$config = require 'config.php';
$connection = connect($config['db']);

$categories = getAllCategories($connection);

if (isset($_GET['id'])) {
    $lot_id = $_GET['id'];
}
else {
    http_response_code(404);
    exit('Ошибка 404 - Страница не найдена');
}

$one_lot = getOneLot($connection, $lot_id);

if(!isset($one_lot['id'])) {
    http_response_code(404);
    exit('Ошибка 404 - Страница не найдена');
};

$page_content = include_template(
    'lot.php',
    ['categories' => $categories,
    'one_lot' => $one_lot]
);

$layout_content = include_template(
    'layout.php',
    ['title' => 'YetiCave - Лот',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'content' => $page_content,]
);

print($layout_content);
