<?php

function format_price($price)
{
    $styled_price = ceil($price);
    if ($styled_price >= 1000) {
        $styled_price = number_format($styled_price, 0, null, ' ');
    }
    return $styled_price . ' ₽';
}

function user_input_filter($string)
{
    return htmlspecialchars(strip_tags($string));
}

function validate_input_number($input)
{
    $valid = is_numeric($input) && $input > 0;
    return $valid;
}

function validate_input_date($date) {
    $date = strtotime($date);
    if (!$date || $date < strtotime('tomorrow')) {
        return false;
    }
    list($year, $month, $day) = explode('-', $date);
    return checkdate($month, $day, $year);
}
