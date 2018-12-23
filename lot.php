<?php

require_once 'functions/db.php';
require_once 'functions/filters.php';
require_once 'functions/template.php';
require_once 'functions/time.php';
require_once 'functions/validators.php';

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

$current_price = $one_lot['opening_price'];
$highest_bid = get_highest_bid_for_one_lot($connection, $lot_id);

$restricted_bidder = check_bidder_role($connection, $lot_id, $user['id']);

if ($highest_bid['amount'] !== null && $highest_bid['amount'] > $one_lot['opening_price']) {
    $current_price = $highest_bid['amount'];
}

$min_bid = $current_price + $one_lot['price_increment'];
$bids = get_all_bids_for_one_lot($connection, $lot_id);
$errors = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $add_bid = $_POST;
    $errors = validate_lot_bid_form($_POST, $min_bid);

    if ($errors === null && isset($user)) {
        $add_bid['buyer_id'] = $user['id'];
        $add_bid['amount'] = $_POST['new_bid'];
        $result = db_add_bid($connection, $add_bid, $lot_id);

        if (!$result) {
            die('При добавлении лота произошла ошибка');
        }

        header("Refresh: 0");
        exit;
    }
}

$page_content = include_template(
    'lot.php',
    ['categories' => $categories,
    'one_lot' => $one_lot,
    'user' => $user,
    'min_bid' => $min_bid,
    'current_price' => $current_price,
    'bids' => $bids,
    'restricted_bidder' => $restricted_bidder,
    'errors' => $errors]
);

$layout_content = include_template(
    'layout.php',
    ['title' => 'YetiCave - Лот',
    'user' => $user,
    'categories' => $categories,
    'content' => $page_content,]
);

print($layout_content);
