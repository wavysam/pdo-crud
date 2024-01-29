<?php

define("DSN", "mysql:host=localhost;port=3306;dbname=pdocrud;charset=utf8mb4");
define("USER", "root");
define("PASSWORD", "");
define("OPTIONS", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ));

try {
    $connection = new PDO(DSN, USER, PASSWORD, OPTIONS);
} catch (PDOException $e) {
    echo $e->getMessage();
}