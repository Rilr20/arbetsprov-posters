<?php
require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
var_dump($_ENV['API_pexels']);
$name = preg_replace("/[^a-z\d]/i", "", __DIR__);
session_name($name);
session_start();
