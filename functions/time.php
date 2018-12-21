<?php

const SECONDS_PER_DAY = 86400;
const SECONDS_PER_HOUR = 3600;
const SECONDS_PER_MINUTE = 60;

function time_before_tomorrow()
{
    $timer = strtotime('tomorrow') - strtotime('now');
    $hours = floor($timer / SECONDS_PER_HOUR);
    $minutes = floor(($timer % SECONDS_PER_HOUR) / SECONDS_PER_MINUTE);

    return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}

function time_since_bid($string)
{
    $timer = strtotime('now') - strtotime($string);
    if ($timer > SECONDS_PER_DAY) {
        $time_ago = date('d.m.Y в H:i', strtotime($string));
    } elseif ($interval > SECONDS_PER_HOUR && $interval < SECONDS_PER_DAY) {
        $time_ago = floor($timer / SECONDS_PER_HOUR) . ' часов назад';
    } elseif ($interval > SECONDS_PER_MINUTE && $interval < SECONDS_PER_HOUR) {
        $time_ago = floor($timer / SECONDS_PER_MINUTE) . ' минут назад';
    } else {
        $time_ago = 'меньше минуты назад';
    }
    return $time_ago;
}
