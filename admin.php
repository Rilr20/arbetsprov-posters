<?php

$pageReference = $_GET['page'] ?? "index";

$base = basename(__FILE__, ".php");
$pages = [
    "index" => [
        "file" => __DIR__ . "/$base/index.php",
    ],
    "process" => [
        "file" => __DIR__ . "/$base/process.php",
    ],
    "ai" => [
        "file"=> __DIR__ . "/$base/ai.php",
    ],
];

$page =  $pages[$pageReference] ?? null;
require __DIR__ . "/config.php";
require __DIR__ . "/multipage/multipage.php";
?>
<!-- <h1>twat</h1> -->