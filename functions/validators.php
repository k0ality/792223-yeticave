<?php

function notify_required_fields($input, $required)
{
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

function validate_image($file_type)
{
    $valid = $file_type !== "image/png" & $file_type !== "image/jpeg" & $file_type !== "image/jpg");

    return $valid;
}

