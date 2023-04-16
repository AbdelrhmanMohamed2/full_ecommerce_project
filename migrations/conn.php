<?php

const DB_HOST_NAME = 'localhost';
const DB_USER_NAME = 'root';
const DB_USER_PASSWORD = '';
const DB_NAME = 'full_ecommerce';


//#################################################################################
// create the database
function createDataBase()
{
    $conn = mysqli_connect(DB_HOST_NAME, DB_USER_NAME, DB_USER_PASSWORD);
    $sql = 'CREATE DATABASE IF NOT EXISTS ' . DB_NAME;

    var_dump(mysqli_query($conn, $sql));
    mysqli_close($conn);
}
//#################################################################################


//#################################################################################
// make connection
function getConnection()
{
    $conn = mysqli_connect(DB_HOST_NAME, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);

    if (!$conn) {
        die("connection error : " . mysqli_connect_error());
    }
    return $conn;
}
//#################################################################################



//#################################################################################
// create all tables
function createTables()
{
    $conn = getConnection();
    $tables = [
        'rolls' => 'CREATE TABLE IF NOT EXISTS `rolls` (
            `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            `name` VARCHAR (50) NOT NULL
        );',
        'users' => 'CREATE TABLE IF NOT EXISTS `users` (
            `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            `first_name` VARCHAR (50) NOT NULL,
            `last_name` VARCHAR (50) NOT NULL,
            `email` VARCHAR (50) NOT NULL UNIQUE,
            `password` VARCHAR (50) NOT NULL,
            `img` VARCHAR (50) NOT NULL,
            `roll` INT NOT NULL,
            FOREIGN KEY (`roll`) REFERENCES  `rolls`(`id`)

        );',
        'categories' => 'CREATE TABLE IF NOT EXISTS `categories` (
            `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            `name` VARCHAR (50) NOT NULL UNIQUE,
            `description` VARCHAR (50) NOT NULL,
            `logo` VARCHAR (50) NOT NULL
        );',
        'products' => 'CREATE TABLE IF NOT EXISTS `products` (
            `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            `name` VARCHAR (50) NOT NULL UNIQUE,
            `description` VARCHAR (50) NOT NULL,
            `category_id` INT NOT NULL,
            `price` INT NOT NULL,
            `stock` INT NOT NULL,
            FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
        );',
        'product_imgs' => 'CREATE TABLE IF NOT EXISTS `product_imgs` (
            `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            `img_path` VARCHAR (50) NOT NULL, 
            `product_id` INT NOT NULL,
            FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
        );',
    ];

    foreach ($tables as $table) {
        var_dump(mysqli_query($conn, $table));
    }

    mysqli_close($conn);
}
//#################################################################################


//#################################################################################
// create all rolls
function createRolls()
{
    $conn = getConnection();
    $rolls = [
        'super_admin' => 'INSERT INTO `rolls` (`name`) VALUES ("super_admin")',
        'admin' => 'INSERT INTO `rolls` (`name`) VALUES ("admin")',
        'user' => 'INSERT INTO `rolls` (`name`) VALUES ("user")',

    ];

    foreach ($rolls as $roll) {
        var_dump(mysqli_query($conn, $roll));
    }

    mysqli_close($conn);
}
//#################################################################################


//#################################################################################
// create super admin account
function createSuperAdmin()
{
    $conn = getConnection();

    $sql = 'INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `img`, `roll`) VALUES
     ("admin", "admin", "admin@admin.com", "admin", "..." , 1)';

    var_dump(mysqli_query($conn, $sql));



    mysqli_close($conn);
}
//#################################################################################


//#################################################################################
// create database, tables, add rolls and creating super admin account
function startWork()
{
    createDataBase();
    createTables();
    createRolls();
    createSuperAdmin();
}
//#################################################################################

// // uncomment to start all functions >>> 
// startWork();
