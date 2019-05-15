<?php

/**
 * Format number with space as a thousands separator,
 * no decimals and RUB sign at the end.
 *
 * @param $price
 * @return string
 */
function format_price($price)
{
    $styled_price = ceil($price);
    if ($styled_price >= 1000) {
        $styled_price = number_format($styled_price, 0, null, ' ');
    }

    return $styled_price . ' ₽';
}

/**
 * Simple xss-filter.
 *
 * @param string $input
 * @return string
 */
function user_input_filter($input)
{
    return htmlspecialchars(strip_tags($input));
}
