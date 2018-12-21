<?php

define("INVALID_HINT", "Пожалуйста, исправьте ошибки в форме");
define("INVALID_NO_FILE", "Вы не добавили изображение");
define("INVALID_FILE_TYPE", "Добавьте файл в формате JPG/JPEG, PNG или GIF");
define("INVALID_NOT_A_POSITIVE_INT", "Введите целое положительное число");
define("INVALID_DATE", "Введите дату (не ранее завтрашнего дня)");
define("INVALID_EMAIL", "Недействительный email");
define("INVALID_PASSWORD", "Мин 4 символа. Разрешена латиница, цифры, символы");
define("EXISTING_EMAIL", "Пользователь с таким email уже зарегистрирован");
define("EXISTING_USERNAME", "Пользователь с таким именем уже зарегистрирован");
define("NONEXISTENT_EMAIL", "Пользователь с таким email ещё не зарегистрирован");
define("WRONG_PASSWORD", "Вы ввели неверный пароль");

function validate_lot_form($post, $files)
{
    $required = ['product', 'category', 'description', 'opening_price', 'price_increment', 'closing_time'];
    $errors = notify_required_fields($post, $required);

    if (!check_isset_file($files)) {
        $errors['image'] = INVALID_NO_FILE;
    }

    if (!isset($errors['image']) && !validate_image($files)) {
        $errors['image'] = INVALID_FILE_TYPE;
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

function validate_sign_up_form($post, $files, $connection)
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

function validate_login_form($post, $connection)
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

function notify_required_fields($input, $required)
{
    $errors = [];
    foreach ($required as $key) {
        if (empty($input[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    };

    return $errors;
}

function validate_input_number($input)
{
    $valid = null;
    if (ctype_digit($input) && $input > 0) {
        $pattern = '/^[1-9][0-9]{0,9}$/';
        $valid = preg_match($pattern, $input) && filter_var($input, FILTER_VALIDATE_INT);
    }

    return $valid;
}

function validate_input_date($input)
{
    $user_date = date("Y-m-d", strtotime($input));
    $tomorrow = date("Y-m-d", strtotime('tomorrow'));
    $year_from_now = date('Y-m-d', strtotime(date('Y-m-d', time()) . ' + 1 year'));
    $valid = $user_date > $tomorrow && $user_date < $year_from_now;

    return $valid;
}

function check_isset_file($files)
{
    return isset($files['jpg_img']['name']) && !empty($files['jpg_img']['name']);
}

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

/* Allowed characters:
* a to z, A to Z
* 0 to 9
* - -  ~ ! @ # $% ^ & * ()
*/
function validate_password($input)
{
    $pattern = '/^[A-Za-z0-9_~\-!@#$%^&*()]{4,30}$/';
    $valid = preg_match($pattern, $input);

    return $valid;
}

