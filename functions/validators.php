<?php

//КОНСТАНТЫ

function validate_lot_form ($post, $files)
{
    $required = ['product', 'category', 'description', 'opening_price', 'price_increment', 'closing_time'];
    $errors = notify_required_fields($post, $required);

    if (!check_isset_file($files)) {
        $errors['image'] = 'Вы не добавили изображение';
    }

    if (!isset($errors['image']) && !validate_image($files)) {
        $errors['image'] = 'Добавьте файл в формате JPG/JPEG или PNG';
    }

    if (!isset($errors['opening_price']) && !validate_input_number($post['opening_price'])) {
        $errors['opening_price'] = 'Введите положительное число';
    }

    if (!isset($errors['price_increment']) && !validate_input_number($post['price_increment'])) {
        $errors['price_increment'] = 'Введите положительное число';
    }

    if (!empty($post['closing_time'])) {
        if (!validate_input_date($post['closing_time'])) {
            $errors['closing_time'] = 'Введите дату (не ранее завтрашнего дня)';
        }
    }

    if (count($errors)) {
        return $errors;
    }

    return true;
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
    $valid = is_numeric($input) && $input > 0;

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
    return isset($files['jpg_img']['name']) && !empty ($files['jpg_img']['name']);
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

