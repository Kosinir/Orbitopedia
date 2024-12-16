<?php
$password = "Student1";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Zaszyfrowane hasło: " . $hashedPassword;
?>
