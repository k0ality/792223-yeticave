<?php

function upload_image($file_name, $file_type)
{
    if ($file_type === "image/png") {
        $file_name = uniqid() . '.png';
    } elseif ($file_type === "image/jpg") {
        $file_name = uniqid() . '.jpg';
    } elseif ($file_type === "image/jpeg") {
        $file_name = uniqid() . '.jpeg';
    }
    $file_path = __DIR__ . '/../img/';
    $file_url = '/img/' . $file_name;
    move_uploaded_file($_FILES['jpg_img']['tmp_name'], $file_path . $file_name);

    return $file_url;
}

