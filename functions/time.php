<?php

const SECONDS_PER_DAY = 86400;
const SECONDS_PER_HOUR = 3600;
const SECONDS_PER_MINUTE = 60;

/**
 * Calculate hours and minutes left before midnight
 * Returns string in format HH:MM
 *
 * @return string
 */
function time_before_tomorrow()
{
    $timer = strtotime('tomorrow') - strtotime('now');
    $hours = floor($timer / SECONDS_PER_HOUR);
    $minutes = floor(($timer % SECONDS_PER_HOUR) / SECONDS_PER_MINUTE);

    return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}

/**
 * Format date time of param.
 *
 * @param $string
 * @return false|string
 */
function time_since_bid($string)
{
    $timer = strtotime('now') - strtotime($string);
    if ($timer > SECONDS_PER_DAY) {
        $time_ago = date('d.m.Y в H:i', strtotime($string));
    } elseif ($timer > SECONDS_PER_HOUR && $timer < SECONDS_PER_DAY) {
        $time_ago = floor($timer / SECONDS_PER_HOUR) . ' часов назад';
    } elseif ($timer > SECONDS_PER_MINUTE && $timer < SECONDS_PER_HOUR) {
        $time_ago = floor($timer / SECONDS_PER_MINUTE) . ' минут назад';
    } else {
        $time_ago = 'меньше минуты назад';
    }

    return $time_ago;
}

/**
 * Check expiration date.
 * Returns true if param is bigger than current date.
 *
 * @param $string
 * @return bool
 */
function lot_expiration_date($string)
{
    if (strtotime('now') > strtotime($string)) {
        return false;
    }

    return true;
}
