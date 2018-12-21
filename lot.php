<?php

require_once 'data.php';
require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/time.php';
require_once 'functions/validators.php';

$config = require 'config.php';
$connection = connect($config['db']);

$categories = get_all_categories($connection);

if (!isset($_GET['id'])) {
    http_response_code(404);
    $error = http_response_code();
    error_template($error, $is_auth, $categories);
}

$lot_id = $_GET['id'];
$one_lot = get_one_lot($connection, $lot_id);

if (!isset($one_lot['id'])) {
    http_response_code(404);
    $error = http_response_code();
    error_template($error, $is_auth, $categories);
}

$current_price = $one_lot['opening_price'];
$highest_bid = get_highest_bid_for_one_lot($connection, $lot_id);

if ($highest_bid['amount'] !== null && $highest_bid['amount'] > $one_lot['opening_price']) {
    $current_price = $highest_bid['amount'];
}
$min_bid = $current_price + $one_lot['price_increment'];
$bids = get_all_bids_for_one_lot($connection, $lot_id);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $add_bid = $_POST;
    $result = validate_lot_bid_form($_POST, $min_bid);

    if ($result === true && isset($is_auth)) {
        $add_bid['buyer_id'] = $is_auth['id'];
        $add_bid['amount'] = $_POST['new_bid'];
        $add_bid['$result'] = db_add_bid($connection, $add_bid, $lot_id);

        if (!$add_bid['$result']) {
            die('При добавлении лота произошла ошибка');
        }

        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
    $errors = $result;
}

$page_content = include_template(
    'lot.php',
    ['categories' => $categories,
    'one_lot' => $one_lot,
    'is_auth' => $is_auth,
    'min_bid' => $min_bid,
    'current_price'=> $current_price,
    'bids'=> $bids]
);

$layout_content = include_template(
    'layout.php',
    ['title' => 'YetiCave - Лот',
    'is_auth' => $is_auth,
    'categories' => $categories,
    'content' => $page_content,]
);

print($layout_content);
