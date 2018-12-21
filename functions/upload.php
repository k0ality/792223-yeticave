<?php

function upload_image($files)
{
    $files['jpg_img']['name'];
    $file_name = $_FILES['jpg_img']['tmp_name'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $file_name);

    if ($file_type === "image/png") {
        $file_name = uniqid() . '.png';
    } elseif ($file_type === "image/jpg") {
        $file_name = uniqid() . '.jpg';
    } elseif ($file_type === "image/jpeg") {
        $file_name = uniqid() . '.jpeg';
    }

    $file_path = __DIR__ . '/../img/';
    move_uploaded_file($_FILES['jpg_img']['tmp_name'], $file_path . $file_name);

    return $file_name;
}

