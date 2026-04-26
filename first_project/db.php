<?php

$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'dev';
$pass = getenv('DB_PASS') ?: '123456';
$db   = getenv('DB_NAME') ?: 'first_project';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}


