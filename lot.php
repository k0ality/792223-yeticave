<?php

session_start();

require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/time.php';
require_once 'functions/auth.php';

$config = require 'config.php';
$connection = connect($config['db']);
$categories = get_all_categories($connection);
$user = auth_user_by_session($connection);

if (!isset($_GET['id'])) {
    http_response_code(404);
    $error = http_response_code();
    error_template($error, $user, $categories);
}

$lot_id = $_GET['id'];
$one_lot = get_one_lot($connection, $lot_id);

if (!isset($one_lot['id'])) {
    http_response_code(404);
    $error = http_response_code();
    error_template($error, $user, $categories);
}

$page_content = include_template(
    'lot.php',
    ['categories' => $categories,
    'one_lot' => $one_lot,
    'is_auth' => $user]
);

$layout_content = include_template(
    'layout.php',
    ['title' => 'YetiCave - Лот',
    'user' => $user,
    'categories' => $categories,
    'content' => $page_content,]
);

print($layout_content);
