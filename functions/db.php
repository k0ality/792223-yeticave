<?php

function connect($configDb)
{
    $connection = mysqli_connect($configDb['host'], $configDb['user'], $configDb['password'], $configDb['database']);

    if (!$connection) {
        $error = mysqli_connect_error();
        die($error);
    }
    mysqli_set_charset($connection, "utf8");

    return $connection;
}

function getAllCategories($connection)
{
    $db_categories = mysqli_query($connection, 'SELECT name FROM categories;');

    return mysqli_fetch_all($db_categories, MYSQLI_ASSOC);;
}

function getAllLots($connection)
{
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

    $db_lots = mysqli_query($connection, $lots_query);

    return mysqli_fetch_all($db_lots, MYSQLI_ASSOC);
}
