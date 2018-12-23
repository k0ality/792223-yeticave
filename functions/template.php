<?php

function include_template($name, $data)
{
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

function error_template($error, $user, $categories)
{
    $error_content = include_template('error.php', [
        'error' => $error,
    ]);

    $layout_content = include_template(
        'layout.php',
        [
            'title' => 'YetiCave - Ошибка',
            'user' => $user,
            'categories' => $categories,
            'content' => $error_content,
        ]
    );

    print($layout_content);
    die;
}
