<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function format_price($price) {
    $styled_price = ceil($price);
    if ($styled_price >= 1000) {
        $styled_price = number_format($styled_price, 0, null, ' ');
    }
    return $styled_price . ' ₽';
}

function user_input_filter($string) {
    return htmlspecialchars(strip_tags($string));
}

function time_before_tomorrow() {
    $timer = strtotime('tomorrow') - strtotime('now');
    $hours = floor($timer / 3600);
    $minutes = floor(($timer % 3600) / 60);

    return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}
