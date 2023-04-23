<?php
require_once 'header.php';
require_once ROOT . 'functions/functions.php';

if (isset($_GET['mode']) && in_array($_GET['mode'], ['dark', 'lite'])) {
    setcookie('mode', $_GET['mode'], time() + (86400 * 30), "/"); // 86400 = 1 day
}

redirect($_SERVER['HTTP_REFERER']);
