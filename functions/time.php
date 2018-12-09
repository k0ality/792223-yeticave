<?php

function time_before_tomorrow()
{
    $timer = strtotime('tomorrow') - strtotime('now');
    $hours = floor($timer / 3600);
    $minutes = floor(($timer % 3600) / 60);

    return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}
