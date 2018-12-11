<?php

ini_set('display_errors', 1);
ini_set('log_errors', 0);

$db   = 'carpooling';
$user = 'root';
$pass = '';
$charset = 'utf8';
$host = 'localhost';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass);
?>