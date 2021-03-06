<?php

define("INVALID_HINT", "Пожалуйста, исправьте ошибки в форме");
define("INVALID_REQUIRED", "Это поле надо заполнить");
define("INVALID_NO_FILE", "Вы не добавили изображение");
define("INVALID_FILE_TYPE", "Добавьте файл в формате JPG/JPEG, PNG или GIF");
define("INVALID_NOT_A_POSITIVE_INT", "Введите целое положительное число");
define("INVALID_DATE", "Введите дату (не ранее завтрашнего дня)");
define("INVALID_EMAIL", "Недействительный email");
define("INVALID_PASSWORD", "Мин 4 символа. Разрешена латиница, цифры, символы");
define("INVALID_CATEGORY", "Несуществующая категория");
define("EXISTING_EMAIL", "Пользователь с таким email уже зарегистрирован");
define("EXISTING_USERNAME", "Пользователь с таким именем уже зарегистрирован");
define("NONEXISTENT_EMAIL", "Пользователь с таким email ещё не зарегистрирован");
define("WRONG_PASSWORD", "Вы ввели неверный пароль");
define("INVALID_LOW_BID", "Ставка не может быть меньше текущей минимальной ставки");

/**
 * Business logic for validation of add lot form
 *
 * @param $post
 * @param $files
 * @param $connection
 * @return array|null
 */
function errors_validate_lot_form($post, $files, $connection)
{
    $required = ['product', 'category', 'description', 'opening_price', 'price_increment', 'closing_time'];
    $errors = notify_required_fields($post, $required);

    if (!check_isset_file($files)) {
        $errors['image'] = INVALID_NO_FILE;
    }

    if (!isset($errors['image']) && !validate_image($files)) {
        $errors['image'] = INVALID_FILE_TYPE;
    }

    if (!isset($errors['category']) && (check_category_id_exist_in_db($connection, $post['category']))) {
        $errors['category'] = INVALID_CATEGORY;
    }

    if (!isset($errors['opening_price']) && !validate_input_number($post['opening_price'])) {
        $errors['opening_price'] = INVALID_NOT_A_POSITIVE_INT;
    }

    if (!isset($errors['price_increment']) && !validate_input_number($post['price_increment'])) {
        $errors['price_increment'] = INVALID_NOT_A_POSITIVE_INT;
    }

    if (!empty($post['closing_time'])) {
        if (!validate_input_date($post['closing_time'])) {
            $errors['closing_time'] = INVALID_DATE;
        }
    }

    if (count($errors)) {
        $errors['hint'] = INVALID_HINT;
        return $errors;
    }

    return null;
}

/**
 * Business logic for validation of signup form
 *
 * @param $post
 * @param $files
 * @param $connection
 * @return array|null
 */
function errors_validate_sign_up_form($post, $files, $connection)
{
    $required = ['email', 'password', 'username', 'contact'];
    $errors = notify_required_fields($post, $required);

    if (!isset($errors['email']) && !(filter_var($post['email'], FILTER_VALIDATE_EMAIL))) {
        $errors['email'] = INVALID_EMAIL;
    }

    if (filter_var($post['email'], FILTER_VALIDATE_EMAIL) && !(check_email_exist_in_db($connection, $post['email']))) {
        $errors['email'] = EXISTING_EMAIL;
    }

    if (!isset($errors['password']) && !validate_password($post['password'])) {
        $errors['password'] = INVALID_PASSWORD;
    }

    if (!isset($errors['username']) && !check_username_exist_in_db($connection, $post['username'])) {
        $errors['username'] = EXISTING_USERNAME;
    }

    if (check_isset_file($files) && !validate_image($files)) {
        $errors['image'] = INVALID_FILE_TYPE;
    }

    if (count($errors)) {
        $errors['hint'] = INVALID_HINT;
        return $errors;
    }

    return null;
}

