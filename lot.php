<?php

require_once 'data.php';
require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/time.php';

$config = require 'config.php';
$connection = connect($config['db']);

$categories = get_all_categories($connection);

if (!isset($_GET['id'])) {
    http_response_code(404);
    $error = http_response_code();
    error_template($error, $is_auth, $user_name, $categories);
}

$lot_id = $_GET['id'];
$one_lot = get_one_lot($connection, $lot_id);

if (!isset($one_lot['id'])) {
    http_response_code(404);
    $error = http_response_code();
    error_template($error, $is_auth, $user_name, $categories);
}

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
