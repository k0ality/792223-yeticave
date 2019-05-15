<?php

/**
 * Connect to the database.
 *
 * @param $config_db
 * @return mysqli connection resource|error
 */
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

/**
* Create a prepared statement based on the SQL query template and the passed data.
*
* @param mysqli $connection connection resource
* @param string $query SQL query with placeholders instead of values
* @param array $data Data for inserting into placeholders
*
* @return mysqli_stmt Prepared statement
*/
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

/**
 * Add new lot to a database.
 *
 * @param $connection
 * @param $new_lot
 * @param $seller_id
 * @return bool
 */
function db_add_lot($connection, $new_lot, $seller_id)
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
        (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = db_get_prepare_stmt(
        $connection,
        $add_lot_query,
        [
            user_input_filter($new_lot['product']),
            user_input_filter($new_lot['category']),
            user_input_filter($new_lot['description']),
            user_input_filter($new_lot['opening_price']),
            user_input_filter($new_lot['price_increment']),
            user_input_filter($new_lot['closing_time']),
            user_input_filter($new_lot['image']),
            $seller_id,
        ]
    );
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

/**
 * Add new user to a database.
 *
 * @param $connection
 * @param $sign_up_form
 * @return bool
 */
function db_add_user($connection, $sign_up_form)
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
            user_input_filter($sign_up_form['email']),
            user_input_filter($sign_up_form['password']),
            user_input_filter($sign_up_form['username']),
            user_input_filter($sign_up_form['contact']),
            user_input_filter($sign_up_form['image']),
        ]
    );
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

/**
 * Add new bid to a database.
 *
 * @param $connection
 * @param $bid
 * @param $lot_id
 * @return bool
 */
function db_add_bid($connection, $bid, $lot_id)
{
    $add_bid_query = "INSERT INTO
        bids (
        amount,
        buyer_id,
        lot_id
        )
        VALUES
        (?, ?, ?)";

    $stmt = db_get_prepare_stmt(
        $connection,
        $add_bid_query,
        [
            user_input_filter($bid['amount']),
            user_input_filter($bid['buyer_id']),
            $lot_id,

        ]
    );
    $result = mysqli_stmt_execute($stmt);

    return $result;
}

/**
 * Get all categories from a database.
 *
 * @param $connection
 * @return array|null
 */
function get_all_categories($connection)
{
    $db_categories = mysqli_query($connection, 'SELECT id, name, alias FROM categories ORDER BY id ASC');

    return mysqli_fetch_all($db_categories, MYSQLI_ASSOC);
}

/**
 * Get all active lots from a database from newest to oldest.
 *
 * @param $connection
 * @return array|null
 */
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

/**
 * Get a lot from a database by lot_id.
 *
 * @param $connection
 * @param $lot_id
 * @return array|null
 */
function get_one_lot($connection, $lot_id)
{
    $lot_by_id_query = 'SELECT
    lots.id,
    lots.product,
    lots.description,
    lots.opening_price,
    lots.price_increment,
    lots.seller_id,
    lots.image,
    lots.closing_time,
    categories.name AS `cat_name`
    FROM
    lots
    INNER JOIN categories ON lots.category_id = categories.id
    WHERE
    lots.id = "' . mysqli_real_escape_string($connection, $lot_id) . '"';

    $db_one_lot = mysqli_query($connection, $lot_by_id_query);

    return mysqli_fetch_assoc($db_one_lot);
}

/**
 * Get a user from a database by user_email.
 *
 * @param $connection
 * @param $email
 * @return array|null
 */
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

/**
 * Get a user from a database by user_id.
 *
 * @param $connection
 * @param $id
 * @return array|null
 */
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

/**
 * Get data for single biggest amount value in table bids for lot $lot_id
 *
 * @param $connection
 * @param $lot_id
 * @return array|null
 */
function get_highest_bid_for_one_lot($connection, $lot_id)
{
    $highest_bid_query = 'SELECT 
    amount
    FROM
    bids
    WHERE lot_id = "' . mysqli_real_escape_string($connection, $lot_id) . '"
    ORDER BY amount DESC
    LIMIT 1';

    $db_highest_bid = mysqli_query($connection, $highest_bid_query);

    return mysqli_fetch_assoc($db_highest_bid);
}

/**
 * Get all entries in table bids for lot $lot_id.
 * Sort from newest to oldest.
 *
 * @param $connection
 * @param $lot_id
 * @return array|null
 */
function get_all_bids_for_one_lot($connection, $lot_id)
{
    $all_bids_query = 'SELECT
    bids.*,
    users.username
    FROM
    bids
    JOIN users ON bids.buyer_id = users.id
    WHERE
    lot_id = "' . mysqli_real_escape_string($connection, $lot_id) . '"
    ORDER BY
    create_time DESC';

    $db_bids = mysqli_query($connection, $all_bids_query);

    return mysqli_fetch_all($db_bids, MYSQLI_ASSOC);
}

/**
 * Check if param $email already exists in users table.
 *
 * @param $connection
 * @param $email
 * @return bool
 */
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

/**
 * Check if param $username already exists in users table.
 *
 * @param $connection
 * @param $username
 * @return bool
 */
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

/**
 * Check if $user_id is does not exist as a buyer for $lot_id.
 * Only one bid allowed per user.
 *
 * @param $connection
 * @param $lot_id
 * @param $user_id
 * @return bool
 */
function check_bidder_role($connection, $lot_id, $user_id)
{
    $username_query = 'SELECT
    buyer_id
    FROM
    bids
    WHERE
    lot_id = "' . mysqli_real_escape_string($connection, $lot_id) . '"
    && buyer_id = "' . mysqli_real_escape_string($connection, $user_id) . '"
    LIMIT 1';

    $result = mysqli_query($connection, $username_query);
    $exists = mysqli_fetch_assoc($result);
    if ($exists !== null) {
        return true;
    }
    return false;
}

/**
 * Check if param $category_id already exists in categories table.
 *
 * @param $connection
 * @param $category_id
 * @return bool
 */
function check_category_id_exist_in_db($connection, $category_id)
{
    $category_id_query = 'SELECT 
    id
    FROM
    categories
    WHERE id = "' . mysqli_real_escape_string($connection, $category_id) . '"
    LIMIT 1';

    $result = mysqli_query($connection, $category_id_query);
    $exists = mysqli_fetch_assoc($result);
    if ($exists !== null) {
        return false;
    }
    return true;
}