/**
 * Business logic for validation of login form
 *
 * @param $post
 * @param $connection
 * @return array|null
 */
function errors_validate_login_form($post, $connection)
{
    $required = ['email', 'password'];
    $errors = notify_required_fields($post, $required);

    if (!isset($errors['email']) && !(filter_var($post['email'], FILTER_VALIDATE_EMAIL))) {
        $errors['email'] = INVALID_EMAIL;
    }

    if (filter_var($post['email'], FILTER_VALIDATE_EMAIL) && (check_email_exist_in_db($connection, $post['email']))) {
        $errors['email'] = NONEXISTENT_EMAIL;
    }

    if (count($errors)) {
        return $errors;
    }

    return null;
}

/**
 * Business logic for validation of new bid form
 *
 * @param $post
 * @param $min_bid
 * @return array|null
 */
function validate_lot_bid_form($post, $min_bid)
{
    $required = ['new_bid'];
    $errors = notify_required_fields($post, $required);

    if (!isset($errors['new_bid']) && !validate_input_number($post['new_bid'])) {
        $errors['new_bid'] = INVALID_NOT_A_POSITIVE_INT;
    }

    if (validate_input_number($post['new_bid']) && $post['new_bid'] < $min_bid) {
        $errors['new_bid'] = INVALID_LOW_BID;
    }

    if (count($errors)) {
        return $errors;
    }

    return null;
}

/**
 * Return new array filled with data for each key of $required that is empty in $input
 *
 * @param array $input
 * @param array $required
 * @return array
 */
function notify_required_fields($input, $required)
{
    $errors = [];
    foreach ($required as $key) {
        if (empty($input[$key])) {
            $errors[$key] = INVALID_REQUIRED;
        }
    };

    return $errors;
}

/**
 * Check if param is a number and integer.
 *
 * @param string $input
 * @return bool
 */
function validate_input_number($input)
{
    $valid = false;
    if (ctype_digit($input) && $input > 0) {
        $pattern = '/^[1-9][0-9]{0,9}$/';
        $valid = preg_match($pattern, $input) && filter_var($input, FILTER_VALIDATE_INT);
    }

    return $valid;
}

/**
 * Check if param is a valid date in range.
 * Range from tomorrow to next year from current date.
 *
 * @param string $input
 * @return bool
 */
function validate_input_date($input)
{
    $user_date = date("Y-m-d", strtotime($input));
    $tomorrow = date("Y-m-d", strtotime('tomorrow'));
    $year_from_now = date('Y-m-d', strtotime(date('Y-m-d', time()) . ' + 1 year'));
    $valid = $user_date > $tomorrow && $user_date < $year_from_now;

    return $valid;
}

/**
 * Check if item was uploaded to param array.
 *
 * @param array $files
 * @return bool
 */
function check_isset_file($files)
{
    return isset($files['jpg_img']['name']) && !empty($files['jpg_img']['name']);
}

/**
 * Check if file is present in param array and is an image MIME-type.
 *
 * @param array $files
 * @return bool
 */
function validate_image($files)
{
    if (!isset($files['jpg_img']['tmp_name'])) {
        return false;
    }
    $file_name = $files['jpg_img']['tmp_name'];
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($file_info, $file_name);
    $valid = $file_type === "image/png" || $file_type === "image/jpeg" || $file_type === "image/jpg" || $file_type === "image/gif";

    return $valid;
}

/**
 * Check if param matches the pattern.
 * Returns 1 if the pattern matches, 0 if it does not, or FALSE if an error occurred.
 *
 * Regular expression pattern:
 * a to z, A to Z,
 * 0 to 9, - -  ~ ! @ # $% ^ & * ()
 * From 4 to 30 symbols total
 *
 * @param $input
 * @return false|int
 */
function validate_password($input)
{
    $pattern = '/^[A-Za-z0-9_~\-!@#$%^&*()]{4,30}$/';
    $valid = preg_match($pattern, $input);

    return $valid;
}

