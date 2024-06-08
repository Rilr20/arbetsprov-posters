<?php

$name = preg_replace("/[^a-z\d]/i", "", __DIR__);
session_name($name);
session_start();
const PEXELSKEY = "xxjCiUcIHYdK5dqtEeqbJpf3b2dUmGrZLoi0ai4ueO9Nfkeoggmn6uB1";
