<?php

$is_auth = null;
$rate_add = [];

session_start();

if (isset($_SESSION['user'])) {
    $is_auth = $_SESSION['user'];
};
