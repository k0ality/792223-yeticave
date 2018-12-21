<?php

function connect($config_db)
{
    $connection = mysqli_connect(
        $config_db['host'],
        $config_db['user'],
        $config_db['password'],
        $config_db['database']
    );

    if (!$connection) {
        $error = mysqli_connect_error();
        die($error);
    }
    mysqli_set_charset($connection, "utf8");

    return $connection;
}

function db_get_prepare_stmt(
    $connection,
    $query,
    $data = []
) {
    $stmt = mysqli_prepare($connection, $query);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            } elseif (is_string($value)) {
                $type = 's';
            } elseif (is_double($value)) {
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

function db_add_lot($connection, $new_lot)
{
    $add_lot_query = "INSERT INTO
        lots (
        product,
        category_id,
        description,
        opening_price,
        price_increment,
        closing_time,
        image,
        seller_id
        )
        VALUES
        (?, ?, ?, ?, ?, ?, ?, 1)";

    $stmt = db_get_prepare_stmt(
        $connection,
        $add_lot_query,
        [
            $new_lot['product'],
            $new_lot['category'],
            $new_lot['description'],
            $new_lot['opening_price'],
            $new_lot['price_increment'],
            $new_lot['closing_time'],
            $new_lot['image'],
        ]
    );
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

function db_add_user($connection, $sign_up)
{
    $add_lot_query = "INSERT INTO
        users (
        email,
        password,
        username,
        contact,
        avatar
        )
        VALUES
        (?, ?, ?, ?, ?)";

    $stmt = db_get_prepare_stmt(
        $connection,
        $add_lot_query,
        [
            $sign_up['email'],
            $sign_up['password'],
            $sign_up['username'],
            $sign_up['contact'],
            $sign_up['image'],
        ]
    );
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

function get_all_categories($connection)
{
    $db_categories = mysqli_query($connection, 'SELECT id, name FROM categories;');

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
    lots.id = "' . mysqli_real_escape_string($connection, $lot_id) . '"';

    $db_one_lot = mysqli_query($connection, $lot_by_id_query);

    return mysqli_fetch_assoc($db_one_lot);
}

function get_user_by_email($connection, $email)
{
    $user_info_query = 'SELECT 
    *
    FROM
    users
    WHERE email = "' . mysqli_real_escape_string($connection, $email) . '"';

    $user_info = mysqli_query($connection, $user_info_query);

    return mysqli_fetch_assoc($user_info);
}

function get_user_by_id($connection, $id)
{
    $user_id_query = 'SELECT 
    *
    FROM
    users
    WHERE id = "' . mysqli_real_escape_string($connection, $id) . '"';

    $user_info = mysqli_query($connection, $user_id_query);

    return mysqli_fetch_assoc($user_info);
}

function check_email_exist_in_db($connection, $email)
{
    $emails_query = 'SELECT 
    email
    FROM
    users
    WHERE email = "' . mysqli_real_escape_string($connection, $email) . '"
    LIMIT 1';

    $result = mysqli_query($connection, $emails_query);
    $exists = mysqli_fetch_assoc($result);
    if ($exists !== null) {
        return false;
    }
    return true;
}

function check_username_exist_in_db($connection, $username)
{
    $username_query = 'SELECT 
    username
    FROM
    users
    WHERE username = "' . mysqli_real_escape_string($connection, $username) . '"
    LIMIT 1';

    $result = mysqli_query($connection, $username_query);
    $exists = mysqli_fetch_assoc($result);
    if ($exists !== null) {
        return false;
    }
    return true;
}

