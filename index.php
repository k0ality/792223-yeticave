<?php

require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/time.php';

$is_auth = rand(0, 1);
$user_name = 'Снежок'; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';

$config = require 'config.php';
$connection = connect($config['db']);

$categories = getAllCategories($connection);
$lots = getAllLots($connection);

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
