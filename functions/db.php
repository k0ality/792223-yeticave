<?php

function connect($config_db)
{
    $connection = mysqli_connect($config_db['host'], $config_db['user'], $config_db['password'], $config_db['database']);

    if (!$connection) {
        $error = mysqli_connect_error();
        die($error);
    }
    mysqli_set_charset($connection, "utf8");

    return $connection;
}

function db_get_prepare_stmt($connection, $query, $data = []) {
    $stmt = mysqli_prepare($connection, $query);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $function = 'mysqli_stmt_bind_param';
        $function(...$values);
    }

    return $stmt;
}

function db_add_lot($connection, $new_lot) {
    $add_lot_query = "INSERT INTO
                lots (
                'start_time',
                'seller_id',
                'product',
                'description',
                'image',
                'opening_price',
                'closing_time',
                'price_increment',
                'category_id'
                )
                VALUES
                (NOW(), 1, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = db_get_prepare_stmt($connection, $add_lot_query,
            [
                $new_lot['product'],
                $new_lot['description'],
                $new_lot['image'],
                $new_lot['opening_price'],
                $new_lot['closing_time'],
                $new_lot['price_increment'],
                $new_lot['category'],
            ]
        );

    $res = mysqli_stmt_execute($stmt);

    return $res;
}

function get_all_categories($connection)
{
    $db_categories = mysqli_query($connection, 'SELECT name FROM categories;');

    return mysqli_fetch_all($db_categories, MYSQLI_ASSOC);
}

function get_all_lots($connection)
{
    $lots_query = 'SELECT
    lots.id,
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

    $db_lots = mysqli_query($connection, $lots_query);

    return mysqli_fetch_all($db_lots, MYSQLI_ASSOC);
}

function get_one_lot($connection, $lot_id)
    {
    $lot_by_id_query = 'SELECT
    lots.id,
    lots.product,
    lots.description,
    lots.opening_price,
    lots.image,
    categories.name AS `cat_name`
    FROM
    lots
    INNER JOIN categories ON lots.category_id = categories.id
    WHERE
    lots.id =' . $lot_id;

    $db_one_lot = mysqli_query($connection, $lot_by_id_query);

    return mysqli_fetch_assoc($db_one_lot);
}

function get_category_id($connection, $category_name) {
    $category_id_query = 'SELECT
            id
            FROM
            categories 
            WHERE
            name = ' . mysqli_real_escape_string($connection, $category_name);

    $category_id = mysqli_query($connection, $category_id_query);

    return mysqli_fetch_assoc($category_id);
}
