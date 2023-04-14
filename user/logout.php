<?php
session_start();

include_once '../functions/functions.php';

session_destroy();

redirect('login.php');
