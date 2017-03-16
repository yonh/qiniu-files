<?php
$password = "your_password";
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "password: " . $hash . PHP_EOL;

