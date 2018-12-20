<?php

require_once 'data.php';
require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/time.php';

$config = require 'config.php';
$connection = connect($config['db']);

$categories = get_all_categories($connection);
$lots = get_all_lots($connection);

$page_content = include_template(
    'index.php',
    ['categories' => $categories,
    'lots' => $lots]
);

$layout_content = include_template(
    'layout.php',
    ['title' => 'YetiCave - Главная страница',
    'is_auth' => $is_auth,
    'categories' => $categories,
    'content' => $page_content,]
);

print($layout_content);
