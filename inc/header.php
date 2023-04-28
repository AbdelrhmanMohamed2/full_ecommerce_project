<?php
require_once 'url.php';
// if (strpos($_SERVER['REQUEST_URI'], '.php') !== false) {
//     $url = str_replace(basename($_SERVER['REQUEST_URI']), '', $_SERVER['REQUEST_URI']);
// } else {
//     $url = $_SERVER['REQUEST_URI'];
// }
// define('URL', 'http://' . $_SERVER['HTTP_HOST'] . $url);
// define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/' . $url);
// var_dump(ROOT)
?>
<!doctype html>
<html lang="en" <?php if (isset($_COOKIE['mode']) && $_COOKIE['mode'] == 'dark') : ?> data-bs-theme="dark" <?php endif ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= SITE_NAME ?></title>
    <link rel="icon" type="image/x-icon" href="<?= URL ?>inc/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>