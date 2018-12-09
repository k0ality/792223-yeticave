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
